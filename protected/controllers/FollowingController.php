<?php

class FollowingController extends Controller
{
    public $layout='//layouts/inner';
    protected $_user;
    protected $_profile;

    public function init() {
        $user_controller = Yii::app()->createController('User');
        $this->_user = $user_controller[0]->loadModel(Yii::app()->user->id);
        $this->_profile = $this->_user->profile;
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionPeople()
	{
        /*
        $sql = "select *, COUNT(*) as answers_number  from
                (SELECT  q.id AS q_id, a.id AS a_id, SUBSTRING(a.text, 1, 100) AS answer, a.author_id AS answerer, p.firstname, p.lastname, u.profile_picture, a.create_at AS create_at, q.text AS question, SUBSTRING(q.detail, 1, 100) AS detail, q.images AS images, q.author_id AS inquirer
                FROM tbl_answers AS a
                LEFT JOIN tbl_questions AS q ON q.id = a.q_id
                LEFT JOIN tbl_profiles AS p ON a.author_id = p.user_id
                LEFT JOIN tbl_users AS u ON a.author_id = u.id
                order by q.id, a.create_at desc
                ) as new
                GROUP BY new.q_id
                LIMIT 0 , 10";

        $questions = Yii::app()->db->createCommand($sql)->queryAll();
        */



        $this->render('index', array('answered'=>true, 'user'=>$this->_user, 'profile'=>$this->_profile, 'questions' => $questions));

	}

    /**
     * Unanswered questions
     */
    public function actionTopics()
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
        $sql = "SELECT q.id AS q_id, p.firstname, p.lastname, u.profile_picture, q.create_at AS create_at, q.text AS question, 	SUBSTRING(q.detail, 1, 100) AS detail, q.author_id AS inquirer
                FROM tbl_answers AS a
                RIGHT JOIN tbl_questions AS q ON q.id = a.q_id
                LEFT JOIN tbl_profiles AS p ON q.author_id = p.user_id
                LEFT JOIN tbl_users AS u ON q.author_id = u.id
				where q_id is NULL
				group by q.id
                order by q.id, q.create_at desc

                LIMIT 0 , 10";

        $questions = Yii::app()->db->createCommand($sql)->queryAll();

        if (Yii::app()->user || !Yii::app()->user->isGuest) {
            $this->render('index', array('answered'=>false, 'user'=>$this->_user, 'profile'=>$this->_profile, 'questions' => $questions));
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
	public function actionQuestions()
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