<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	public $layout='//layouts/inner';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
		$model = $this->loadUser();
	    $this->render('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];

            $profile->subspecialties = implode(';', $_POST['Profile']['subspecialties']);
            $profile->degrees = implode(';', $_POST['Profile']['degrees']);
            $profile->interests = $_POST['Profile']['interests'];
            $profile->zipcode = $_POST['Profile']['zipcode'];

			if($model->validate()&&$profile->validate()) {
				$model->save();
				$profile->save();

                Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Profile changes have been saved"));
				$this->redirect(array('/home/index'));
			} else $profile->validate();
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserPictureUpload'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

    /**
     * Profile picture upload
     */
    public function actionPictureupload() {
        if(Yii::app()->user->id)
            $model=$this->loadUser();
        else
            $model=new User;

            if(isset($_POST['User'])) {
                if(isset($_POST['User']['profile_picture'])){

                    //$model->attributes=$_POST[''];
                    //if($model->validate()) {
                        $profile_picture_old = $model->profile_picture;
                        $model->profile_picture = CUploadedFile::getInstance($model,'profile_picture');
                        $fileName = Yii::app()->basePath.'/../images/profile/'.Yii::app()->user->id.'.'.$model->profile_picture->extensionName;
                        if($model->validate()) {
                            if($model->save()){
                                $model->profile_picture->saveAs($fileName);
                                $model->profile_picture = Yii::app()->user->id.'.'.$model->profile_picture->extensionName;
                                $model->save();
                            }
                        } else {
                            $model->profile_picture = $profile_picture_old;
                        }
                }
            }
            $this->render('pictureupload',array('model'=>$model));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}