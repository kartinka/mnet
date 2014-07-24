<?php

class HomeController extends Controller
{
    public $layout='//layouts/inner';
    public $defaultAction = 'index';
    protected $_user;
    protected $_profile;

    public function init() {
        if (Yii::app()->user->isGuest) {
            $this->forward('index');
        }
        $user_controller = Yii::app()->createController('User');
        $this->_user = $user_controller[0]->loadModel(Yii::app()->user->id);
        //$this->_user = $user->with(array('jobs' => array('condition' => 'jobs.to = 0000')))->findAll();
        $this->_profile = $this->_user->profile;
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index'),
                'users'=>array('*'),
            )
        );
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actionSearch()
    {
        // search among users
        if (isset($_GET['term'])) {
            $term = trim($_GET['term']);
            $results_user = User::model()->getSuggest($term);

            //search among questions
            $results_question = Question::model()->with('answersCount')->getSuggest($term);
            /*
            $answered = array();
            $unanswered = array();

            foreach ($results_question as $question) {
                if ($question->answersCount >0)
                    $answered[] = $question;
                else
                    $unanswered[] = $question;
            }

            $answered_provider = new CArrayDataProvider($answered,
                array( 'keyField' =>'id',
                    'pagination' => array(
                        'pageSize' => 15
                    )));

            $unanswered_provider = new CArrayDataProvider($unanswered,
                array( 'keyField' =>'id',
                    'pagination' => array(
                        'pageSize' => 15
                    )));
            */

            $questions = new CArrayDataProvider($results_question,
                array( 'keyField' =>'id',
                    'pagination' => array(
                        'pageSize' => 10
                    )));

            $users =  new CArrayDataProvider($results_user,
                array( 'keyField' =>'id',
                    'pagination' => array(
                        'pageSize' => 10
                    )));

            $this->render('search_results', array(
                'users' => $users,
                'questions' => $questions
                //'unanswered' => $unanswered_provider,
            ));
        }
    }

    protected function getDataForRightPane($questions = array())
    {
        $sql_most_active_discussions = "SELECT q.id, q.text, q.detail, COUNT( a.q_id ) AS count
                                        FROM tbl_questions q
                                        LEFT JOIN tbl_answers a ON q.id = a.q_id
                                        GROUP BY q.id
                                        ORDER BY count DESC , a.create_at DESC
                                        LIMIT 0 , 5";

        $most_active_discussions = Yii::app()->db->createCommand($sql_most_active_discussions)->setFetchMode(PDO::FETCH_OBJ)->queryAll();

        $invited = Message::model()->findAll(array('condition' => 'sender_id = ' . Yii::app()->user->id . ' AND is_invitation = "1"'));

        $already_invited = CHtml::listData($invited, 'id', 'receiver_id');
        if (empty($already_invited))
            $already_invited = array('-1');

        $criteria = new CDbCriteria();
        $criteria->select = array(
            '*',
            'rand() as rand',
            new CDbExpression('IF(user.id NOT IN (' . implode(',', $already_invited) .'), "btn btn-success", "btn btn-danger") as class'),
            new CDbExpression('IF(user.id NOT IN (' . implode(',', $already_invited) .'), "Invite", "Already <br /> Invited") as text')
        );
        $criteria->order = 'rand';
        $criteria->limit = 5;

        $criteria->condition = 'id <> ' . Yii::app()->user->id;
        $invitees = User::model()->with('profile')->findAll($criteria); //(array('select' => '*, rand() as rand', 'order' => 'rand', 'limit' =>5));

        $sql_most_active_topics = "SELECT * , SUM( IF( new.a_id IS NOT NULL , 1, 0 ) ) AS answers_number
                                        FROM (

                                        SELECT q.id AS q_id, a.id AS a_id, SUBSTRING( a.text, 1, 100 ) AS answer, a.author_id AS answerer, j.location AS location, t.text AS topic, p.firstname, p.lastname, u.profile_picture, a.create_at AS a_create_at, q.create_at AS q_create_at, q.text AS question, SUBSTRING( q.detail, 1, 100 ) AS detail, q.topics, q.images AS images, q.author_id AS inquirer
                                        FROM tbl_answers AS a
                                        RIGHT JOIN tbl_questions AS q ON q.id = a.q_id
                                        LEFT JOIN tbl_topics AS t ON q.topics = t.id
                                        LEFT JOIN tbl_profiles AS p ON a.author_id = p.user_id
                                        LEFT JOIN tbl_users AS u ON a.author_id = u.id
                                        LEFT JOIN (

                                        SELECT user_id, location
                                        FROM tbl_jobs jj
                                        WHERE jj.to =  '0000'
                                        GROUP BY user_id
                                        ) AS j ON a.author_id = j.user_id
                                        WHERE a.create_at BETWEEN NOW() - INTERVAL 5 DAY AND NOW()
                                        ORDER BY a.create_at DESC, q_id
                                        ) AS new
                                        GROUP BY new.topics
                                        ORDER BY answers_number DESC, a_create_at, q_create_at DESC
                                        LIMIT 0, 5";

        $topics = Yii::app()->db->createCommand($sql_most_active_topics)->setFetchMode(PDO::FETCH_OBJ)->queryAll();
        $followers = $this->_user->followed_by_people;

        $dataProvider_mad = new CArrayDataProvider($most_active_discussions,
            array( 'keyField' =>'id',
            ));

        $follow_people = User::model()->with(array('following' => array('condition' => 'following.user_id = ' . Yii::app()->user->id)))->findAll(); //findAll(array('select' => '*, COUNT()', 'group' => 't.q_id'));
        $follow_questions = Question::model()->with(array('followers' => array('condition' => 'user_id = ' . Yii::app()->user->id)))->findAll(); //findAll(array('select' => '*, COUNT()', 'group' => 't.q_id'));

        $people_array = CHtml::listData($follow_people, 'id', 'id');
        $questions_array = CHtml::listData($follow_questions, 'id', 'id');

        foreach ($questions as $key => &$question) {
            if (in_array($question->q_id, $questions_array))
                $question->q_text = 'Unfollow Question';
            else
                $question->q_text = 'Follow Question';

            if (in_array($question->inquirer, $people_array))
                $question->p_text = 'Unfollow';
            else
                $question->p_text = 'Follow';

        };

        return (array($invitees, $dataProvider_mad, $topics, $followers, $questions));
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{ //var_dump(Yii::app()->user); die();
        /*
        $sql = "select *, COUNT(*) as answers_number  from
                (SELECT  q.id AS q_id, a.id AS a_id, SUBSTRING(a.text, 1, 100) AS answer, a.author_id AS answerer, '0' as location, p.firstname, p.lastname, u.profile_picture, a.create_at AS create_at, q.text AS question, SUBSTRING(q.detail, 1, 100) AS detail, q.images AS images, q.author_id AS inquirer
                FROM tbl_answers AS a
                LEFT JOIN tbl_questions AS q ON q.id = a.q_id
                LEFT JOIN tbl_profiles AS p ON a.author_id = p.user_id
                LEFT JOIN tbl_users AS u ON a.author_id = u.id
                order by q.id, a.create_at desc
                ) as new
                GROUP BY new.q_id
                LIMIT 0 , 20";
        */

            $sql = "SELECT *, COUNT(*) as answers_number  from
                    (SELECT  q.id AS q_id, a.id AS a_id, SUBSTRING(a.text, 1, 100) AS answer, a.author_id AS answerer, j.location as location, p.firstname, p.lastname, u.profile_picture, a.create_at AS create_at, q.text AS question, SUBSTRING(q.detail, 1, 100) AS detail, q.images AS images, q.author_id AS inquirer
                    FROM tbl_answers AS a
                    LEFT JOIN tbl_questions AS q ON q.id = a.q_id
                    LEFT JOIN tbl_profiles AS p ON a.author_id = p.user_id
                    LEFT JOIN tbl_users AS u ON a.author_id = u.id
                    left join ( select user_id, location from tbl_jobs jj where jj.to = '0000' group by user_id) as j on a.author_id = j.user_id
                    order by q.id, a.create_at desc
                    ) as new
                    GROUP BY new.q_id
                    ORDER BY create_at desc";

            $questions = Yii::app()->db->createCommand($sql)->setFetchMode(PDO::FETCH_OBJ)->queryAll();

            /*
            $is_connected = FollowPeople::model()->find(array('condition' => 't.user_id = ' . Yii::app()->user->id . ' AND t.follow_user_id = ' . $id));

            if ($is_connected) {
                $follow_attributes = array('text' => 'Unfollow', 'class' => 'btn btn-danger');
            } else {
                $follow_attributes = array('text' => 'Follow', 'class' => 'btn btn-success');
            }

            $is_connected = FollowQuestion::model()->find(array('condition' => 't.user_id = ' . Yii::app()->user->id . ' AND t.q_id = ' . $id));

            if ($is_connected) {
                $follow_attributes = array('text' => 'Unfollow Question', 'class' => 'btn btn-danger');
            } else {
                $follow_attributes = array('text' => 'Follow Question', 'class' => 'btn btn-success');
            }
            */

            $dataProvider =  new CArrayDataProvider($questions,
                array( 'keyField' =>'q_id',
                    'pagination' => array(
                        'pageSize' => 4
                    )));

            if (!Yii::app()->user->isGuest) {

                list($invitees, $dataProvider_mad, $topics, $followers, $questions) = $this->getDataForRightPane($questions);

                $this->render('index', array(
                    'answered'=>true,
                    'user'=>$this->_user,
                    'profile'=>$this->_profile,
                    'questions' => $dataProvider,
                    'discussions' => $dataProvider_mad,
                    'topics' => $topics,
                    'invitees' => $invitees,
                    'followers' => $followers
                ));
            } else {
                $this->render('index_unauthorized', array(
                    'questions' => $dataProvider,
                ));
            }
	}

    /**
     * Unanswered questions
     */
    public function actionOpen()
    {
        // not answered questions

        /*
        $sql = "SELECT q.id AS q_id, a.id AS a_id, SUBSTRING(a.text, 1, 100) AS answer, a.author_id AS answerer, p.institution, p.firstname, p.lastname, u.profile_picture, a.create_at AS a_create_at, q.text AS question, SUBSTRING(q.detail, 1, 100) AS detail, q.images AS images, q.author_id AS inquirer,
                COUNT( q.id ) AS a_count, q_id
                FROM tbl_answers AS a
                RIGHT JOIN tbl_questions AS q ON q.id = a.q_id
                GROUP BY q.id
                HAVING q_id IS NULL
                ORDER BY a_count DESC
                LIMIT 0 , 30";
        */
        $sql = "SELECT q.id AS q_id, p.firstname, p.lastname, j.location, u.profile_picture, q.create_at AS create_at, q.text AS question, SUBSTRING(q.detail, 1, 100) AS detail, q.author_id AS inquirer
                FROM tbl_answers AS a
                RIGHT JOIN tbl_questions AS q ON q.id = a.q_id
                LEFT JOIN tbl_profiles AS p ON q.author_id = p.user_id
                LEFT JOIN tbl_users AS u ON q.author_id = u.id
                left join ( select user_id, location from tbl_jobs jj where jj.to = '0000' group by user_id) as j on a.author_id = j.user_id
				where q_id is NULL
				group by q.id
                order by  q.create_at desc, q.id";

        $questions = Yii::app()->db->createCommand($sql)->setFetchMode(PDO::FETCH_OBJ)->queryAll();

        list($invitees, $dataProvider_mad, $topics, $followers) = $this->getDataForRightPane($questions);

        $dataProvider =  new CArrayDataProvider($questions,
            array( 'keyField' =>'q_id',
                'pagination' => array(
                    'pageSize' => 10
                )));

        if (Yii::app()->user || !Yii::app()->user->isGuest) {
            $this->render('index', array('answered'=>false, 'user'=>$this->_user, 'profile'=>$this->_profile, 'questions' => $dataProvider, 'discussions' => $dataProvider_mad, 'topics' => $topics, 'invitees' => $invitees, 'followers' => $followers));
        }

    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}