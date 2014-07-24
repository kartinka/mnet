<?php

/**
 * This is the model class for table "question".
 *
 * The followings are the available columns in table 'question':
 * @property string $_id
 * @property string $question_text
 * @property string $question_detail
 * @property string $followers
 * @property string $images
 * @property string $answers
 * @property string $question_author
 * @property integer $question_anonymous
 */
class QuestionViewed extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_question_viewed';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        return array(
            array('user_id', 'unique', 'criteria'=>array(
                'condition'=>'`q_id`=:q_id',
                'params'=>array(
                    ':q_id'=>$this->q_id
                ),
            ), 'on' => 'insert' ),
        );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'users' => array(self::HAS_MANY, 'User', array('id' => 'user_id')),
            //'jobs' => array(self::HAS_MANY, 'Job', array('id' => 'user_id'), 'through' => 'users', 'alias'=>'jj', 'select' => '*, IF(jobs.to = 0000, location, "NA") as location')
            'current_job' => array(self::HAS_MANY, 'Job', array('id' => 'user_id'), 'through' => 'users', 'joinType' => 'LEFT JOIN', 'on' => 'current_job.to = 0000')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Follower',
			'topic_id' => 'Followed Topic',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('topic_id',$this->topic_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Question the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
