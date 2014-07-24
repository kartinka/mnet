<?php

class AnswerController extends Controller
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
				'actions'=>array('create','comment', 'helpful', 'share'),
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


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if(isset($_POST['Answer']))
		{
            $model = new Answer;
            $model->attributes=$_POST['Answer'];

            $model->text = strip_tags($_POST['Answer']['text']);

            if($model->save()) {
                $receivers = User::model()->with(array('follow_question' => array('condition' => 'follow_question.q_id = ' . $_POST['Answer']['q_id'])))->findAll();
                if ($receivers) {
                    foreach ($receivers as $key => $receiver) {
                        $notifications = UserNotifications::model()->findByPk($receiver->id);

                        if ($receiver && $notifications)
                            if ($notifications->answer_to_question == 1) {

                                $subject = 'Question has been answered at ' . Yii::app()->name . '!';
                                $message =  CHtml::link('Question',
                                        'http://' . $_SERVER['HTTP_HOST']. Yii::app()->baseUrl . '/question/view/id/' . $_POST['Answer']['q_id']) . ' you are following has been answered.';

                                UserModule::sendMail($receiver->email,$subject,$message);
                            }
                    }
                }

                Yii::app()->user->setFlash('questionAnswered', "Question was answered successfully");
                $this->redirect($this->createUrl('/home/index'));
            } else {
                $errors = $model->getErrors();
                $error_message = '<ul>';
                foreach ($errors['text'] as $error) {
                    $error_message .= '<li>' . $error . '</li>';
                }
                $error_message .= '</ul>';

                Yii::app()->user->setFlash('answerFailed', $error_message);
                $this->redirect($this->createUrl('/question/view/'. $_POST['Answer']['q_id']));
            }
		}

	}

    public function actionHelpful()
    {   /*
        $notifications = UserNotifications::model()->findByPk($_POST['answerer_id']);

        if ($notifications)
            if ($notifications->vote_on_answer == 1) {
                /*
                $model = new Message();
                $model->sender_id = Yii::app()->user->id;
                $model->receiver_id = $_POST['answerer_id'];
                $model->subject = 'Your answer has been voted!';
                //$model->body = 'Your ' . '<a target="_blank" href="' . Yii::app()->baseUrl . '/question/view/id/' . $_POST['question_id'] . '">' . ' answer</a> has been marked as Helpful.' ;
                $model->body = 'Your ' . CHtml::link(CHtml::encode('answer', array(Yii::app()->baseUrl . '/question/view/','id'=>$_POST['question_id']), array('target' => '_blank')) . ' has been marked as Helpful.' ;

                $model->save();
                */ /*
                $subject = 'Your answer has been voted at ' . Yii::app()->name . '!';
                $message = 'Your ' . CHtml::link('answer',
                        'http://' . $_SERVER['HTTP_HOST']. Yii::app()->baseUrl . '/question/view/id/' . $_POST['question_id']) . ' has been marked as Helpful';

                UserModule::sendMail($receiver->email,$subject,$message);

            }
        */
        $answer = Answer::model()->findByPk($_POST['id']);
        $answer->helpful +=1;
        if ($answer->save()) {
            $receiver = User::model()->findByPk($_POST['answerer_id']);
            $notifications = UserNotifications::model()->findByPk($_POST['answerer_id']);

            if ($receiver && $notifications)
                if ($notifications->vote_on_answer == 1) {
                    /*
                    $model = new Message();
                    $model->sender_id = $this->_user->id;
                    $model->receiver_id = $_POST['id'];
                    $model->subject = 'You are followed!';
                    //$model->body = CHtml::encode('You are now being followed by ' . '<a target="_blank" href="' . Yii::app()->baseUrl . '/user/user/view/id/' . $this->_user->id . '">' . $this->_user->profile->firstname . ' ' . $this->_user->profile->lastname . '</a>');
                    $model->body = CHtml::encode('You are now being followed by ' . CHtml::link(CHtml::encode($this->_user->profile->firstname . ' ' . $this->_user->profile->lastname),
                            array(Yii::app()->baseUrl . '/user/user/view/','id'=>$this->_user->id), array('target' => '_blank')));


                    $model->save();
                    */
                    $subject = 'Your answer at ' . Yii::app()->name . ' is helpful!';
                    $message = 'Your ' . CHtml::link('answer',
                            'http://' . $_SERVER['HTTP_HOST']. Yii::app()->baseUrl . '/question/view/id/' . $_POST['question_id']) . ' has been marked as Helpful';

                    UserModule::sendMail($receiver->email,$subject,$message);
                }
            $data = array('id' => $_POST['id'], 'class' => 'btn btn-danger');

        }

        echo CJSON::encode($data);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionComment()
    {

        if(isset($_POST['Comment']))
        {
            $model = new Comment;
            //$model->attributes=$_POST['Comment'];
            $model->a_id = $_POST['answer_id'];
            $model->author_id = $_POST['author_id'];

            $model->text = strip_tags($_POST['Comment']['text']);

            if($model->save()) {
                $receivers = User::model()->with(array('follow_question' => array('condition' => 'follow_question.q_id = ' . $_POST['question_id'])))->findAll();
                if ($receivers) {
                    foreach ($receivers as $key => $receiver) {
                        $notifications = UserNotifications::model()->findByPk($receiver->id);

                        if ($receiver && $notifications)
                            if ($notifications->comment_on_question == 1) {

                                $subject = 'Question has been commented at ' . Yii::app()->name . '!';
                                $message =  CHtml::link('Question',
                                    'http://' . $_SERVER['HTTP_HOST']. Yii::app()->baseUrl . '/question/view/id/' . $_POST['question_id']) . ' you are following has been commented ';

                                UserModule::sendMail($receiver->email,$subject,$message);
                            }
                    }
                }
                Yii::app()->user->setFlash('answerCommented', "Comment was posted successfully");
                $this->redirect($this->createUrl('/question/view/id/' . $_POST['question_id']));
            }

        }

    }

    public function actionShare() {

        $model = new Message();
        $model->sender_id = Yii::app()->user->id;
        $model->receiver_id = $_POST['id'];
        $model->subject = 'You are recommended an answer!';
        $model->body = CHtml::encode('I suggest you taking a look at this ' . CHtml::link('answer',
                Yii::app()->baseUrl . '/question/view/id/' . $_POST['question_id'] .'#answer_'. $_POST['answer_id']), array('target' => '_blank'));

        if ($model->save()) {
            $data = array('id' => $_POST['id'], 'answer_id' => $_POST['answer_id'], 'text' => 'Sent', 'color' => '#a19d9d;', 'href' => '#');
            echo CJSON::encode($data);
        }

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

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Question');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='answer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
