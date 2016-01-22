<?php

class PublicationController extends Controller
{
    public $description = '';
    public $keywords = '';
    public $title = '';

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';


	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				//'actions'=>array('index','view'),
                'actions'=>array('Rates', 'Help','Test'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('publication','index','create','update','delete','admin','upload','contact','contactAdd','timer','TSave','Tdel','public','delcontacts','DefaultContact','ShowContact','AllCron','DelChangeAds','ShowUp','AddNotebook','GetCat','GetModelAvto','manager'),
                'users'=>array('@'),
			),
            /*
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('manager'),
                'users'=>array('+79631099211'),//+79631099211
            ),
            */
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new publication;


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['publication']))
		{

			$model->attributes=$_POST['publication'];
			if($model->save())
            {
                $dirname = $_SERVER['DOCUMENT_ROOT'].'/publish/images/cacheImg/'.$_SESSION['upload'].'/';
                $dirdestination = $_SERVER['DOCUMENT_ROOT'].'/publish/images/user'.Yii::app()->user->id.'/'.Yii::app()->db->lastInsertID.'/';
                Yii::app()->app->lowering($dirname,$dirdestination);
                // Cron

                $userId =  $_POST['publication']['userId'];
                $idAds = Yii::app()->db->lastInsertID;

                $pDayHours = $_POST['publication']['pDayHours'];

                $this->creatCroon($pDayHours,$userId,$idAds,1);

            $this->redirect(array('index'));

            }

		}
        // главные категории
        $catNew = new TableNewCategory();
        $arrCat = $catNew::model()->findAllBySql('SELECT * FROM table_new_category WHERE parent = 0');

        foreach($arrCat as $key => $value){
            $arrSelectCat[$key] = $value;
        }
        // подкатегории
        $catChild = new TableCategory();
        $arrCatChild = $catChild::model()->findAllBySql('SELECT idCat,parent,name FROM table_category WHERE parent != 0');

        foreach($arrCatChild as $key => $value){
            $arrSelectCatChild[$key] = $value;
        }
        // контактная информация
        $contact = TablePublicContacts::model()->findAll('userId = '.Yii::app()->user->id);
        $arrSelectContact = CHtml::listData($contact, 'id', 'name');
        // город
        $modelsCityRegion = TableCityRegion::model()->findAll();
        $arrSelectCityRegion = CHtml::listData($modelsCityRegion, 'id', 'name');
        // район
        $modelsDistrict = TableCityDistricts::model()->findAll();
        $arrSelectDistrict = CHtml::listData($modelsDistrict, 'id', 'name');
        // микрорайя
        $modelsMicroDistrict = TableCityMicrodistricts::model()->findAll(array('order'=>'name'));
        $arrSelectMicroDistrict = CHtml::listData($modelsMicroDistrict, 'id', 'name');
        // тип сделки
        $modelsTransaction = TableTypeTransaction::model()->findAll();
        $arrSelectTransacnion = CHtml::listData($modelsTransaction, 'id', 'name');
        // тип дома
        $modelsHouseType = TableHouseTypes::model()->findAll('pLabel = 1');
        $arrSelectHouseType = CHtml::listData($modelsHouseType, 'id', 'name');
        // количество комнат
        $modelsCountRooms = TableCountRooms::model()->findAll();
        $arrSelectCountRooms = CHtml::listData($modelsCountRooms, 'id', 'name');
        // растояние от города
        $models_distance_to_town = DistanceToTown::model()->findAll();
        $arrDistance_to_town = CHtml::listData($models_distance_to_town, 'id', 'name');
        // материалы стен
        $models_wall_material = WallMaterial::model()->findAll();
        $arrWall_material = CHtml::listData($models_wall_material, 'id', 'name');
        // местонахождение
        $location = array(1=>'В черте города',2=>'За городом');
        // срок аренды
        $deadlineRent = array(1=>'На длительный срок',2=>'Посуточно');
        // класс здания
        $classroom_building = array(1=>'A',2=>'B',3=>'C',4=>'D',);
        // охрана
        $protection = array(1=>'Да',2=>'Нет');
        // тип гаража
        $type_garage = array(1=>'Железобетонный',2=>'Кирпичный',3=>'Металлический',);
        // cron значения
        $models_timer_ads = TimerAds::model()->findAll();
        $timer_ads = CHtml::listData($models_timer_ads, 'idTimer', 'name');
        // марка автомабиля
        $brend = TableBrend::model()->findAll('parent = 0');


        $timeInterval = array(
            1=>'с <span>1:00</span> до <span>2:00</span>',
            2=>'с <span>2:00</span> до <span>3:00</span>',
            3=>'с <span>3:00</span> до <span>4:00</span>',
            4=>'с <span>4:00</span> до <span>5:00</span>',
            5=>'с <span>5:00</span> до <span>6:00</span>',
            6=>'с <span>6:00</span> до <span>7:00</span>',
            7=>'с <span>7:00</span> до <span>8:00</span>',
            8=>'с <span>8:00</span> до <span>9:00</span>',
            9=>'с <span>9:00</span> до <span>10:00</span>',
            10=>'с <span>10:00</span> до <span>11:00</span>',
            11=>'с <span>11:00</span> до <span>12:00</span>',
            12=>'с <span>12:00</span> до <span>13:00</span>',
            13=>'с <span>13:00</span> до <span>14:00</span>',
            14=>'с <span>14:00</span> до <span>15:00</span>',
            15=>'с <span>15:00</span> до <span>16:00</span>',
            16=>'с <span>16:00</span> до <span>17:00</span>',
            17=>'с <span>17:00</span> до <span>18:00</span>',
            18=>'с <span>18:00</span> до <span>19:00</span>',
            19=>'с <span>19:00</span> до <span>20:00</span>',
            20=>'с <span>20:00</span> до <span>21:00</span>',
            21=>'с <span>21:00</span> до <span>22:00</span>',
            22=>'с <span>22:00</span> до <span>23:00</span>',
            23=>'с <span>23:00</span> до <span>24:00</span>',
            0=>'с <span>00:00 до 1:00</span>',

        );
        // форма для автомобилей

        // год выпуска
        $avto['GYear'] = array(
            2015 => '2015',
            2014 => '2014',
            2013 => '2013',
            2012 => '2012',
            2011 => '2011',
            2010 => '2010',
            2009 => '2009',
            2008 => '2008',
            2007 => '2007',
            2006 => '2006',
            2005 => '2005',
            2004 => '2004',
            2003 => '2003',
            2002 => '2002',
            2001 => '2001',
            2000 => '2000',
            1999 => '1999',
            1998 => '1998',
            1997 => '1997',
            1996 => '1996',
            1995 => '1995',
            1994 => '1994',
            1993 => '1993',
            1992 => '1992',
            1991 => '1991',
            1990 => '1990',
            1989 => '1989',
            1988 => '1988',
            1987 => '1987',
            1986 => '1986',
            1985 => '1985',
            1984 => '1984',
            1983 => '1983',
            1982 => '1982',
            1981 => '1981',
            1980 => '1980',
            1979 => '1979',
            1978 => '1978',
            1977 => '1977',
            1976 => '1976',
            1975 => '1975',
            1974 => '1974',
            1973 => '1973',
            1972 => '1972',
            1971 => '1971',
            1970 => '1970',
        );
        // сотояние
        $avto['general_state'] = array(
            1 => 'Отличное',
            2 => 'Хорошее',
            3 => 'Среднее',
            4 => 'Плохое',
            5 => 'Битый',
        );
        // готовность к эксплуатаци
        $avto['readiness'] = array(
            1 => 'На ходу',
            2 => 'На ходу, но требует ремонта',
            3 => 'Не на ходу',
        );
        // таможня
        $avto['customs'] = array(
            1 => 'Растаможен',
            2 => 'Не растаможен',
        );
        // цвет
        $avto['colour'] = array(
            1 => 'Бежевый',
            2 => 'Бежевый металлик',
            3 => 'Белый',
            4 => 'Белый перламутр',
            5 => 'Голубой',
            6 => 'Голубой металлик',
            7 => 'Желтый',
            8 => 'Желтый металлик',
            9 => 'Зеленый',
            10 => 'Зеленый металлик',
            11 => 'Золотой',
            12 => 'Золотой металлик',
            13 => 'Коричневый',
            14 => 'Коричневый металлик',
            15 => 'Красный',
            16 => 'Красный металлик',
            17 => 'Оранжевый',
            18 => 'Оранжевый металлик',
            19 => 'Пурпурный',
            20 => 'Пурпурный металлик',
            21 => 'Серебряный',
            22 => 'Серебряный металлик',
            23 => 'Серый',
            24 => 'Серый металлик',
            25 => 'Синий',
            26 => 'Синий металлик',
            27 => 'Фиолетовый',
            28 => 'Фиолетовый металлик',
            29 => 'Черный',
            30 => 'Черный металлик',
        );
        // тип кузова
        $avto['body_type'] = array(
            1 => 'Седан',
            2 => 'Хэтчбек (3 дв.)',
            3 => 'Хэтчбек (5 дв.)',
            4 => 'Универсал',
            5 => 'Внедорожник (3 дв.)',
            6 => 'Внедорожник (5 дв.)',
            7 => 'Минивен',
            8 => 'Микроавтобус',
            9 => 'Фургон',
            10 => 'Пикап',
            11 => 'Кабриолет',
            12 => 'Купе',
            13 => 'Лимузин',
            14 => 'Стретч',
            15 => 'Родстер',
            16 => 'Тарга',
        );
        // тип двигателя
        $avto['engines_type'] = array(
            'Бензин' => array(
                2 => 'Бензин инжектор',
                3 => 'Бензин карбюратор',
                4 => 'Бензин ротор',
                5 => 'Бензин компрессор',
                6 => 'Бензин турбонаддув',
            ),
            'Дизель' => array(
                8 => 'Дизель',
                9 => 'Дизель турбонаддув',
            ),
            'Гибридный' => array(
                11 => 'Гибридный бензиновый',
                12 => 'Гибридный дизельный'
            )

        );
        // привод
        $avto['drive'] = array(
            1 => 'Задний',
            2 => 'Передний',
            3 => 'Полный',
        );
        // коробка
        $avto['box'] = array(
            1 => 'Механическая',
            2 => 'Автомат',
            3 => 'Автомат-вариатор',
            4 => 'Автомат-робот',
        );
        // руль
        $avto['steering_wheel'] = array(
            1 => 'Левый',
            2 => 'Правый',
        );
        // птс
        $avto['pts'] = array(
            1 => 'Нет',
            2 => '1',
            3 => '2',
            4 => '3 и более',
        );
        // наличие
        $avto['availability'] = array(
            1 => 'В наличии',
            2 => 'На заказ',
            3 => 'С доставкой',
        );
        // обмен
        $avto['exchange'] = array(
            1 => 'Нет',
            2 => 'С вашей доплатой',
            3 => 'С моей доплатой',
            4 => 'Рассмотрю варианты',
        );
        // магнитола
        $avto['radio_cassette'] = array(
            1 => 'CD',
            2 => 'DVD',
            3 => 'MP3',
            4 => 'TV',
            5 => 'Кассетная',
        );
        // подушки безопасности
        $avto['airbags'] = array(
            1 => 'Водительская',
            2 => 'Передние',
            3 => 'Передние + боковые',
        );
        // регулировка сидений
        $avto['seat_adjustment'] = array(
            1 => 'По высоте',
            2 => 'С памятью',
            3 => 'Электропривод',
        );
        // регулировка сидений пассажира
        $avto['adjusting_passenger_seat'] = array(
            1 => 'По высоте',
            2 => 'Электропривод',
        );
        // регулировка руля
        $avto['adjustable_steering_wheel'] = array(
            1 => 'По высоте',
            2 => 'Электропривод',
        );
        // отделка салона
        $avto['trim'] = array(
            1 => 'велюр',
            2 => 'кожа',
            3 => 'комбинированная',
            4 => 'ткань',
        );
        // климат контроль
        $avto['climate_control'] = array(
            1 => 'климат-контроль',
            2 => 'кондиционер',
        );
        // усилитель руля
        $avto['power_steering'] = array(
            1 => 'гидро',
            2 => 'электро',
        );
        // стеклоподъемники
        $avto['electric_mirrors'] = array(
            1 => 'все',
            2 => 'передние',
        );
        // конец формы авто



        $this->render('create',array(
			'model'=>$model,
            'catChild'=>$arrSelectCatChild,
            'idCat'=>$arrSelectCat,
            'city'=>$arrSelectCityRegion,
            'district'=>$arrSelectDistrict,
            'microdistrict'=>$arrSelectMicroDistrict,
            'transaction'=>$arrSelectTransacnion,
            'houseType'=>$arrSelectHouseType,
            'countRooms'=>$arrSelectCountRooms,
            'contact'=> $arrSelectContact,
            'wall_material' =>$arrWall_material,
            'distance_to_town' =>$arrDistance_to_town,
            'location' => $location,
            'deadlineRent' => $deadlineRent,
            'classroom_building' => $classroom_building,
            'protection' => $protection,
            'type_garage' => $type_garage,
            'timer_ads' => $timer_ads,
            'timeInterval' => $timeInterval,
            'brend' => $brend,
            'avto' => $avto,

		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
    public function actionAllCron($elem,$ids){

        $arrParam = explode(',',$ids);
        $userId = Yii::app()->user->id;

        if(count($elem) > 0){

            foreach($arrParam as $key => $idAds){
                $this->delCroon($idAds);
                $this->creatCroon($elem,$userId,$idAds,2);
            }
        echo 1;
        }


    }
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
	    //$this->performAjaxValidation($model);

		if(isset($_POST['publication']))
		{
			$model->attributes=$_POST['publication'];
			if($model->save()){
                // удаляем старый крон запрос
                $this->delCroon($id);
                // ставим новый крон запрос

                $pDayHours = $_POST['publication']['pDayHours'];
                $userId =  $_POST['publication']['userId'];

                //print_r($pDayHours);

                $this->creatCroon($pDayHours,$userId,$id,2);

			$this->redirect(array('index','page'=>Yii::app()->request->getParam('page')));
            }

		}

        // выод данных для select. ов
        // категория
        // главные категории
        $catNew = new TableNewCategory();
        $arrCat = $catNew::model()->findAllBySql('SELECT * FROM table_new_category WHERE parent = 0');

        foreach($arrCat as $key => $value){
            $arrSelectCat[$key] = $value;
        }
        // подкатегории
        $catChild = new TableCategory();
        $arrCatChild = $catChild::model()->findAllBySql('SELECT idCat,parent,name FROM table_category WHERE parent != 0');

        foreach($arrCatChild as $key => $value){
            $arrSelectCatChild[$key] = $value;
        }
        // контактная информация
        $contact = TablePublicContacts::model()->findAll('userId = '.Yii::app()->user->id);//.Yii::app()->user->id
        $arrSelectContact = CHtml::listData($contact, 'id', 'name');
        // город
        $modelsCityRegion = TableCityRegion::model()->findAll();
        $arrSelectCityRegion = CHtml::listData($modelsCityRegion, 'id', 'name');
        // район
        $modelsDistrict = TableCityDistricts::model()->findAll();
        $arrSelectDistrict = CHtml::listData($modelsDistrict, 'id', 'name');
        // микрорайон
        $modelsMicroDistrict = TableCityMicrodistricts::model()->findAll(array('order'=>'name'));
        $arrSelectMicroDistrict = CHtml::listData($modelsMicroDistrict, 'id', 'name');
        // тип сделки
        $modelsTransaction = TableTypeTransaction::model()->findAll();
        $arrSelectTransacnion = CHtml::listData($modelsTransaction, 'id', 'name');
        // тип дома
        $modelsHouseType = TableHouseTypes::model()->findAll('pLabel = 1');
        $arrSelectHouseType = CHtml::listData($modelsHouseType, 'id', 'name');
        // количество комнат
        $modelsCountRooms = TableCountRooms::model()->findAll();
        $arrSelectCountRooms = CHtml::listData($modelsCountRooms, 'id', 'name');
        // растояние от города
        $models_distance_to_town = DistanceToTown::model()->findAll();
        $arrDistance_to_town = CHtml::listData($models_distance_to_town, 'id', 'name');
        // материалы стен
        $models_wall_material = WallMaterial::model()->findAll();
        $arrWall_material = CHtml::listData($models_wall_material, 'id', 'name');
        // местонахождение
        $location = array(1=>'В черте города',2=>'За городом');
        // срок аренды
        $deadlineRent = array(1=>'На длительный срок',2=>'Посуточно');
        // класс здания
        $classroom_building = array(1=>'A',2=>'B',3=>'C',4=>'D',);
        // охрана
        $protection = array(1=>'Да',2=>'Нет');
        // тип гаража
        $type_garage = array(1=>'Железобетонный',2=>'Кирпичный',3=>'Металлический',);
        // cron
        $models_timer_ads = TimerAds::model()->findAll();
        $timer_ads = CHtml::listData($models_timer_ads, 'idTimer', 'name');

        // марка автомабиля
        $brend = TableBrend::model()->findAll('parent = 0');

        // cron запрос
        $cron = '';
        $pDt = PublichDayTime::model()->findAll('idAds = '.$id);  // получаем данные крона
        // для инпута default value
        foreach($pDt as $key => $value){
            $cron .= $value['days'].'/'.$value['hours'].":";
        }
        // для формы
        $cronData = array();
        foreach($pDt as $key => $value){
            $cronData[$key]['days'] = $value['days'];
            $cronData[$key]['hours'] = $value['hours'];
        }

        // дни недели
        $week = array(
            1=>'Пн',
            2=>'Вт',
            3=>'Ср',
            4=>'Чт',
            5=>'Пт',
            6=>'Сб',
            7=>'Вс',
        );


        $timeInterval = array(
            1=>'с <span>1:00</span> до <span>2:00</span>',
            2=>'с <span>2:00</span> до <span>3:00</span>',
            3=>'с <span>3:00</span> до <span>4:00</span>',
            4=>'с <span>4:00</span> до <span>5:00</span>',
            5=>'с <span>5:00</span> до <span>6:00</span>',
            6=>'с <span>6:00</span> до <span>7:00</span>',
            7=>'с <span>7:00</span> до <span>8:00</span>',
            8=>'с <span>8:00</span> до <span>9:00</span>',
            9=>'с <span>9:00</span> до <span>10:00</span>',
            10=>'с <span>10:00</span> до <span>11:00</span>',
            11=>'с <span>11:00</span> до <span>12:00</span>',
            12=>'с <span>12:00</span> до <span>13:00</span>',
            13=>'с <span>13:00</span> до <span>14:00</span>',
            14=>'с <span>14:00</span> до <span>15:00</span>',
            15=>'с <span>15:00</span> до <span>16:00</span>',
            16=>'с <span>16:00</span> до <span>17:00</span>',
            17=>'с <span>17:00</span> до <span>18:00</span>',
            18=>'с <span>18:00</span> до <span>19:00</span>',
            19=>'с <span>19:00</span> до <span>20:00</span>',
            20=>'с <span>20:00</span> до <span>21:00</span>',
            21=>'с <span>21:00</span> до <span>22:00</span>',
            22=>'с <span>22:00</span> до <span>23:00</span>',
            23=>'с <span>23:00</span> до <span>24:00</span>',
            0=>'с <span>00:00 до 1:00</span>',

        );

        // форма для автомобилей

        // год выпуска
        $avto['GYear'] = array(
            2015 => '2015',
            2014 => '2014',
            2013 => '2013',
            2012 => '2012',
            2011 => '2011',
            2010 => '2010',
            2009 => '2009',
            2008 => '2008',
            2007 => '2007',
            2006 => '2006',
            2005 => '2005',
            2004 => '2004',
            2003 => '2003',
            2002 => '2002',
            2001 => '2001',
            2000 => '2000',
            1999 => '1999',
            1998 => '1998',
            1997 => '1997',
            1996 => '1996',
            1995 => '1995',
            1994 => '1994',
            1993 => '1993',
            1992 => '1992',
            1991 => '1991',
            1990 => '1990',
            1989 => '1989',
            1988 => '1988',
            1987 => '1987',
            1986 => '1986',
            1985 => '1985',
            1984 => '1984',
            1983 => '1983',
            1982 => '1982',
            1981 => '1981',
            1980 => '1980',
            1979 => '1979',
            1978 => '1978',
            1977 => '1977',
            1976 => '1976',
            1975 => '1975',
            1974 => '1974',
            1973 => '1973',
            1972 => '1972',
            1971 => '1971',
            1970 => '1970',
        );
        // сотояние
        $avto['general_state'] = array(
            1 => 'Отличное',
            2 => 'Хорошее',
            3 => 'Среднее',
            4 => 'Плохое',
            5 => 'Битый',
        );
        // готовность к эксплуатаци
        $avto['readiness'] = array(
            1 => 'На ходу',
            2 => 'На ходу, но требует ремонта',
            3 => 'Не на ходу',
        );
        // таможня
        $avto['customs'] = array(
            1 => 'Растаможен',
            2 => 'Не растаможен',
        );
        // цвет
        $avto['colour'] = array(
            1 => 'Бежевый',
            2 => 'Бежевый металлик',
            3 => 'Белый',
            4 => 'Белый перламутр',
            5 => 'Голубой',
            6 => 'Голубой металлик',
            7 => 'Желтый',
            8 => 'Желтый металлик',
            9 => 'Зеленый',
            10 => 'Зеленый металлик',
            11 => 'Золотой',
            12 => 'Золотой металлик',
            13 => 'Коричневый',
            14 => 'Коричневый металлик',
            15 => 'Красный',
            16 => 'Красный металлик',
            17 => 'Оранжевый',
            18 => 'Оранжевый металлик',
            19 => 'Пурпурный',
            20 => 'Пурпурный металлик',
            21 => 'Серебряный',
            22 => 'Серебряный металлик',
            23 => 'Серый',
            24 => 'Серый металлик',
            25 => 'Синий',
            26 => 'Синий металлик',
            27 => 'Фиолетовый',
            28 => 'Фиолетовый металлик',
            29 => 'Черный',
            30 => 'Черный металлик',
        );
        // тип кузова
        $avto['body_type'] = array(
            1 => 'Седан',
            2 => 'Хэтчбек (3 дв.)',
            3 => 'Хэтчбек (5 дв.)',
            4 => 'Универсал',
            5 => 'Внедорожник (3 дв.)',
            6 => 'Внедорожник (5 дв.)',
            7 => 'Минивен',
            8 => 'Микроавтобус',
            9 => 'Фургон',
            10 => 'Пикап',
            11 => 'Кабриолет',
            12 => 'Купе',
            13 => 'Лимузин',
            14 => 'Стретч',
            15 => 'Родстер',
            16 => 'Тарга',
        );
        // тип двигателя
        $avto['engines_type'] = array(
            'Бензин' => array(
                2 => 'Бензин инжектор',
                3 => 'Бензин карбюратор',
                4 => 'Бензин ротор',
                5 => 'Бензин компрессор',
                6 => 'Бензин турбонаддув',
            ),
            'Дизель' => array(
                8 => 'Дизель',
                9 => 'Дизель турбонаддув',
            ),
            'Гибридный' => array(
                11 => 'Гибридный бензиновый',
                12 => 'Гибридный дизельный'
            )

        );
        // привод
        $avto['drive'] = array(
            1 => 'Задний',
            2 => 'Передний',
            3 => 'Полный',
        );
        // коробка
        $avto['box'] = array(
            1 => 'Механическая',
            2 => 'Автомат',
            3 => 'Автомат-вариатор',
            4 => 'Автомат-робот',
        );
        // руль
        $avto['steering_wheel'] = array(
            1 => 'Левый',
            2 => 'Правый',
        );
        // птс
        $avto['pts'] = array(
            1 => 'Нет',
            2 => '1',
            3 => '2',
            4 => '3 и более',
        );
        // наличие
        $avto['availability'] = array(
            1 => 'В наличии',
            2 => 'На заказ',
            3 => 'С доставкой',
        );
        // обмен
        $avto['exchange'] = array(
            1 => 'Нет',
            2 => 'С вашей доплатой',
            3 => 'С моей доплатой',
            4 => 'Рассмотрю варианты',
        );
        // магнитола
        $avto['radio_cassette'] = array(
            1 => 'CD',
            2 => 'DVD',
            3 => 'MP3',
            4 => 'TV',
            5 => 'Кассетная',
        );
        // подушки безопасности
        $avto['airbags'] = array(
            1 => 'Водительская',
            2 => 'Передние',
            3 => 'Передние + боковые',
        );
        // регулировка сидений
        $avto['seat_adjustment'] = array(
            1 => 'По высоте',
            2 => 'С памятью',
            3 => 'Электропривод',
        );
        // регулировка сидений пассажира
        $avto['adjusting_passenger_seat'] = array(
            1 => 'По высоте',
            2 => 'Электропривод',
        );
        // регулировка руля
        $avto['adjustable_steering_wheel'] = array(
            1 => 'По высоте',
            2 => 'Электропривод',
        );
        // отделка салона
        $avto['trim'] = array(
            1 => 'велюр',
            2 => 'кожа',
            3 => 'комбинированная',
            4 => 'ткань',
        );
        // климат контроль
        $avto['climate_control'] = array(
            1 => 'климат-контроль',
            2 => 'кондиционер',
        );
        // усилитель руля
        $avto['power_steering'] = array(
            1 => 'гидро',
            2 => 'электро',
        );
        // стеклоподъемники
        $avto['electric_mirrors'] = array(
            1 => 'все',
            2 => 'передние',
        );
        // конец формы авто

        $this->render('update',array(
            'model'=>$model,
            'catChild'=>$arrSelectCatChild,
            'idCat'=>$arrSelectCat,
            'city'=>$arrSelectCityRegion,
            'district'=>$arrSelectDistrict,
            'microdistrict'=>$arrSelectMicroDistrict,
            'transaction'=>$arrSelectTransacnion,
            'houseType'=>$arrSelectHouseType,
            'countRooms'=>$arrSelectCountRooms,
            'contact'=> $arrSelectContact,
            'wall_material' =>$arrWall_material,
            'distance_to_town' =>$arrDistance_to_town,
            'location' => $location,
            'deadlineRent' =>$deadlineRent,
            'classroom_building' => $classroom_building,
            'protection' => $protection,
            'type_garage' => $type_garage,
            'timer_ads' => $timer_ads,
            'timeInterval' => $timeInterval,
            'cron' => $cron,
            'cronData' => $cronData,
            'week' => $week,
            'brend' => $brend,
            'avto' => $avto,
        ));
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
        {
            $dirname = $_SERVER['DOCUMENT_ROOT'].'/publish/images/user'.Yii::app()->user->id.'/'.$id.'/';
            Yii::app()->app->removeDirRec($dirname);
            $this->delCroon($id);
            $this->redirect(array('index','active'=>Yii::app()->request->getParam('active'),'page'=>Yii::app()->request->getParam('page')));
        }
	}
    // массовое удаление елементов
    public function actionDelChangeAds($param){

          $item = explode(',',$param);

          foreach($item as $value){
                 $this->loadModel($value)->delete();
                 $dirname = $_SERVER['DOCUMENT_ROOT'].'/publish/images/user'.Yii::app()->user->id.'/'.$value.'/';
                 Yii::app()->app->removeDirRec($dirname);
                 $this->delCroon($value);
          }
          echo '1';
    }
    // удаление крон запроса
    public function delCroon($id)
    {
        /*
        include_once($_SERVER['DOCUMENT_ROOT'].'/cron/Ssh2_crontab_manager.php');
        $crontab = new Ssh2_crontab_manager('46.30.42.79', '22', 'root', '89048512165');

        $cron_jobs = $crontab->get_cronjobs();
        // удаляем пустые задачи
        $crontab->remove_cronjob('/^$/');

        foreach($cron_jobs as $key => $value){
            $cronArr[$key] = $value;
        }
        $user = str_replace('+','',Yii::app()->user->name);
        //$user =Yii::app()->user->name;

        for($i = 0; $i < count($cronArr); $i++){
            if(preg_match('/parametrs='.Yii::app()->user->id.':'.$id.':'.$user.'/', $cronArr[$i])){
                $arr[] = $i;
            }
        }


        $reversed = array_reverse($arr);
        //print_r($reversed);
        //print_r($cronArr);



        if(count($reversed) > 0 and count($reversed) <=4){
            foreach($reversed as $key => $value2){
                if($value2){
                   $crontab->remove_cronjob_by_key($value2);
                }
            }
        }
        //if(is_null($new_cronjobs)){echo 'Да он пустой';}
        /*

        for($i = 2; $i < 20; $i++){
            $rt[] = $cronArr[$i];
        }
        //$array1 = array_diff($rt, array(''));
        $rt = array_filter($rt);
        print_r($rt);
        $new_cronjobs = array(
                '39 10 * * 6,7 /usr/bin/curl -s http://rlpnz.ru/publish/index.php?parametrs=112:432:79603231810 >/dev/null 2>&1',
                '23 10 * * 6,7 /usr/bin/curl -s http://rlpnz.ru/publish/index.php?parametrs=112:432:79603231810 >/dev/null 2>&1',
                '22 10 * * 6,7 /usr/bin/curl -s http://rlpnz.ru/publish/index.php?parametrs=112:432:79603231810 >/dev/null 2>&1',
                '25 20 * * 6,7 /usr/bin/curl -s http://rlpnz.ru/publish/index.php?parametrs=102:432:79603231810 >/dev/null 2>&1'

);

        //$crontab->remove_cronjob($cronArr);
        if(is_null($new_cronjobs)){echo 'Да он пустой';}
        $crontab->append_cronjob($new_cronjobs);
        */

        $pDt = PublichDayTime::model()->findAll('idAds = '.$id);  // получаем данные крона
        //print_r($pDt);
        //echo $pDt[0]['id'].'<br>';
        foreach($pDt as $key => $value){
           //print_r($value['id']);
           if($value['id']){
                $post=PublichDayTime::model()->findByPk($value['id']); // предполагаем, что запись с ID=10 существует
                $post->delete(); // удаляем строку из таблицы
           }
        }



    }
    // создание крона
    public function creatCroon($pDayHours = array(),$userId,$id,$action = 1)
    {
        $arr = explode(':',$pDayHours);

        foreach($arr as $key => $value){

                $dh = explode('/',$value);
                $day =  $dh[0];
                $hours = $dh[1];

                if($hours and $day){

                if($action == 1){

                    $time_cron = ''.rand(10,55).' '.$hours.' * * '.$day.'';


                    include_once($_SERVER['DOCUMENT_ROOT'].'/cron/Ssh2_crontab_manager.php');
                    $crontab = new Ssh2_crontab_manager('46.30.42.79', '22', 'root', '629265');
                    $user = str_replace('+','',Yii::app()->user->name);


                    $crontab->append_cronjob(''.$time_cron.'  /usr/bin/curl -s http://'.$_SERVER['SERVER_NAME'].'/publish/index.php?parametrs='.$userId.':'.$id.':'.$user.' >/dev/null 2>&1');


                    // создаем запись в базе
                    $publich = new PublichDayTime;
                    $publich->idAds = $id;
                    $publich->hours = $hours;
                    $publich->days  = $day;
                    $publich->save();

                }elseif($action == 2){
                    // создаем запись в базе
                    $publich = new PublichDayTime;
                    $publich->idAds = $id;
                    $publich->hours = $hours;
                    $publich->days  = $day;
                    $publich->save();
                }



            }

        }

    }

    // форма добавления контакты
    public function actionContactAdd()
    {
        if(isset($_GET['id'])){
           $model=$this->loadModelContacts(Yii::app()->user->id, $_GET['id']);
        }
        if($model == 0){
            $model = new TablePublicContacts();
        }
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['TablePublicContacts']))
        {
            $model->attributes = $_POST['TablePublicContacts'];
            if($model->save())
                $this->redirect(array('publication/contact'));
        }

        $this->render('application.views.publication.contacts.contacts',array('model' => $model));
    }
    // список всех контактов
    public function actionContact()
    {
        if(!Yii::app()->user->id)  $this->redirect(array('site/login'));

        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->addCondition("userId = ".Yii::app()->user->id);

        $models = TablePublicContacts::model()->findAll($criteria);

        $this->render('application.views.publication.contacts.contactAll',array('data'=>$models,));

    }
    public function actionDelContacts($id)
    {
        $this->loadModelContacts(Yii::app()->user->id,$id)->delete();
        $this->redirect(array('publication/contact'));
    }
    //
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

        if(!Yii::app()->user->id)  $this->redirect(array('site/login'));

        $criteria = new CDbCriteria();

        $criteria->order = 'id DESC';

        if(trim($_GET['cat'])){
            $criteria->condition = Yii::app()->app->getPathCat($_GET['cat']);

        }

        if(trim($_GET['titleDisc'])){
           $criteria->addCondition(" (title  LIKE '%".trim($_GET['titleDisc'])."%' ) or (description LIKE '%".trim($_GET['titleDisc'])."%')");
        }

        $criteria->addCondition("userID = ".Yii::app()->user->id);

        //$criteria->addCondition("userID = 112");

        if(trim($_GET['districts'])){
            $criteria->addCondition("district =".$_GET['districts']);
        }
        if(count($_GET['microdistricts']) > 0){

            foreach ($_GET['microdistricts'] as $key => $value) {
                $microdistricts .= $value.',';
            }
            $microdistricts = substr($microdistricts, 0,-1);
            $criteria->addCondition('microdistrict IN('.$microdistricts.')');
        }
        if(trim($_GET['contact_id'])){
            $criteria->addCondition("contact_id =".$_GET['contact_id']);
        }
        if(trim($_GET['description'])){
            $criteria->addCondition("description LIKE '%".trim($_GET['description'])."%'");
        }
        if(trim($_GET['transaction'])){
            $criteria->addCondition("transaction =".$_GET['transaction']);
        }

        // количество комнат
        if($_GET['CountRooms']){

            foreach ($_GET['CountRooms'] as $key => $value) {
                $countRooms .= $value.',';
            }
            $countRooms = substr($countRooms, 0,-1);

            if(in_array('6', $_GET['CountRooms'])){
                $criteria->addCondition('countRooms IN('.$countRooms.') OR countRooms >= 6');
            }
            else{
                $criteria->addCondition('countRooms IN('.$countRooms.')');
            }
        }

        $count_active = publication::model()->count('publich = 1 and userid = '.Yii::app()->user->id);
        $count_hide =   publication::model()->count('publich = 0 and userid = '.Yii::app()->user->id);

        //$count_active = publication::model()->count('publich = 1');
        //$count_hide =   publication::model()->count('publich = 0');

        // формируем списки для активных и скрытых
        if($count_hide and $count_active){
            if(!$_GET['active']){
               $criteria->addCondition("publich = 1");
               $aDivActiv_1 = 'pActive';
               $aDivActiv_2 = '';
            }else if($_GET['active'] == 2){
               $criteria->addCondition("publich = 0");
               $aDivActiv_1 = '';
               $aDivActiv_2 = 'pActive';
            }else if($_GET['active'] == 3){
              // $aDivActiv_1 = '';
              //$aDivActiv_2 = 'pActive';
            }
        }else if($count_hide == 0){
               $criteria->addCondition("publich = 1");
        }else if($count_active == 0){
               $criteria->addCondition("publich = 0");
        }


        $count = publication::model()->count($criteria);

        $pages = new CPagination($count);

        $pages->pageSize = 50;

        $pages->applyLimit($criteria);

        $models = publication::model()->findAll($criteria);

        // cron

        $arrSelectCron = array(
            1 => array('0 */03 * * *','Каждые 3 часа'),
            2 => array('0 */10 * * *','Каждый день'),
            3 => array('0 */10 * * *','Днем и вечером'),
            4 => array('0 17 * * *','Вечером'),
        );

        $timeInterval = array(
            1=>'с <span>1:00</span> до <span>2:00</span>',
            2=>'с <span>2:00</span> до <span>3:00</span>',
            3=>'с <span>3:00</span> до <span>4:00</span>',
            4=>'с <span>4:00</span> до <span>5:00</span>',
            5=>'с <span>5:00</span> до <span>6:00</span>',
            6=>'с <span>6:00</span> до <span>7:00</span>',
            7=>'с <span>7:00</span> до <span>8:00</span>',
            8=>'с <span>8:00</span> до <span>9:00</span>',
            9=>'с <span>9:00</span> до <span>10:00</span>',
            10=>'с <span>10:00</span> до <span>11:00</span>',
            11=>'с <span>11:00</span> до <span>12:00</span>',
            12=>'с <span>12:00</span> до <span>13:00</span>',
            13=>'с <span>13:00</span> до <span>14:00</span>',
            14=>'с <span>14:00</span> до <span>15:00</span>',
            15=>'с <span>15:00</span> до <span>16:00</span>',
            16=>'с <span>16:00</span> до <span>17:00</span>',
            17=>'с <span>17:00</span> до <span>18:00</span>',
            18=>'с <span>18:00</span> до <span>19:00</span>',
            19=>'с <span>19:00</span> до <span>20:00</span>',
            20=>'с <span>20:00</span> до <span>21:00</span>',
            21=>'с <span>21:00</span> до <span>22:00</span>',
            22=>'с <span>22:00</span> до <span>23:00</span>',
            23=>'с <span>23:00</span> до <span>24:00</span>',
            0=>'с <span>00:00 до 1:00</span>',

        );

		$this->render('index',
            array(
                'dataProvider'=>$models,
                'pages' => $pages,
                'count'=>$count,
                'cron' => $arrSelectCron,
                'count_active' => $count_active,
                'count_hide' => $count_hide,
                'aDivActiv_1' => $aDivActiv_1,
                'aDivActiv_2' => $aDivActiv_2,
                'timeInterval' => $timeInterval,
            ));



	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new publication('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['publication']))
			$model->attributes=$_GET['publication'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return publication the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{

		$model=publication::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    // загрузка модели для контактов
    public function loadModelContacts($userId, $id)
    {
        $post = new TablePublicContacts;
        $model = $post::model()->findBySql('SELECT * FROM table_public_contacts WHERE userId = '.$userId.' AND id = '.$id.'');

        if($model===null){
           return 0;
        }else{
           return $model;
        }
            //throw new CHttpException(404,'The requested page does not exist.');
    }
	/**
	 * Performs the AJAX validation.
	 * @param publication $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='publication-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    // таймер
    public function actionTimer()
    {
        include_once($_SERVER['DOCUMENT_ROOT'].'/cron/Ssh2_crontab_manager.php');
        $crontab = new Ssh2_crontab_manager('46.30.42.79', '22', 'root', '629265');
        $cron_jobs = $crontab->get_cronjobs();
        // массив значений
        $arrSelect = array(
            0 => array('0 */01 * * *','Каждые 3 часа'),
           // 1 => array('* * */01 * *','Каждый день'),
        );

        foreach($cron_jobs as $key => $value){
            $cronArr[$key] = $value;
        }
        $periodCheck = array();
        for($i = 0; $i < count($cronArr); $i++){
            if(preg_match('/userId='.Yii::app()->user->id.'/', $cronArr[$i])){
                preg_match('/time=([0-9]+)/',$cronArr[$i],$matches);
                $periodCheck['key']  = $i;
                $periodCheck['cron'] = $cronArr[$i];
                $periodCheck['time'] = $arrSelect[$matches[1]][1];
            }
        }

        $this->render('application.views.publication.timer.view',array('model' => $cron_jobs,'select' => $arrSelect,'timer' => $periodCheck));
    }

    public function actionTSave()
    {
        include_once($_SERVER['DOCUMENT_ROOT'].'/cron/Ssh2_crontab_manager.php');
        $crontab = new Ssh2_crontab_manager('46.30.42.79', '22', 'root', '629265');

        $arrSelect = array(
            0 => array('0 */01 * * *','Каждые 3 часа'),
            //1 => array('* * */01 * *','Каждый день'),
        );

        $time = $_POST['timer'];
        $usereId = $_POST['userId'];

        $user = str_replace('+','',Yii::app()->user->name);

        if(isset($time)){
           $crontab->append_cronjob(''.$arrSelect[$time][0].'  /usr/bin/wget -O /dev/null -q http://'.$_SERVER['SERVER_NAME'].'/publish/index.php?userId='.$usereId.'&idAds=61&name='.$user.'&time='.$time.'>/dev/null 2>&1');
        }
        $this->redirect(array('index'));
    }
    // удаляем таймер
    public function actionTdel()
    {
        include_once($_SERVER['DOCUMENT_ROOT'].'/cron/Ssh2_crontab_manager.php');
        $crontab = new Ssh2_crontab_manager('46.30.42.79', '22', 'root', '629265');

        $cron_jobs = $crontab->get_cronjobs();
        // удаляем пустые задачи
        $crontab->remove_cronjob('/^$/');

        foreach($cron_jobs as $key => $value){
            $cronArr[$key] = $value;
        }

        for($i = 0; $i < count($cronArr); $i++){
            if(preg_match('/userId='.Yii::app()->user->id.'/', $cronArr[$i])){
                unset ($cronArr[$i]);
            }else{
                $arr[] = $cronArr[$i];
            }

        }

       // удаляем весь крон
       $crontab->remove_cronjob();
       // пишем заново
       $crontab->append_cronjob($arr);
       $this->redirect(array('timer'));
    }
    // публиовать или нет объявления
    public function actionPublic($id,$show)
    {
        ($show == 0) ? $show = 1 : $show = 0;
         $post = publication::model()->findByPk($id);
         $post->publich = $show;
         $post->save(); // сохраняем изменения

         $this->redirect(array('index','active'=>Yii::app()->request->getParam('active'),'page'=>Yii::app()->request->getParam('page')));
    }
    // показывать ли email и имя в контактах
    public function actionShowContact($id,$show){

        ($show == 0) ? $show = 1 : $show = 0;
        $post = TablePublicContacts::model()->findByPk($id);
        $post->show = $show;
        $post->save(); // сохраняем изменения

        $this->redirect(array('contact'));

    }
    // скрываем показываем элементы
    function actionShowUp($str, $show){

        $arr = explode(',',$str);
        $criteria = new CDbCriteria;
        $criteria->addInCondition("id" , $arr) ; // $wall_ids = array ( 1, 2, 3, 4 );

        if($show == 1){
           $criteria->addCondition('publich=0');
        }else if($show == 0){
           $criteria->addCondition('publich=1');

        }

        $upd = publication::model()->updateAll(array('publich'=>$show), $criteria);

        if($upd > 0){
           $this->redirect(array('index'));
        }

    }
    // строим дерево категорий
    function actionGetCat(){
        $id = $_GET['id'];
        $select_id = $_GET['selid']+1;

        $catNew = new TableNewCategory();
        $arrCat = $catNew::model()->findAllBySql('SELECT * FROM table_new_category WHERE parent = '.$id);

        if($arrCat){
        $select = '<option value = "8888" selid="'.$select_id.'"> ------ </option>';

        foreach($arrCat as $key => $value){
            //$arrSelectCat[$key] = $value;
            $select .= '<option selid="'.$select_id.'" bid = "'.$value['bid'].'" value = "'.$value['id'].'">'.$value['name'].'</option>';
        }
        }
       echo $select;

    }
    // таривы
    public function actionRates(){
        $models = 1;
        $this->render('rates',array('dataProvider'=>$models,));
    }
    // помощь
    public function actionHelp(){
        echo 'раздел в разработке';
    }
    // ajax модель автомобиля
    public function actionGetModelAvto(){
        $id =  trim($_GET['id']);
        $model = TableBrend::model()->findAll('parent = '.$id);

        $sel = '';

        foreach($model as $key => $value){
             $sel .= '<option value = "'.$value['id'].'">'.$value['name'].'</option>';
        }
        echo $sel;


    }
    // страница для теста
    public function actionTest(){
        $models = 1;
        $this->render('test',array('dataProvider'=>$models,));
    }
    // админка для менеджеров
    public function actionManager(){
        $criteria = new CDbCriteria();

        $criteria->order = 'id DESC'; //countPay

        if(trim($_GET['loginPhone'])){
           $criteria->addCondition("username =".trim($_GET['loginPhone'])." or phone = ".trim($_GET['loginPhone']));//." or phone = ".trim($_POST['loginPhone'])
        }

        if(trim($_GET['countPay'])){
            $criteria->addCondition("countPay =".trim($_GET['countPay']));
        }

        if(trim($_GET['resid'])){
            $criteria->addCondition("residPublic =".trim($_GET['resid']));
        }
        if(trim($_GET['ostatok'])){
            $criteria->addCondition("residPublic < ".trim($_GET['ostatok']));
        }

        $count = User::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        // получаем количество объектов на странице

        $countPage = trim($_COOKIE["countPage"]);
        if($countPage){
            $pages->pageSize = trim($_COOKIE["countPage"]);
        }else{
            $pages->pageSize = 20;
        }

        $pages->applyLimit($criteria);
        $models = User::model()->findAll($criteria);

        $this->render('application.views.publication.manager.manager',array('dataProvider'=>$models, 'pages' => $pages,'count'=>$count,));
    }


}
