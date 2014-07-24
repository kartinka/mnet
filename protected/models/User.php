<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $active
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $speciality
 * @property string $institution
 * @property integer $invite_code
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email, first_name, middle_name, last_name, speciality, invite_code', 'required'),
            array('username',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                'message' => 'Invalid characters in username.',
            ),
            array('active, invite_code', 'numerical', 'integerOnly'=>true, 'allowEmpty'=>true),
			array('username, first_name, last_name', 'length', 'max'=>50),
            array('middle_name', 'length', 'max'=>50, 'allowEmpty'=>true),
			array('password', 'length', 'max'=>128),
			array('email, speciality', 'length', 'max'=>100),
			//array('institution', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('_id, username, email, first_name, middle_name, last_name, speciality, invite_code', 'safe', 'on'=>'search'),
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
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'active' => 'Active',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'speciality' => 'Speciality',
			//'institution' => 'Institution',
			'invite_code' => 'Invite Code',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('specialty',$this->speciality,true);
		//$criteria->compare('institution',$this->institution,true);
		$criteria->compare('invite_code',$this->invite_code);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
