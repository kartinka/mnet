<?php

class FollowingController extends Controller
{
	public $defaultAction = 'topics';
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
	public function actionTopic()
	{
        $is_connected = FollowTopic::model()->find(array('condition' => 't.user_id = ' . Yii::app()->user->id . ' AND t.topic_id = ' . $_POST['id']));

        if ($is_connected) { //var_dump($is_connected);
            // unfollow topic
            $is_connected->deleteByPk($is_connected->id);
            $data = array('id' => $_POST['id'], 'text' => 'Follow', 'class' => 'btn btn-success');
        } else {
            $model = new FollowTopic();
            $model->user_id = Yii::app()->user->id;
            $model->topic_id = $_POST['id'];

            if($model->save())
                $data = array('id' => $_POST['id'], 'text' => 'Unfollow', 'class' => 'btn btn-danger');
        }

        echo CJSON::encode($data);
	}

    public function actionPeople()
    {
        $is_connected = FollowPeople::model()->find(array('condition' => 't.user_id = ' . Yii::app()->user->id . ' AND t.follow_user_id = ' . $_POST['id']));

        if ($is_connected) { //var_dump($is_connected);
            // unfollow user
            $is_connected->deleteByPk($is_connected->id);
            $data = array('id' => $_POST['id'], 'text' => 'Follow', 'class' => 'btn btn-success');
        } else {
            $model = new FollowPeople();
            $model->user_id = Yii::app()->user->id;
            $model->follow_user_id = $_POST['id'];

            if($model->save()) {
                $data = array('id' => $_POST['id'], 'text' => 'Unfollow', 'class' => 'btn btn-danger');

                $receiver = User::model()->findByPk($_POST['id']);
                $notifications = UserNotifications::model()->findByPk($_POST['id']);

                if ($receiver && $notifications)
                    if ($notifications->follow_me == 1) {
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
                        $subject = 'You are followed at ' . Yii::app()->name . '!';
                        $message = 'You are now being followed by ' . CHtml::link($this->_user->profile->firstname . ' ' . $this->_user->profile->lastname,
                                'http://' . $_SERVER['HTTP_HOST']. Yii::app()->baseUrl . '/user/user/view/id/' . $this->_user->id);

                        UserModule::sendMail($receiver->email,$subject,$message);
                    }
            }
        }

        echo CJSON::encode($data);
    }

    public function actionQuestion()
    {
        $is_connected = FollowQuestion::model()->find(array('condition' => 't.user_id = ' . Yii::app()->user->id . ' AND t.q_id = ' . $_POST['id']));

        if ($is_connected) { //var_dump($is_connected);
            // unfollow question
            $is_connected->deleteByPk($is_connected->id);
            $data = array('id' => $_POST['id'], 'text' => 'Follow Question', 'class' => 'btn btn-success');
        } else {
            $model = new FollowQuestion();
            $model->user_id = Yii::app()->user->id;
            $model->q_id = $_POST['id'];

            if($model->save())
                $data = array('id' => $_POST['id'], 'text' => 'Unfollow Question', 'class' => 'btn btn-danger');
        }

        echo CJSON::encode($data);
    }

    public function actionTopicFeed() {

        $topics = Topic::model()->with(array('followers' => array('condition' => 'user_id = ' . Yii::app()->user->id), 'questionsCount'))->findAll(); //findAll(array('select' => '*, COUNT()', 'group' => 't.q_id'));
        //var_dump($topics); die();

        $topics_provider =  new CArrayDataProvider($topics,
            array('keyField' =>'id',
                'pagination' => array(
                    'pageSize' => 10
                )));

        $this->render('feed',
                array(
                    'title' => 'topic',
                    'data' => $topics_provider
                ));
    }

    public function actionQuestionFeed() {

        $questions = Question::model()->with(array('followers' => array('condition' => 'user_id = ' . Yii::app()->user->id), 'answersCount'))->findAll(); //findAll(array('select' => '*, COUNT()', 'group' => 't.q_id'));

        $questions_provider =  new CArrayDataProvider($questions,
            array('keyField' =>'id',
                'pagination' => array(
                    'pageSize' => 10
                )));

        $this->render('feed',
            array(
                'title' => 'question',
                'data' => $questions_provider
            ));
    }

    public function actionPeopleFeed() {

        $people = User::model()->with(array('following' => array('condition' => 'following.user_id = ' . Yii::app()->user->id), 'any_job'))->findAll(); //findAll(array('select' => '*, COUNT()', 'group' => 't.q_id'));

        $people_provider =  new CArrayDataProvider($people,
            array('keyField' =>'id',
                'pagination' => array(
                    'pageSize' => 10
                )));

        $this->render('feed',
            array(
                'title' => 'people',
                'data' => $people_provider
            ));
    }

    public function actionFollowers() {

        $following = User::model()->with(array('following' => array('condition' => 'following.user_id = ' . Yii::app()->user->id)))->findAll();

        $already_following = CHtml::listData($following, 'id', 'id');
        if (empty($already_following))
            $already_following = array('-1');

        $criteria = new CDbCriteria();
        $criteria->select = array(
            '*',
            new CDbExpression('IF(user.id NOT IN (' . implode(',', $already_following) .'), "btn btn-success", "btn btn-danger") as class'),
            new CDbExpression('IF(user.id NOT IN (' . implode(',', $already_following) .'), "Follow", "Unfollow") as text')
        );

        $followers = User::model()->with(array('followed' => array('condition' => 'followed.follow_user_id = ' . Yii::app()->user->id), 'any_job'))->findAll($criteria);

        $recommended = User::model()->with(array('recommended' => array('params' => array(':param' => Yii::app()->user->id))))->findAll(array('condition' => 'u.id <> ' . Yii::app()->user->id  . ' AND u.id NOT IN (' . implode(',', $already_following) . ')', 'alias' => 'u', 'limit' => 5, 'together' => true)); //(array('followed' => array('condition' => 'followed.follow_user_id = ' . Yii::app()->user->id, 'jointType' => 'LEFT JOIN')))->findAll(array('order' => 'followed.user_id'));

        $followers_provider =  new CArrayDataProvider($followers,
            array('keyField' =>'id',
                'pagination' => array(
                    'pageSize' => 10
                )));

        $this->render('followers',
            array(
                'data' => $followers_provider,
                'recommended' => $recommended,
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