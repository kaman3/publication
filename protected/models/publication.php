<?php

/**
 * This is the model class for table "table_publication_object".
 *
 * The followings are the available columns in table 'table_publication_object':
 * @property integer $id
 * @property integer $userId
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
 * @property integer $floor
 * @property integer $floors
 * @property integer $typeHouse
 * @property integer $countRooms
 * @property string $phone
 * @property string $email
 * @property string $nameDealer
 * @property integer $deadlineRent
 * @property string $dateCreate
 * @property string $dateTime
 * @property string $price
 * @property integer $publich
 * @property string $timer
 * @property string $contact_id
 * @property integer $wall_material
 * @property integer $land_area
 * @property integer $location
 * @property integer $classroom_building
 * @property integer $protection
 * @property integer $type_garage
 *
 *
 */
class publication extends CActiveRecord
{
    // переменная для загрузки изображения
    //public $link;
	/**
     *
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'table_publication_object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('userId, idCat, region, title, price, transaction, description', 'required'),//microdistrict
			array('userId, idCat, region, city, district, microdistrict, transaction, area, floor, floors, typeHouse, countRooms, deadlineRent, publich, price, publich, timer, contact_id, wall_material, distance_to_town, land_area, location, classroom_building, protection, type_garage', 'numerical', 'integerOnly'=>true),
			array('title, street', 'length', 'max'=>250),
			array('phone', 'length', 'max'=>20),
			array('email, nameDealer, price', 'length', 'max'=>150),
			//array('timer, deliteLink', 'length', 'max'=>500),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userId, idCat, region, city, district, microdistrict, title, street, description, transaction, area, floor, floors, typeHouse, countRooms, deadlineRent, dateCreate, dateTime, price, publich, timer, contact_id, wall_material, distance_to_town, land_area, location, classroom_building, protection, type_garage', 'safe', 'on'=>'search'),

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
			'userId' => 'User',
			'idCat' => 'Категория',
			'region' => 'Region',
			'city' => 'Город',
			'district' => 'Район',
			'microdistrict' => 'Микрорайон',
			'title' => 'Заголовок объявления',
			'street' => 'Улица',
			'description' => 'Описание',
			'transaction' => 'Тип сделки',
			'area' => 'Площадь',
			'floor' => 'Этаж',
			'floors' => 'Этажность',
			'typeHouse' => 'Тип дома',
			'countRooms' => 'Количество комнат',
			'phone' => 'Телефон',
			'email' => 'Email',
			'nameDealer' => 'Имя',
			'deadlineRent' => 'Срок аренды',
			'dateCreate' => 'Date Create',
			'dateTime' => 'Date Time',
			'price' => 'Цена',
			'publich' => 'Publich',
			'timer' => 'timer',
			'contact_id' => 'Контактные данные',
            'wall_material' => 'Материалы стен',
            'distance_to_town' => 'Растояние до города',
            'land_area'=> 'Площадь участка',
            'location' => 'Местонахождение',
            'classroom_building' => 'Класс здания',
            'protection' => 'Охрана',
            'type_garage' => 'Тип гаража',
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
		$criteria->compare('userId',$this->userId);
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
		$criteria->compare('floor',$this->floor);
		$criteria->compare('floors',$this->floors);
		$criteria->compare('typeHouse',$this->typeHouse);
		$criteria->compare('countRooms',$this->countRooms);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('nameDealer',$this->nameDealer,true);
		$criteria->compare('deadlineRent',$this->deadlineRent);
		$criteria->compare('dateCreate',$this->dateCreate,true);
		$criteria->compare('dateTime',$this->dateTime,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('publich',$this->publich);
		$criteria->compare('timer',$this->timer,true);
		$criteria->compare('contact_id',$this->contact_id,true);
        $criteria->compare('wall_material',$this->wall_material,true);
        $criteria->compare('distance_to_town',$this->distance_to_town,true);
        $criteria->compare('land_area',$this->land_area,true);
        $criteria->compare('location',$this->location,true);
        $criteria->compare('classroom_building',$this->classroom_building,true);
        $criteria->compare('protection',$this->protection,true);
        $criteria->compare('type_garage',$this->type_garage,true);
        $criteria->compare('pDayHours',$this->pDayHours,true);



		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return publication the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
