<?php

class NotificationsController extends Controller
{
	public $defaultAction = 'edit';
	public $layout='//layouts/inner';
    private $_user;

    public function init() {
        $user_controller = Yii::app()->createController('User');
        $this->_user = $user_controller[0]->loadModel(Yii::app()->user->id);
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
        if ($this->_user)
            $model = $this->loadModel($this->_user->id);
        else
            $model = new UserNotifications();

		if(isset($_POST['UserNotifications']))
		{
			$model->attributes=$_POST['UserNotifications'];
            $model->user_id = $this->_user->id;

			if($model->save()) {
                Yii::app()->user->updateSession();
				$this->redirect(array('/home/index'));
			}
		}

		$this->render('edit',array(
			'model'=>$model,
		));
	}

    public function loadModel($id)
    {
        $model=UserNotifications::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
	
}