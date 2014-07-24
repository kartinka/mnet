<?php

class RequireLogin extends CBehavior
{
    public function attach($owner)
    {
        $owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
    }

    public function handleBeginRequest($event)
    { //var_dump(!strpos($_SERVER['REQUEST_URI'], 'home/index')); die();
        if (Yii::app()->user->isGuest && (!in_array($_SERVER['REQUEST_URI'], array('/mednet/user/login', 'user/login', '/mednet/user/registration','/mednet/user/recovery' )) && !strpos($_SERVER['REQUEST_URI'], 'home/index'))) {
            Yii::app()->user->loginRequired();
        }
    }

}