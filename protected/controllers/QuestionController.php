<?php

class QuestionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/inner';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
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
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


    public function actionAll()
    {
            $sql_answered = "SELECT *, COUNT(*) as answers_number  from
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

            $questions_answered = Yii::app()->db->createCommand($sql_answered)->setFetchMode(PDO::FETCH_OBJ)->queryAll();
            if (!empty($questions_answered))
                $dataProvider_answered =  new CArrayDataProvider($questions_answered,
                    array( 'keyField' =>'q_id',
                        'pagination' => array(
                            'pageSize' => 10
                            )));
            else
                $dataProvider_answered = NULL;

            $sql_unanswered = "SELECT q.id AS q_id, p.firstname, p.lastname, j.location, u.profile_picture, q.create_at AS create_at, q.text AS question, SUBSTRING(q.detail, 1, 100) AS detail, q.author_id AS inquirer
                    FROM tbl_answers AS a
                    RIGHT JOIN tbl_questions AS q ON q.id = a.q_id
                    LEFT JOIN tbl_profiles AS p ON q.author_id = p.user_id
                    LEFT JOIN tbl_users AS u ON q.author_id = u.id
                    left join ( select user_id, location from tbl_jobs jj where jj.to = '0000' group by user_id) as j on a.author_id = j.user_id
                    where q_id is NULL
                    group by q.id
                    order by  q.create_at desc, q.id";

            $questions_unanswered = Yii::app()->db->createCommand($sql_unanswered)->setFetchMode(PDO::FETCH_OBJ)->queryAll();

            if (!empty($questions_unanswered))
                $dataProvider_unanswered =  new CArrayDataProvider($questions_unanswered,
                    array( 'keyField' =>'q_id',
                        'pagination' => array(
                            'pageSize' => 10
                        )));
            else
                $dataProvider_unanswered = NULL;

            $this->render('view_all',array(
                'questions_answered' => $dataProvider_answered,
                'questions_unanswered' => $dataProvider_unanswered,
            ));
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $question = Question::model()->with('topic')->findByPk($id);
        $question->viewed +=1;
        $question->save();

        /*
            $sql_viewed="INSERT INTO tbl_question_viewed (user_id, q_id) VALUES(:user_id,:q_id)";
            $command=$connection->createCommand($sql_viewed);
            $command->bindParam(":user_id", Yii::app()->user->id, PDO::PARAM_STR);
            $command->bindParam(":q_id", $id, PDO::PARAM_STR);
            $command->execute();
        */

        $viewed = new QuestionViewed;
        $viewed->user_id = Yii::app()->user->id;
        $viewed->q_id = $id;

        if ($viewed->validate()) {
            $viewed->save(false);
        }

        $related_questions = Question::model()->findAll(array('condition'=> "topics = :topics_param AND id <> :id_param", 'params'=>array(':id_param'=>$question->id, ':topics_param'=>$question->topics)));

        $related_questions_provider =  new CArrayDataProvider($related_questions,
            array('keyField' =>'id',
                'pagination' => array(
                    'pageSize' => 5
                )));

	    $sql = "SELECT q.id AS q_id, a.id AS a_id, a.text AS answer, a.author_id AS answerer, a.helpful, j.location as location, p.firstname, p.lastname, u.profile_picture, a.create_at AS create_at, q.text AS question, q.detail AS detail, q.topics, q.images AS images, q.author_id AS inquirer, q.viewed
                FROM tbl_answers AS a
                RIGHT JOIN tbl_questions AS q ON q.id = a.q_id
                LEFT JOIN tbl_profiles AS p ON a.author_id = p.user_id
                LEFT JOIN tbl_users AS u ON a.author_id = u.id
                left join ( select user_id, location from tbl_jobs jj where jj.to = '0000' group by user_id) as j on a.author_id = j.user_id
                WHERE q_id = " . $id .
                " ORDER BY q.id, a.create_at DESC";


        $answers = Yii::app()->db->createCommand($sql)->queryAll();

        $comments = $question->comments;

        foreach ($answers as &$answer) {
            $answer['comments'] = array();
            foreach ($comments as $comment) {
                if ($comment->a_id == $answer['a_id'])
                    $answer['comments'][] = $comment;
            }
        }

            $is_connected = FollowQuestion::model()->find(array('condition' => 't.user_id = ' . Yii::app()->user->id . ' AND t.q_id = ' . $id));

            if ($is_connected) {
                $follow_attributes = array('text' => 'Unfollow Question', 'class' => 'btn btn-danger');
            } else {
                $follow_attributes = array('text' => 'Follow Question', 'class' => 'btn btn-success');
            }
        $share = User::model()->with(array('following' => array('condition' => 'following.user_id = ' . Yii::app()->user->id)))->findAll(array('select' => '*, rand() as rand', 'order'=> 'rand', 'limit' => 4));

		$this->render('view',array(
			'answers'=>(object)$answers,
			'question'=>$question,
			'related_questions'=> $related_questions_provider,
			'add_answer'=> new Answer,
			'answer_errors' => NULL,
			'add_comment' => new Comment,
			'follow_attributes'=>$follow_attributes,
			'share'=>$share
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{   //var_dump(is_uploaded_file($_FILES['images']['tmp_name']));
		$model = new Question;

		/*
        $topics_list = ProfileField::model()->find(array('select' => 'list', 'condition' => 'varname = "subspecialties"'));
        $values = explode(';', $topics_list->list);
        foreach ($values as $key => $value) {
            $topics[$value] = $value;
        }
        */

        $topics = array();
        $topics_list = Topic::model()->findAll(array('select' => 'id, text'));
        foreach ($topics_list as $key => $value) {
            $topics[$value->id] = $value->text;
        }

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
            if ($_POST['Question']['id']) {
                $model->id = $_POST['Question']['id'];
            }

			$model->topics = (int)$_POST['Question']['topics'];
			if (isset($_POST['question_anonymous'])) // post anonymously
			    $model->author_id = -1;
			else
			    $model->author_id = Yii::app()->user->id;

			if ($_POST['Question']['detail'])
			    $model->detail = strip_tags($_POST['Question']['detail']);

            //$model->topics .= ';Radiation Oncology';

			if($model->save()) {
			    //add images
			    $images = '';
			    if (!empty($_FILES['images'])) {
                    $filePath = Yii::app()->basePath.'/../images/questions/' . $model->id . '/';
                    if (!file_exists($filePath))
                        mkdir($filePath);
                    foreach ($_FILES['images']['name'] as $key => $image_name) {
                        if (is_uploaded_file($_FILES['images']['tmp_name'][$key])) {
                            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                            if (in_array($ext, array('jpg', 'jpeg', 'gif', 'png')) && $_FILES['images']['size'][$key] <= 1048576) {
                                move_uploaded_file($_FILES['images']['tmp_name'][$key], $filePath . $image_name);
                                $images .= $image_name . ';';
                            } else {
                                Yii::app()->user->setFlash('incorrectImage', "Image format is incorrect or size is too big");
                                $new_model = $model;
                                $new_model->id = $model->id;
                                $model->deleteByPk($model->id);
                                unset($_FILES);
                                $this->render('create',array(
                                                'model'=>$new_model,
                                                'topics'=>$topics
                                        ));
                                return;
                            }
                        }
                    }
                    $model->images = $images;
                    $model->save();
                }

                // inform certain users about this question
                $message = new Message();
                $message->sender_id = Yii::app()->user->id;
                $message->receiver_id = $_POST['Message_receiver_id'];
                $message->subject = 'You have got new question';
                $message->body = CHtml::encode('You are invited to take a look at this ' . CHtml::link('question',
                        Yii::app()->baseUrl . '/question/view/id/' . $model->id, array('target' => '_blank')));

                $message->save();

                Yii::app()->user->setFlash('questionCreated', "Question was created successfully");
				$this->redirect(array('/home/index'));
			}

		}

		$this->render('create',array(
                'model'=>$model,
                'topics'=>$topics
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Question');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Question('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Question']))
			$model->attributes=$_GET['Question'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Question the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Question::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Question $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='question-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
