<?php

/**
 * This is the model class for table "table_object".
 *
 * The followings are the available columns in table 'table_object':
 * @property integer $id
 * @property integer $idPars
 * @property integer $idAds
 * @property integer $idCat
 * @property integer $region
 * @property integer $city
 * @property integer $district
 * @property integer $microdistrict
 * @property string $title
 * @property string $street
 * @property string $description
 * @property integer $transaction
 * @property integer $area
 * @property integer $totalArea
 * @property integer $plotArea
 * @property integer $floor
 * @property integer $floors
 * @property integer $typeHouse
 * @property integer $countRooms
 * @property string $phone
 * @property string $NameDealer
 * @property integer $agent
 * @property string $deadline
 * @property string $deadlineRent
 * @property string $dateTime
 * @property string $price
 * @property integer $view
 * @property string $description_tag
 * @property integer $sold
 * @property integer $email
 * @property integer $user
 * @property string $url_manager
 */
class realtyObject extends CActiveRecord
{
    public $image;
    public $verifyCode;
    //public $CNumberValidator;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'table_object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('idPars, idAds, idCat, region, title, description, transaction, totalArea, phone, NameDealer, dateTime, price', 'required'),
			array('idPars, idAds, idCat, region, city, district, microdistrict, transaction, area, totalArea, plotArea, floor, floors, typeHouse, countRooms, agent, view, description_tag, user, sold', 'numerical',   'integerOnly'=>true),
			array('title, street, NameDealer, deadline, deadlineRent, price, user', 'length', 'max'=>250),
			array('phone, email', 'length', 'max'=>20),
            array('email', 'email'),
            array('url_manager', 'match', 'pattern'=>'/^[a-f0-9]{32}$/', 'message'=>'Not MD5 hashed!'),
            array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' => true),
            array(
                'verifyCode',
                'captcha',
                // авторизованным пользователям код можно не вводить
                'allowEmpty'=>!Yii::app()->user->isGuest || !CCaptcha::checkRequirements(),
            ),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idPars, idAds, idCat, region, city, district, microdistrict, title, street, description, transaction, area, totalArea, plotArea, floor, floors, typeHouse, countRooms, phone, NameDealer, agent, deadline, deadlineRent, dateTime, price, view, description_tag, sold, email, user, url_manager', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'idPars' => 'Id Pars',
			'idAds' => 'Id Ads',
			'idCat' => 'Категория',
			'region' => 'Регион',
			'city' => 'Город',
			'district' => 'Район',
			'microdistrict' => 'Микрорайон',
			'title' => 'Заголовок',
			'street' => 'Улица',
			'description' => 'Описание',
			'transaction' => 'Тип сделки',
			'area' => 'Жилая площадь',
			'totalArea' => 'Общая площадь',
			'plotArea' => 'Plot Area',
			'floor' => 'Этаж',
			'floors' => 'Этажность',
			'typeHouse' => 'Тип дома',
			'countRooms' => 'Количество комнат',
			'phone' => 'Телефон',
			'NameDealer' => 'Ваше имя',
			'agent' => 'Агент или нет',
			'deadline' => 'Deadline',
			'deadlineRent' => 'Срок аренды',
			'dateTime' => 'Date Time',
			'price' => 'Цена',
			'view' => 'View',
            'verifyCode' => 'Результат',
            'description_tag' => 'description_tag',
            'sold' => 'sold',
            'email' => 'Электронная почта',
            'user' => 'user',
            'url_manager' => 'url_manager',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('idPars',$this->idPars);
		$criteria->compare('idAds',$this->idAds);
		$criteria->compare('idCat',$this->idCat);
		$criteria->compare('region',$this->region);
		$criteria->compare('city',$this->city);
		$criteria->compare('district',$this->district);
		$criteria->compare('microdistrict',$this->microdistrict);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('transaction',$this->transaction);
		$criteria->compare('area',$this->area);
		$criteria->compare('totalArea',$this->totalArea);
		$criteria->compare('plotArea',$this->plotArea);
		$criteria->compare('floor',$this->floor);
		$criteria->compare('floors',$this->floors);
		$criteria->compare('typeHouse',$this->typeHouse);
		$criteria->compare('countRooms',$this->countRooms);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('NameDealer',$this->NameDealer,true);
		$criteria->compare('agent',$this->agent);
		$criteria->compare('deadline',$this->deadline,true);
		$criteria->compare('deadlineRent',$this->deadlineRent,true);
		$criteria->compare('dateTime',$this->dateTime,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('view',$this->view);
        $criteria->compare('description_tag',$this->description_tag);
        $criteria->compare('sold',$this->sold);
        $criteria->compare('email',$this->email);
        $criteria->compare('user',$this->user);
        $criteria->compare('url_manager',$this->url_manager);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return realtyObject the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
