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
		return 'tbl_questions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text, author_id', 'required'),
			array('author_id', 'length', 'max'=>20),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('viewed', 'numerical', 'integerOnly' => true),
			array('detail, images, topics', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, text, detail, images, author_id', 'safe', 'on'=>'search'),
		);
	}

    public function scopes()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.

        return array(
            'answered' => array(
                'with'=> array("answersCount" => array(
                    'select'=> "answersCount",
                    )
                )
            ),
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
            'answers' => array(self::HAS_MANY, 'Answer', 'q_id', 'order'=>'answers.create_at DESC',),
            'answers_viewed'=> array(self::HAS_MANY, 'Answer', 'author_id', 'with' => 'questions', 'condition' => 't.author_id = ' . Yii::app()->user->id),
            'comments' => array(self::HAS_MANY, 'Comment', array('id' => 'a_id'), 'through' => 'answers', 'order' => 'a_id'),
            'topic' => array(self::BELONGS_TO, 'Topic', array('topics' => 'id')),
            'answered' => array(self::HAS_MANY, 'Answer', 'q_id', 'joinType' => 'INNER JOIN',  'order'=>'answered.create_at DESC',),
            //'views' =>  array(self::HAS_MANY, 'QuestionViewed', 'q_id', 'select' => 'SUM(viewed) as smth'),//array(self::STAT, 'QuestionViewed', 'q_id'),
            'question_viewed' => array(self::HAS_MANY, 'QuestionViewed', array('q_id'), 'with' => array('current_job')),
            'answersCount' => array(self::STAT, 'Answer', 'q_id'),
            'followers' => array(self::HAS_MANY, 'FollowQuestion', 'q_id', 'select' => 't.user_id', 'group' => 'q_id'),

            //'users' => array(self::HAS_ONE, 'User', 'user_id', 'through' => 'question_viewed'),
            //'users_jobs' => array(self::HAS_MANY, 'Job', array('id' => 'user_id'), 'through' => 'users'),

            //'most_active' => array(self::HAS_MANY, 'Answer', 'q_id', 'condition' => 'most_active.create_at BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()', 'group' => 'topics', 'order'=>'most_active.create_at DESC',  'limit' => 7),
            //'related_questions' => array(self::HAS_ONE, 'Question', 'id', 'alias' => 'another_q', 'condition' => 'related_questions.topics=another_q.topics', 'order'=>'related_questions.create_at DESC'),
            /*
            'users' => array(self::HAS_ONE, 'WebUser', array('author_id'=>'id'), 'through' => 'answers'),
            'profiles' => array(self::HAS_ONE, Yii::app()->getModule('user'), array('id'=>'author_id'), 'through' => 'users'),
            */
            'mad'=>array(self::STAT, 'Answer', 'q_id') //, 'joinType' => 'INNER JOIN', 'group' => 'q_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Question Text',
			'detail' => 'Question Detail',
			'images' => 'Images',
            'topics' => 'Topics',
			'author_id' => 'Question Author',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('author_id',$this->author_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getSuggest($q) {

        $c = new CDbCriteria();
        $c->with = array('answers', 'comments');
//      $c->with = array('comments');

        $c->addSearchCondition('t.text', $q, true, 'OR');
        $c->addSearchCondition('t.detail', $q, true, 'OR');

        $c->addSearchCondition('answers.text', $q, true, 'OR');
        $c->addSearchCondition('comments.text', $q, true, 'OR');

        return $this->findAll($c);

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
