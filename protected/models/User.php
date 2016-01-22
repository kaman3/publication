<?php

/**
 * This is the model class for table "table_User".
 *
 * The followings are the available columns in table 'table_User':
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $createtime
 * @property string $activationKey
 * @property string $status
 * @property string $phone
 */
class User extends CActiveRecord
{

	public $captcha;
    public $password2;
    public $emailPass;
    public $test;
    public $phone;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'table_User';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

	public function rules() {
        return array(

            array('email, password, password2, captcha, phone', 'required',),
            //array('password2', 'compare', 'compareAttribute' => 'password',),
           // array('captcha',  'captcha', 'allowEmpty' => !extension_loaded('gd'), 'on'=>'reg'),
            array(
                'captcha',
                'captcha',
                // авторизованным пользователям код можно не вводить
                'allowEmpty'=>!Yii::app()->user->isGuest || !CCaptcha::checkRequirements(),
            ),

            //array('password2', 'compare', 'compareAttribute' => 'password',),
            //array('phone','length', 'max' => '11', 'min'=> '11'),
            //array('phone', 'match', 'pattern'=>'/^([+]?[0-9 ]+)$/'),
            array('email',    'match',   'pattern'    => '/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/', 'message' => 'Не верный формат e-mail адреса.'),
            //array('username', 'match',   'pattern'    => '/^[A-Za-z0-9_-А-Яа-я\s,]+$/u','message'  => 'Логин содержит недопустимые символы.'),

            array('email',     'length',  'max' => '100', 'min' => '3',),
            array('password, password2', 'length',  'max' => '40',  'min' => '5',),
            //array('password2', 'compare', 'compareAttribute' => 'password',),
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

	public function attributeLabels()
    {
        return array(
            'test' => 'Воспользоваться тестовым переодом',
            'phone' => 'Телефон',
            'username'=>'Логин',
            'password'=>'Пароль',
            'email'=>'email',
            // и т.д.
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */


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

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('createtime',$this->createtime,true);
		$criteria->compare('activationKey',$this->activationKey,true);
		$criteria->compare('status',$this->status,true);
        $criteria->compare('phone',$this->phone,true);

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
