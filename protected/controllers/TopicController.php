<?php

class TopicController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'view', 'all'),
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
            $topics = Topic::model()->with('questionsCount')->findAll();
            $dataProvider_topics =  new CArrayDataProvider($topics,
                array( 'keyField' =>'id',
                    'pagination' => array(
                        'pageSize' => 10,
                       // 'route' => 'topic/view/',
                        //'pageVar' => 'id'
                    )));

            $this->render('view_all',array(
                'topics' => $dataProvider_topics,
            ));
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{   /*
        $sql = "SELECT * , SUM( IF( new.a_id IS NOT NULL , 1, 0 ) ) AS answers_number
                FROM (

                SELECT q.id AS q_id, a.id AS a_id, SUBSTRING( a.text, 1, 100 ) AS answer, a.author_id AS answerer, j.location AS location, p.firstname, p.lastname, u.profile_picture, a.create_at AS a_create_at, q.create_at AS q_create_at, q.text AS question, SUBSTRING( q.detail, 1, 100 ) AS detail, q.topics, q.images AS images, q.author_id AS inquirer
                FROM tbl_answers AS a
                RIGHT JOIN tbl_questions AS q ON q.id = a.q_id
                LEFT JOIN tbl_profiles AS p ON a.author_id = p.user_id
                LEFT JOIN tbl_users AS u ON a.author_id = u.id
                LEFT JOIN (

                SELECT user_id, location
                FROM tbl_jobs jj
                WHERE jj.to =  '0000'
                GROUP BY user_id
                ) AS j ON a.author_id = j.user_id
                WHERE q.topics = " . $id . "
                ORDER BY q.id, a.create_at DESC
                ) AS new
                GROUP BY new.q_id
                ORDER BY answers_number DESC, a_create_at, q_create_at DESC";
        */

            $topic = Topic::model()->findByPk($id);

            $sql_answered = "SELECT *, COUNT(*) as answers_number  from
                            (SELECT  q.id AS q_id, a.id AS a_id, SUBSTRING(a.text, 1, 100) AS answer, a.author_id AS answerer, j.location as location, p.firstname, p.lastname, u.profile_picture, a.create_at AS create_at, q.text AS question, SUBSTRING(q.detail, 1, 100) AS detail, q.images AS images, q.author_id AS inquirer
                            FROM tbl_answers AS a
                            LEFT JOIN tbl_questions AS q ON q.id = a.q_id
                            LEFT JOIN tbl_profiles AS p ON a.author_id = p.user_id
                            LEFT JOIN tbl_users AS u ON a.author_id = u.id
                            left join ( select user_id, location from tbl_jobs jj where jj.to = '0000' group by user_id) as j on a.author_id = j.user_id
                            WHERE q.topics = " . $id . "
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
                    where q_id is NULL AND q.topics = " . $id . "
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

            $is_connected = FollowTopic::model()->find(array('condition' => 't.user_id = ' . Yii::app()->user->id . ' AND t.topic_id = ' . $id));

            if ($is_connected) {
                $follow_attributes = array('text' => 'Unfollow', 'class' => 'btn btn-danger');
            } else {
                $follow_attributes = array('text' => 'Follow', 'class' => 'btn btn-success');
            }

            $this->render('view',array(
                'topic' => $topic,
                'questions_answered' => $dataProvider_answered,
                'questions_unanswered' => $dataProvider_unanswered,
                'follow_attributes'=>$follow_attributes
            ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Topic;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Topic']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->_id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['Topic']))
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
