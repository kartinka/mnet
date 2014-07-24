<?php

class UserController extends Controller
{
    public $layout='//layouts/inner';
    public $defaultAction = 'index';
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
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
            ),
        );
    }

    public function actionAll()
    {
        $users = User::model()->with('profile')->findAll(array('order' => 'profile.firstname asc, profile.lastname asc'));
        $dataProvider_users =  new CArrayDataProvider($users,
            array( 'keyField' =>'id',
                'pagination' => array(
                    'pageSize' => 7,
                )));

        $this->render('view_all',array(
            'users' => $dataProvider_users,
        ));
    }

	/**
	 * Displays a particular model.
	 */
	public function actionView($id)
	{
        if ($id == 'me' || $id === Yii::app()->user->id) { // current user (with possibility to edit own extended profile)
            $model = $this->loadUser(Yii::app()->user->id); //var_dump($model);
            $owner = true;
        }
        else {// any other member
            $model = $this->loadModel($id);
            $owner = false;

        }

        $profile=$model->profile;

        $jobs =  new CArrayDataProvider($model->jobs,
            array('keyField' =>'id',
        ));

        if (!$owner) {
            $recent_activity = Answer::model()->with('question')->findAll(array('condition' => 't.author_id = ' . $id, 'limit' => 3));

            $recent_activity_provider =  new CArrayDataProvider($recent_activity,
                array('keyField' =>'id',
                ));

            $is_connected = FollowPeople::model()->find(array('condition' => 't.user_id = ' . Yii::app()->user->id . ' AND t.follow_user_id = ' . $id));

            if ($is_connected) {
                $follow_attributes = array('text' => 'Unfollow', 'class' => 'btn btn-danger');
            } else {
                $follow_attributes = array('text' => 'Follow', 'class' => 'btn btn-success');
            }

            $this->render('view',array(
                'owner' => $owner,
                'model'=>$model,
                'profile'=>$profile,
                'jobs'=>$jobs,
                'recent_activity'=>$recent_activity_provider,
                'follow_attributes'=>$follow_attributes
            ));
        }
        else
            $this->render('view',array(
                'owner' => $owner,
                'model'=>$model,
                'profile'=>$profile,
                'jobs'=>$jobs,

            ));

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirectHome();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}
