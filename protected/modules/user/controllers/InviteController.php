<?php

class InviteController extends Controller
{
	public $defaultAction = 'topics';
	public $layout='//layouts/inner';
    private $_user;

    public function init()
    {
        $user_controller = Yii::app()->createController('User');
        $this->_user = $user_controller[0]->loadModel(Yii::app()->user->id);
    }

    public function actionSuggest()
    {
        $invited = Message::model()->findAll(array('condition' => 'sender_id = ' . Yii::app()->user->id . ' AND is_invitation = "1"'));

        $already_invited = CHtml::listData($invited, 'id', 'receiver_id'); //var_dump(implode(',', $already_invited)); die();
        if (empty($already_invited))
            $already_invited = array('-1');

        $criteria = new CDbCriteria();
        $criteria->select = array(
            '*',
           // 'rand() as rand',
            new CDbExpression('IF(user.id NOT IN (' . implode(',', $already_invited) .'), "btn btn-success", "btn btn-danger") as class'),
            new CDbExpression('IF(user.id NOT IN (' . implode(',', $already_invited) .'), "Invite", "Already <br /> Invited") as text')
        );

        $criteria->condition = 'id <> ' . Yii::app()->user->id;

        $invitees = User::model()->findAll($criteria);

        //$invitees = User::model()->findAll(array('condition' => 'user.id <> ' . Yii::app()->user->id , 'select' => 'IF(user.id NOT IN (' . implode(',', $already_invited) .'), "btn btn-success", "btn btn-danger") as class, *, rand() as rand', 'order' => 'rand'));

        $invitees_provider = new CArrayDataProvider($invitees,
            array( 'keyField' =>'id',
                'pagination' => array(
                    'pageSize' => 10
                )));

        $invited_provider = new CArrayDataProvider($invited,
            array( 'keyField' =>'id',
                'pagination' => array(
                    'pageSize' => 10
                )));

        $this->render('suggest',
            array(
                'invitees' => $invitees_provider,
                'invited' => $invited_provider
            ), false, true
        );
    }

    public function actionByemail()
    { //var_dump($_POST); die();
            $validator = new CEmailValidator;
            if ($_POST['invitees']) {
                $errors = array();
                $messages = array();
                $email_list = explode(',', trim($_POST['invitees']));
                foreach ($email_list as $i => $email) {  //var_dump($validator->validateValue(trim($email))); die();
                    if ($validator->validateValue(trim($email))) { //var_dump($email); die();
                        $invitee = User::model()->find(array('condition' => 'email = "' . trim($email) .'"')); //var_dump($invitee); die();
                        if ($invitee) {
                            $model = new Message();
                            $model->sender_id = Yii::app()->user->id;
                            $model->receiver_id = $invitee->id;
                            $model->subject = 'You are invited!';
                            $model->body = 'You are invited to follow ' . '<a class="namecard" target="_blank" href="' . Yii::app()->baseUrl . '/user/user/view/id/' . $this->_user->id . '">' . $this->_user->profile->firstname . ' ' . $this->_user->profile->lastname . '</a>' ;
                            $model->is_invitation = "1";

                            if(!$model->save()) {
                                $errors[] = "Invitation for " . $email . " has not been sent. Please, try again.";
                            } else {
                                $messages[] = "Invitation for " . $email . " has been sent successfully.";
                            }
                        } else {
                            $errors[] = "No user with email " . $email . " was found. Invitation has not been sent";
                        }
                    } else {
                        $errors[] = "Invitation for " . $email . " has not been sent due to incorrect email format";
                    }
                } //var_dump($errors); die();
                if (empty($errors)) {
                    Yii::app()->user->setFlash('inviteComplete', "Your invitations have been sent successfully. Thank you.");
                    $this->render('complete');
                } else {
                    $success_message = '';
                    $error_message = '<ul>';
                    foreach ($errors as $key => $error) {
                        $error_message .= '<li>' . $error . '</li>';
                    }
                    if (!empty($messages)) {
                        foreach ($messages as $k => $message)
                            $success_message .= '<li>' . $message . '</li>';
                    }
                    $error_message .= $success_message;

                    $error_message .= '</ul>';

                    Yii::app()->user->setFlash('inviteFailed', $error_message);
                    $this->redirect('suggest');
                }
            }
    }

    public function actionPeople()
    {
        $is_invited = Message::model()->find(array('condition' => 'sender_id = ' . Yii::app()->user->id . ' AND receiver_id = ' . $_POST['id'] . ' AND is_invitation = "1"'));

        /*
        if ($is_invited) { // to withdraw the invitation
            $is_invited->deleteByPk($is_invited->id);
            $data = array('id' => $_POST['id'], 'text' => 'Invite', 'class' => 'btn btn-success');
        }
        */

        if (!$is_invited) {
            $model = new Message();
            $model->sender_id = Yii::app()->user->id;
            $model->receiver_id = $_POST['id'];
            $model->subject = 'You are invited!';
            $model->body = CHtml::encode('You are invited to follow ' . CHtml::link(CHtml::encode($this->_user->profile->firstname . ' ' . $this->_user->profile->lastname),
                    array(Yii::app()->baseUrl . '/user/user/view/','id'=>$this->_user->id), array('target' => '_blank')));

            $model->is_invitation = "1";

            if($model->save()) {
                $data = array('id' => $_POST['id'], 'text' => 'Already Invited', 'class' => 'btn btn-danger');
                echo CJSON::encode($data);
            }

        } else {
            return;

        }
    }

}