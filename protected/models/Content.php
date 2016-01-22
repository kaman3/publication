<?php

/**
 * This is the model class for table "table_content".
 *
 * The followings are the available columns in table 'table_content':
 * @property integer $id
 * @property integer $idCat
 * @property string $title
 * @property string $description
 * @property string $dateTime
 * @property string $keywords_tag
 * @property string $description_tag
 */
class Content extends CActiveRecord
{
    public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'table_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
           // array('image', 'file', 'maxSize' => 4048576),
			array('idCat, title, description, dateTime, keywords_tag, description_tag', 'required'),
			array('idCat', 'numerical', 'integerOnly'=>true),
			array('title, keywords_tag, description_tag', 'length', 'max'=>1000),
			array('description', 'length', 'max'=>20000),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idCat, title, description, dateTime, keywords_tag, description_tag', 'safe', 'on'=>'search'),
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
			'idCat' => 'Id Cat',
			'title' => 'Title',
			'description' => 'Description',
			'dateTime' => 'Date Time',
			'keywords_tag' => 'Keywords Tag',
			'description_tag' => 'Description Tag',
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
		$criteria->compare('idCat',$this->idCat);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('dateTime',$this->dateTime,true);
		$criteria->compare('keywords_tag',$this->keywords_tag,true);
		$criteria->compare('description_tag',$this->description_tag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Content the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
