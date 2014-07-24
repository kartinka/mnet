<?php

class UserNotifications extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return Yii::app()->getModule('user')->tableUserNotifications;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.CConsoleApplication
        return ( array(
           // array('id, follow_me, comment_on_question, answer_to_question, vote_on_answer, private_message, newsletter_sent', 'allowEmpty'=>true),
            array('follow_me, comment_on_question, answer_to_question, vote_on_answer, private_message, newsletter_sent', 'in', 'range'=>array(0, 1)),
            array('id, follow_me, comment_on_question, answer_to_question, vote_on_answer, private_message, newsletter_sent', 'safe', 'on'=>'update'))
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $relations = array(
            'user_id'=>array(self::BELONGS_TO, 'User', 'id'),
        );

        return $relations;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => UserModule::t("Id"),
            'follow_me'=>UserModule::t("When someone follows me"),
            'comment_on_question'=>UserModule::t("When someone makes a comment to a question I follow"),
            'answer_to_question'=>UserModule::t("When someone answers a question I follow"),
            'vote_on_answer'=>UserModule::t("When someone votes on an answer I wrote"),
            'private_message'=>UserModule::t("When someone sends me a private message"),
            'newsletter_sent'=>UserModule::t("When a newsletter is sent out"),
        );
    }

}