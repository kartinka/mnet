<?php

class ComposeController extends Controller
{
	public $defaultAction = 'compose';
    public $layout='//layouts/inner';

	public function actionCompose($id = null) {
		$message = new Message();
		if (Yii::app()->request->getPost('Message')) {
            $message_data = Yii::app()->request->getPost('Message');
			$receiverName = Yii::app()->request->getPost('receiver');
		    $message->attributes = Yii::app()->request->getPost('Message');
			$message->sender_id = Yii::app()->user->getId();
			if ($message->save()) {
				Yii::app()->user->setFlash('messageModule', MessageModule::t('Message has been sent'));
                // notification
                $receiver = User::model()->findByPk($message_data['receiver_id']);
                $notifications = UserNotifications::model()->findByPk($message_data['receiver_id']);

                if ($receiver && $notifications)
                    if ($notifications->private_message == 1) {
                        $subject = 'Private message has been sent to you at ' . Yii::app()->name . '!';
                        $message = 'You have received a private message. You can check for it in ' . CHtml::link('your inbox',
                                'http://' . $_SERVER['HTTP_HOST']. Yii::app()->baseUrl . '/message/inbox');

                        UserModule::sendMail($receiver->email,$subject,$message);
                    }


                $this->redirect($this->createUrl('inbox/'));
			} else if ($message->hasErrors('receiver_id')) {
				$message->receiver_id = null;
				$receiverName = '';
			}
		} else {
			if ($id) {
				$receiver = call_user_func(array(call_user_func(array(Yii::app()->getModule('message')->userModel, 'model')), 'findByPk'), $id);
				if ($receiver) {
					$receiverName = call_user_func(array($receiver, Yii::app()->getModule('message')->getNameMethod));
					$message->receiver_id = $receiver->id;
				}
			}
		}
		$this->render(Yii::app()->getModule('message')->viewPath . '/compose', array('model' => $message, 'receiverName' => isset($receiverName) ? $receiverName : null));
	}
}
