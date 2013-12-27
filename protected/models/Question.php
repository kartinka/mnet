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
class Question extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'question';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('_id, question_text, answers, question_author, question_anonymous', 'required'),
			array('question_anonymous', 'numerical', 'integerOnly'=>true),
			array('_id, question_author', 'length', 'max'=>20),
			array('question_detail, followers, images', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('_id, question_text, question_detail, followers, images, answers, question_author, question_anonymous', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'_id' => 'ID',
			'question_text' => 'Question Text',
			'question_detail' => 'Question Detail',
			'followers' => 'Followers',
			'images' => 'Images',
			'answers' => 'Answers',
			'question_author' => 'Question Author',
			'question_anonymous' => 'Post anonymously',
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

		$criteria->compare('_id',$this->_id,true);
		$criteria->compare('question_text',$this->question_text,true);
		$criteria->compare('question_detail',$this->question_detail,true);
		$criteria->compare('followers',$this->followers,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('answers',$this->answers,true);
		$criteria->compare('question_author',$this->question_author,true);
		$criteria->compare('question_anonymous',$this->question_anonymous);

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
