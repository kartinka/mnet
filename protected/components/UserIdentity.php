<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */

    private $_id;

	public function authenticate()
	{
        $record=User::model()->findByAttributes(array('username'=>$this->username));
        if($record===null)
        {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        else if($record->password!==$this->password) //md5($this->password))
        {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        }
        /*else if($record->IsDeleted) TODO: user activation
        {
            $this->errorCode=self::ERROR_USER_INACTIVE;
        }*/
        else
        {
            $this->_id=$record->_id;
            $this->setState('username', $record->username);
            $this->setState('specialty', $record->specialty);
            $this->setState('institution', $record->institution);
            //$this->setState('isAdmin', $record->IsAdmin);

            $this->errorCode=self::ERROR_NONE;

            $auth=Yii::app()->authManager;
            /*
            $bizRule='return Yii::app()->user->role === "admin";';
            $auth->createRole('admin', 'Administrator', $bizRule);

            $bizRule='return Yii::app()->user->role === "authenticated";';
            $auth->createRole('admin', 'Authenticated User', $bizRule);

            $bizRule='return Yii::app()->user->isGuest;';
            $auth->createRole('guest', 'Guest', $bizRule);
            */
        }
        return !$this->errorCode;

	}

    public function getId()
    {
        return $this->_id;
    }
    /*
    public static function IsAdmin(){
        //return Yii::app()->user->checkAccess(UserRoles::SuperAdmin);
        return Yii::app()->user->admin;
    }

    public static function IsAuthenticated(){
        //return Yii::app()->user->checkAccess(UserRoles::SuperAdmin);
        return Yii::app()->user->authenticated;
    }

    public static function Guest(){
        //return Yii::app()->user->checkAccess(UserRoles::SuperAdmin);
        return Yii::app()->user->guest;
    }
    */
}