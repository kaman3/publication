<?php

/**
 * This is the model class for table "table_public_avito".
 *
 * The followings are the available columns in table 'table_public_avito':
 * @property integer $id
 * @property integer $idAds
 * @property integer $userId
 * @property string $link
 * @property string $deliteLink
 * @property integer $public
 * @property string $datePublic
 */
class TablePublicAvito extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'table_public_avito';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idAds, userId, link, deliteLink, public, datePublic', 'required'),
			array('idAds, userId, public', 'numerical', 'integerOnly'=>true),
			array('link, deliteLink', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idAds, userId, link, deliteLink, public, datePublic', 'safe', 'on'=>'search'),
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
			'idAds' => 'Id Ads',
			'userId' => 'User',
			'link' => 'Link',
			'deliteLink' => 'Delite Link',
			'public' => 'Public',
			'datePublic' => 'Date Public',
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
		$criteria->compare('idAds',$this->idAds);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('deliteLink',$this->deliteLink,true);
		$criteria->compare('public',$this->public);
		$criteria->compare('datePublic',$this->datePublic,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TablePublicAvito the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
