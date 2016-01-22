<?php

class RealtyObjectController extends Controller
{
    public $description = '';
    public $keywords = '';
    public $title = '';


    //public $defaultAction = 'guest';

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'MyCCaptchaAction',
                'backColor'=>0xFFFFFF,

            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),

        );
    }
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
            /*
            array(
                'CHttpCacheFilter + index',
                'lastModified'=>Yii::app()->db->createCommand("SELECT MAX(`dateTime`) FROM table_object")->queryScalar(),
            ),
            */


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
				'actions'=>array('index','add_ads_end','error','repeatAds','deleteAds','ShowCheckedAds','delCheckedAds','del_index','create','update','SelCatChange','Recently','captcha','tips','index','realtyObject','view','Notebook','guest','NewUser','Offers','Sitemap','CreateRss','Yml','GetMail','sendLink','recommendations'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('ViewAccessNote','DelGuestNote','OfficePayment','PaymentEnd','OfficePaymentHistory','AddNotebook','myAds','Show','AccessOpenNote','option','Invite','Sold','Codesofpublic','DelAdsAdmin','AddComments','DelComments'),
				'users'=>array('@'),
			),

			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('PhoneAgent'),
				'users'=>array('+79631099211'),
			),

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
        if($_GET['comments'] == 1){
           $comments = TableComments::model()->findAll('idAds = '.$id.' and userId = '.Yii::app()->user->id);
        }

        $this->render('view',array('model'=>$this->loadModel($id),'comments' => $comments));
	}

    // выбор категории объвления
    public function actionSelCatChange(){

        if($_POST['idCat']){
            $cat = new TableCategory();
            $arrCat = $cat::model()->findBySql('SELECT idCat,parent FROM table_category WHERE idCat = '.$_POST['idCat']);

            $arr = array();
            // если есть главная категория
            if($arrCat['parent'])   $arr[] = $arrCat['parent'];

            $arr[] = $_POST['idCat'];

            if($arr)    echo json_encode($arr);

        }else{
           $sel = $_POST['select'];
           $secondCat = TableCategory::model()->findAll('parent = '.$sel);
           //print_r($secondCat);
           $arr = array();
           foreach($secondCat as $key => $value){
              $arr[$value['idCat']] =  $value['name'];
           }
           //print_r($arr);
           if($arr){
             echo json_encode($arr);
           }
        }
    }

    public function actionAdd_ads_end(){
        $this->render('add_ads_end',array('id'=> $_GET['id'],'manager' => $_GET['manager']));
    }

    public function actionRepeatAds(){
        $this->render('repeatAds');
    }
    // публиовать или нет объявления
    public function actionShow($id,$show)
    {
        ($show == 0) ? $show = 1 : $show = 0;
        $post = realtyObject::model()->findByPk($id);
        $post->view = $show;
        $post->save(); // сохраняем изменения

        $this->redirect(array('realtyObject/myads/','page'=>Yii::app()->request->getParam('page')));

    }

	// создание объявления
	public function actionCreate(){

        include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/SimpleImage.php');

        $model=new realtyObject;

        if(isset($_POST['realtyObject']))
        {
            // проверяем является ли объявление дублем
            $n  = $model::model()->findAllBySql('SELECT phone, price, idCat FROM table_object WHERE dateTime > (NOW() - interval 10 day)');

            foreach($n as $key => $value){
                $run['Refrech'][$key]['phone'] = $value['phone'];
                $run['Refrech'][$key]['price'] = $value['price'];
                $run['Refrech'][$key]['idCat'] = $value['idCat'];
            }

            $rPhone = (int)$_POST['realtyObject']['phone'];
            $rPrice = (int)$_POST['realtyObject']['price'];
            $rIdCat = (int)$_POST['realtyObject']['idCat'];


            foreach ($run['Refrech'] as $key => $value) {
                if($value['phone'] == $rPhone and $value['price'] == $rPrice and $value['idCat'] == $rIdCat){
                   $this->redirect(array('realtyObject/repeatAds/'));
                }
            }
            // проверяем является ли объявление дублем (проверили)
           $ModelDist = new TableCityMicrodistricts();
           // определяем район города
           if($_POST['realtyObject']['microdistrict']){
               $district = $ModelDist::model()->findBySql('SELECT district_id FROM table_city_microdistricts WHERE id = '.$_POST['realtyObject']['microdistrict']);
               $_POST['realtyObject']['district'] = $district['district_id'];
           }

           // смотрим агент или нет
           $agentPhone  = TableAgentPhone::model()->findAllBySql('SELECT phone FROM table_agent_phone WHERE `show` = 1');

           foreach($agentPhone as $key => $value){
               $arrAgentPhone[$key] = $value['phone'];
           }

           if(in_array(trim($_POST['realtyObject']['phone']),$arrAgentPhone)){
               $_POST['realtyObject']['agent'] = 2;
           }else{
               $_POST['realtyObject']['agent'] = 1;
           }

           $model->attributes=$_POST['realtyObject'];

           if($model->save()){
               $dirname = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/cacheImg/'.$_SESSION['upload'].'/';
               $dirdestination = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/user/'.$_POST['realtyObject']['idAds'].'/';
               Yii::app()->app->lowering($dirname,$dirdestination);

               // создание миниатюры
               $smallImg = Yii::app()->app->get_files($dirdestination);
               if($smallImg[0]){
                   $fileNameSmall = $dirdestination.'small/'.$smallImg[0];
                   if(!file_exists($fileNameSmall)){
                       mkdir($dirdestination.'small/', 0755);
                       $imgSmall = new SimpleImage($dirdestination.$smallImg[0]);
                       $imgSmall->resizeToWidth(150);
                       $imgSmall->save($fileNameSmall);
                   }
               }

               if(Yii::app()->user->isGuest){
                   $id = Yii::app()->db->lastInsertID;

                   $manager = $_POST['realtyObject']['url_manager'];

                   if($_POST['realtyObject']['email']){

                       $url = '<a href = "http://'.$_SERVER['HTTP_HOST'].'/index.php?r=realtyObject/update&id='.$id.'&manager='.$manager.'">
                               http://'.$_SERVER['HTTP_HOST'].'/index.php?r=realtyObject/update&id='.$id.'&manager='.$manager.'
                              </a>';

                       $email = Yii::app()->email;

                       $email->to = trim($_POST['realtyObject']['email']);

                       $email->from = "=?utf-8?b?" . base64_encode('Недвижимость Пензы') . "?= <admin@rlpnz.ru.ru>";

                       $email->subject = 'Объявление "'.mb_substr($_POST['realtyObject']['title'],0,50,'utf-8').'"';

                       $email->message = '
                       <p>Здравствуйте!</p>
                       <p>На сайте "Недвижимость Пензы" с вашим адресом электронной почты было принято объявление "'.$_POST['realtyObject']['title'].'"</p>
                       <p>Просим обратить ваше внимание на то, что данное письмо не означает, что объявление будет опубликовано.
                          Объявление отправлено администраторам и будет опубликовано только после его проверки, это может занять некоторое время.</p>
                       <p><h3>Управляющая ссылка</h3></p>
                       <p>'.$url.'</p>
                       <p>С помощью управляющей ссылки вы сможете редактировать свое объявление</p>
                       ';

                       $email->send();
                   }

                   $this->redirect(
                       array('realtyObject/add_ads_end/',
                             'id'=>$id,
                             'manager'=>$manager,
                             'title' => $_POST['realtyObject']['title'],
                             'cat' => $_POST['realtyObject']['idCat']
                       ));
               }else{
                   $this->redirect(array('realtyObject/myads'));
               }

           }


        }
        
        $cat = new TableCategory();
        $arrCat = $cat::model()->findAllBySql('SELECT idCat,parent,name FROM table_category WHERE parent = 0');

        foreach($arrCat as $key => $value){
            $arrSelectCat[$key] = $value;
        }
        
        // город
        $modelsCityRegion = TableCityRegion::model()->findAll();
        $arrSelectCityRegion = CHtml::listData($modelsCityRegion, 'id', 'name');

        // микрорайя
        $modelsMicroDistrict = TableCityMicrodistricts::model()->findAll(array('order'=>'name'));
        $arrSelectMicroDistrict = CHtml::listData($modelsMicroDistrict, 'id', 'name');
        // тип сделки
        $modelsTransaction = TableTypeTransaction::model()->findAll();
        $arrSelectTransacnion = CHtml::listData($modelsTransaction, 'id', 'name');
        // тип дома
        $modelsHouseType = TableHouseTypes::model()->findAll();
        $arrSelectHouseType = CHtml::listData($modelsHouseType, 'id', 'name');
        // количество комнат
        $modelsCountRooms = TableCountRooms::model()->findAll();
        $arrSelectCountRooms = CHtml::listData($modelsCountRooms, 'id', 'name');
        
	    $this->render('create',array(
	        'model'=> $model,
	        'idCat' => $arrSelectCat,
	        'city' => $arrSelectCityRegion,
	        'microdistrict' => $arrSelectMicroDistrict,
	        'transaction' => $arrSelectTransacnion,
	        'typeHouse' => $arrSelectHouseType,
	        'countRooms' => $arrSelectCountRooms,
	        ));
	}

    public function actionUpdate($id){

    $model=$this->loadModel($id);
    // проверяем код доступа
    if($model->url_manager == trim($_GET['manager'])){

            if(isset($_POST['realtyObject']))
            {
               $model->attributes=$_POST['realtyObject'];
               if($model->save()){
                   if(Yii::app()->user->isGuest){
                       $this->redirect(array('index'));
                   }else
                   {
                       include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/SimpleImage.php');
                       $dirdestination = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/user/'.$_POST['realtyObject']['idAds'].'/';
                       $smallImg = Yii::app()->app->get_files($dirdestination);
                       if($smallImg[0]){
                           $fileNameSmall = $dirdestination.'small/'.$smallImg[0];
                           if(!file_exists($fileNameSmall)){
                               mkdir($dirdestination.'small/', 0755);
                               $imgSmall = new SimpleImage($dirdestination.$smallImg[0]);
                               $imgSmall->resizeToWidth(80);
                               $imgSmall->save($fileNameSmall);
                           }
                       }
                       $this->redirect(array('realtyObject/myads'));
                   }

               }
            }


            $cat = new TableCategory();
            $arrCat = $cat::model()->findAllBySql('SELECT idCat,parent,name FROM table_category WHERE parent = 0');

            foreach($arrCat as $key => $value){
                $arrSelectCat[$key] = $value;
            }

            // город
            $modelsCityRegion = TableCityRegion::model()->findAll();
            $arrSelectCityRegion = CHtml::listData($modelsCityRegion, 'id', 'name');

            // микрорайя
            $modelsMicroDistrict = TableCityMicrodistricts::model()->findAll(array('order'=>'name'));
            $arrSelectMicroDistrict = CHtml::listData($modelsMicroDistrict, 'id', 'name');
             // тип сделки
            $modelsTransaction = TableTypeTransaction::model()->findAll();
            $arrSelectTransacnion = CHtml::listData($modelsTransaction, 'id', 'name');
            // тип дома
            $modelsHouseType = TableHouseTypes::model()->findAll();
            $arrSelectHouseType = CHtml::listData($modelsHouseType, 'id', 'name');
            // количество комнат
            $modelsCountRooms = TableCountRooms::model()->findAll();
            $arrSelectCountRooms = CHtml::listData($modelsCountRooms, 'id', 'name');

            $this->render('update',array(
               'model'=> $model,
               'idCat' => $arrSelectCat,
               'city' => $arrSelectCityRegion,
               'microdistrict' => $arrSelectMicroDistrict,
               'transaction' => $arrSelectTransacnion,
               'typeHouse' => $arrSelectHouseType,
               'countRooms' => $arrSelectCountRooms,
            ));
        }else{
               $this->render('error');
    }

    }

    public function actionDeleteAds($idAds)
    {
        $id = realtyObject::model()->findBySql('SELECT id FROM table_object WHERE idAds = '.$idAds);

        $this->loadModel($id['id'])->delete();
        $dir = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/user/'.$idAds.'/';
        Yii::app()->app->removeDirRec($dir);
        $this->redirect(array('realtyObject/del_index/'));
    }
    // удалить много объявлений
    public function actionDelCheckedAds($param){

        $item = explode(',',$param);

        foreach($item as $value){
            $res = realtyObject::model()->find('id = '.$value);
            $this->loadModel($value)->delete();
            $dir = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/user/'.$res['idAds'].'/';
            Yii::app()->app->removeDirRec($dir);
        }
        echo 1;
    }
    // удаляем общий блокнот
    function actionDelGuestNote($user, $id){
          $res = nAccessGuest::model()->find('cat_show = '.$id.' and user_read = '.$user);
          $this->loadModelNotDel($res['id'])->delete();
        echo 1;
    }
    // отккрываем доступ к своим блокнотам
    function actionAccessOpenNote($phone){
        $pattern = array('+',' ',')','(','-');
        $phone_ = str_replace($pattern, '',$phone);
        $user = new User;
        if($user->model()->count("username = :username",
            array(':username' => $phone_))) {

            $userId = $user::model()->findAll('phone = '.$phone_);
            if($userId[0]['id'] != Yii::app()->user->id){

                $elem = explode(',',substr($_COOKIE["cheked_note"],0,-1));

                    foreach($elem  as $key => $value){
                        $q = nAccessGuest::model()->findBySql('SELECT id FROM table_n_access_guest WHERE user_read = '.$userId[0]['id'].' and user_creat = '.Yii::app()->user->id.' and  cat_show = '.$value);
                        if(!$q['id']){
                            $note = new nAccessGuest();
                            $note->user_creat = Yii::app()->user->id;
                            $note->user_read  = $userId[0]['id'];
                            $note->cat_show   = $value;
                            $note->save();
                        }

                    }
                   echo 1;
            }else{
                echo 2; // нельзя сылаться на себя
            }

        }else{
            echo 0;
        }

    }
    // даем возможность просмотреть
    function actionViewAccessNote($cat,$user){
        $q = nAccessGuest::model()->findBySql('SELECT id FROM table_n_access_guest WHERE user_read = '.Yii::app()->user->id.' and user_creat = '.$user.' and  cat_show = '.$cat);
        if($q['id']){
            $list =  Notebook::model()->findAllBySql('SELECT idAds FROM table_notebook WHERE userId = '.$user.' and idCat = '.$cat);

            for($i = 0; $i < count($list); $i++){
                $n[] = $list[$i]['idAds'];
            }

            $criteria = new CDbCriteria();

            $criteria->order = 'id DESC';

            $criteria->addInCondition('id' ,$n); // $wall_ids = array ( 1, 2, 3, 4 );

            $count = realtyObject::model()->count($criteria);
            $pages = new CPagination($count);

            $countPage = trim($_COOKIE["countPage"]);
            if(isset($countPage)){
                $pages->pageSize = trim($_COOKIE["countPage"]);
            }else{
                $pages->pageSize = 20;
            }
            $pages->applyLimit($criteria);
            $models = realtyObject::model()->findAll($criteria);

            $this->render('application.views.realtyObject.notebook.index',array('dataProvider'=>$models, 'pages' => $pages,'count'=>$count,));

        }

    }
    // публикуем скрываем несколько объявлений
    function actionShowCheckedAds($str, $show){

        $arr = explode(',',$str);
        $criteria = new CDbCriteria;
        $criteria->addInCondition("id" , $arr) ; // $wall_ids = array ( 1, 2, 3, 4 );

        if($show == 1){
            $criteria->addCondition('view=0');
        }else if($show == 0){
            $criteria->addCondition('view=1');

        }

        $upd = realtyObject::model()->updateAll(array('view'=>$show), $criteria);

        if($upd > 0){
            $this->redirect(array('realtyObject/myads'));
        }

    }

    public function actionDel_index(){
        $this->render('del_index');
    }

	public function actionIndex()
	{
        $criteria = new CDbCriteria();

        if(trim($_COOKIE["order"]) == 2){
           $criteria->order = 'price=0, price';
        }elseif(trim($_COOKIE["order"]) == 3){
           $criteria->order = 'price DESC';
        }else{
           $criteria->order = 'dateTime DESC';
        }

        // проверяем существует ли категория
        if(trim($_GET['cat'])){
            $criteria->condition = Yii::app()->app->getPathCat($_GET['cat']); 
        }
        if(trim($_GET['header'])){
            $criteria->addCondition("title LIKE '%".trim($_GET['header'])."%'");
        }

        // $criteria->addCondition("price > 100 and price < 10000000");

        if(trim($_GET['phone'])){
            $pattern = array('+','(',')',' ','-','.',',','*','$');
            $phone = str_replace($pattern,'',trim($_GET['phone']));
        	$criteria->addCondition("phone =".trim($phone));
        }
        if(trim($_GET['city'])){
        	$criteria->addCondition("city =".$_GET['city']);
        }
        if(trim($_GET['districts'])){
        	$criteria->addCondition("district =".$_GET['districts']);
        }
        if(count($_GET['microdistricts']) > 0){
                $microdistricts = '';
                foreach ($_GET['microdistricts'] as $key => $value) {
                    $microdistricts .= $value.',';
                }
             $microdistricts = substr($microdistricts, 0,-1);
             $criteria->addCondition('microdistrict IN('.$microdistricts.')');
        }
        if(trim($_GET['transaction'])){
        	$criteria->addCondition("transaction =".$_GET['transaction']);
        }
        if(trim($_GET['houseTypes'])){
        	$criteria->addCondition("typeHouse =".$_GET['houseTypes']);
        }
        if(trim($_GET['street'])){
        	$criteria->addCondition("street LIKE '%".trim($_GET['street'])."%'");
        }
        // этажность
        if(trim($_GET['floor_start'])){
        	$criteria->addCondition("floor >= ".trim($_GET['floor_start']));
        }
        if(trim($_GET['floor_end'])){
            $criteria->addCondition("floor != 0 AND floor <= ".trim($_GET['floor_end']));
        }
        if(trim($_GET['floor_start']) and trim($_GET['floor_end'])){
            $criteria->addCondition("floor >= ".trim($_GET['floor_start'])." AND floor <= ".trim($_GET['floor_end']));
        }
        // площадь
        if(trim($_GET['area_start'])){
        	$criteria->addCondition("totalArea >= ".trim($_GET['area_start']));
        }
        if(trim($_GET['area_end'])){
        	$criteria->addCondition("totalArea != 0 AND totalArea <= ".trim($_GET['area_end']));
        }
        if(trim($_GET['area_start']) and trim($_GET['area_end'])){
            $criteria->addCondition("totalArea >= ".trim($_GET['area_start'])." AND totalArea <= ".trim($_GET['area_end']));
        }
        // цена
        if(trim($_GET['price_start'])){
            $price_start = trim($_GET['price_start']);
            $price_start = str_replace(' ', '', $price_start);
        	$criteria->addCondition("price >= ".$price_start);
        }
        if(trim($_GET['price_end'])){
            $price_end = trim($_GET['price_end']);
            $price_end = str_replace(' ', '', $price_end);
        	$criteria->addCondition("price != 0 AND price <= ".$price_end);
        }
        if(trim($_GET['price_start']) and trim($_GET['price_end'])){

            $price_end = trim($_GET['price_end']);
            $price_end = str_replace(' ', '', $price_end);

            $price_start = trim($_GET['price_start']);
            $price_start = str_replace(' ', '', $price_start);

        	$criteria->addCondition("price >= ".$price_start." AND price <= ".$price_end);
        }
            // показать только опубликованные
            $criteria->addCondition("view = 1");
        // количество комнат
        if($_GET['CountRooms']){
            $countRooms = '';
            foreach ($_GET['CountRooms'] as $key => $value) {
        		$countRooms .= $value.',';
        	}
        	$countRooms = substr($countRooms, 0,-1);
        	
        	if(in_array('4', $_GET['CountRooms'])){
               $criteria->addCondition('countRooms IN('.$countRooms.') OR countRooms >= 4');
        	}else if(in_array('5', $_GET['CountRooms'])){
               $criteria->addCondition('idCat = 2 OR countRooms IN('.$countRooms.')'); 
            }
            else{
        	   $criteria->addCondition('countRooms IN('.$countRooms.')');
        	}
        }
        // сортировка по владельцам
        if(trim($_COOKIE["seller"])){
            $criteria->addCondition('agent = '.trim($_COOKIE["seller"]));
        }
        // поиск по карте
        if(trim($_COOKIE["maps"])){
            $criteria->addCondition('id IN ('.substr(trim($_COOKIE["maps"]),0,-1).')');
            //setcookie ("maps", "", time() - 3600);
        }

        $count = realtyObject::model()->cache(300)->count($criteria);
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
        $models = realtyObject::model()->cache(300)->findAll($criteria);//->cache(300)

        $this->render('index',array('dataProvider'=>$models, 'pages' => $pages,'count'=>$count,));


	}
    // все объекты от продавца
    public function actionOffers($phone){
        $criteria = new CDbCriteria();

        $criteria->order = 'id DESC';

        if(trim($phone)){
            $criteria->condition = ('phone = '.$phone);
        }
        $count = realtyObject::model()->count($criteria);
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
        $models = realtyObject::model()->cache(60)->findAll($criteria);

        $this->render('offers',array('dataProvider'=>$models, 'pages' => $pages,'count'=>$count,));


    }


    // личный кабинет (объявления)
    public function actionMyAds(){

        if(!Yii::app()->user->isGuest){

            $criteria = new CDbCriteria();
            $criteria->order = 'id DESC';

            $criteria->condition = ('user = '.Yii::app()->user->id);

            $count = realtyObject::model()->count($criteria);
            $pages = new CPagination($count);

            $countPage = trim($_COOKIE["countPage"]);
            if($countPage){
                $pages->pageSize = trim($_COOKIE["countPage"]);
            }else{
                $pages->pageSize = 20;
            }

            $pages->applyLimit($criteria);
            $models = realtyObject::model()->findAll($criteria);

            $this->render('application.views.realtyObject.privateOffice.index',array('data'=>$models, 'pages'=>$pages));

        }


    }

    // админка для проверки телефонных номеров
   public function actionPhoneAgent(){
        
        $criteria = new CDbCriteria();
        
        $criteria->order = 'id DESC';
       
        // проверяем существует ли категория

        $criteria->condition = '`show`= 0';
        $criteria->addCondition('objectid != 0');
          
        $count = TableAgentPhone::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        // получаем количество объектов на странице
        $countPage = trim($_COOKIE["countPage"]);
        if($countPage){
           $pages->pageSize = trim($_COOKIE["countPage"]); 
        }else{
           $pages->pageSize = 20; 
        }
        //echo $pages->pageSize;
        $pages->applyLimit($criteria);
        $models = TableAgentPhone::model()->findAll($criteria);

        $this->render('application.views.realtyObject.phoneAgent.index_agentPhone',array('data'=>$models, 'pages' => $pages,'count'=>$count,));
    }

    // блокнот
    public function actionNotebook(){
        
        $nC = trim($_COOKIE["notebook"]);
        $notebook = array();

        // если зарегистрирован
        if(!Yii::app()->user->isGuest){
            $element = Yii::app()->app->checkElemNotebook();

            $idCat = trim($_GET['cat']);
            // проверяем выбранна ли категория, если нет то выводим все корневые
            ($idCat) ? $idCat = $_GET['cat'] : $idCat = 0;

            for($i = 0; $i < count($element); $i++){
                if($element[$i]['idCat'] == $idCat){
                   $notebook[] = $element[$i]['idAds'];
                }
            }

        }else{
            if($nC){
               $notebook = explode(',',$nC);
            }
        }
            $criteria = new CDbCriteria();

            $criteria->order = 'id DESC';

            $criteria->addInCondition("id" , $notebook) ; // $wall_ids = array ( 1, 2, 3, 4 );

            $count = realtyObject::model()->count($criteria);
            $pages = new CPagination($count);

            $countPage = trim($_COOKIE["countPage"]);
            if(isset($countPage)){
               $pages->pageSize = trim($_COOKIE["countPage"]); 
            }else{
               $pages->pageSize = 20; 
            }
            $pages->applyLimit($criteria);
            $models = realtyObject::model()->findAll($criteria);

            $this->render('application.views.realtyObject.notebook.index',array('dataProvider'=>$models, 'pages' => $pages,'count'=>$count,));

    }

    // недавно просмотренные
    public function actionRecently(){
        
        $looked = trim($_COOKIE["looked"]);
        // делаем реверс массива, что бы последний елемент стал первым
        $arr = explode(',', substr($looked, 0, -1));
        $arr = array_reverse($arr);
        // и снова привращаем в строку
        $looked = implode(",", $arr);               

        
        if($looked){
                
            $criteria = new CDbCriteria();
            
            $criteria->order = "FIND_IN_SET(id, '".$looked."')";
           
            // проверяем существует ли категория

            $criteria->condition = 'id IN('.$looked.')'; 
              
            $count = realtyObject::model()->count($criteria);
            $pages = new CPagination($count);

            $countPage = trim($_COOKIE["countPage"]);
            if(isset($countPage)){
               $pages->pageSize = trim($_COOKIE["countPage"]); 
            }else{
               $pages->pageSize = 20; 
            }
            $pages->applyLimit($criteria);
            $models = realtyObject::model()->findAll($criteria);

            $this->render('application.views.realtyObject.Recently._view',array('data'=>$models, 'pages' => $pages,'count'=>$count,)); 
        }else{
            $this->render('application.views.realtyObject.Recently._view');  
        }
    }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return realtyObject the loaded model
	 * @throws CHttpException
	 */
    // личный кабинет
    public function actionOfficePayment(){
        
        $criteria = new CDbCriteria();    
        $criteria->order = 'id DESC';
        $criteria->condition = ('id = '.Yii::app()->user->id);
        $models = User::model()->findAll($criteria);


           $this->render('application.views.realtyObject.privateOffice.payment',array('data' => $models));
    }
    // завершение оплаты
    public function actionPaymentEnd(){
        if(trim($_GET['payment']) == 1){
           $this->render('application.views.realtyObject.privateOffice.paymentEnd'); 
        }else{
           $this->render('application.views.realtyObject.privateOffice.payment'); 
        }
    }
    // история оплаты услуг
    public function actionOfficePaymentHistory(){
        
        $criteria = new CDbCriteria();    
        $criteria->order = 'userId DESC';
        $criteria->condition = ('userId = '.Yii::app()->user->id);
        $models = TableUserPay::model()->findAll($criteria);

        $pay_public = new CDbCriteria();
        $pay_public->order = 'userId DESC';
        $pay_public->condition = ('userId = '.Yii::app()->user->id);
        $models2 = TablePayPublic::model()->findAll($criteria);

        $this->render('application.views.realtyObject.privateOffice.historyPay',array('data' => $models, 'pay_public' => $models2));
    }

	public function loadModel($id)
	{
		$model=realtyObject::model()->cache(60)->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    // загружаем модель для удаления открытых другими пользователями блокнотов
    public function loadModelNotDel($id){
        $model = nAccessGuest::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

	/**
	 * Performs the AJAX validation.
	 * @param realtyObject $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='realty-object-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    // добавить объект в блокнот
    public function actionAddNotebook($id, $idCat){

        //$contact = Notebook::model()->findAll('idAds = '.$id);

        //if(!$contact){
            $postCat = new Notebook();
            $postCat->idAds = $id;
            $postCat->idCat = $idCat;
            $postCat->userId = Yii::app()->user->id;
            $postCat->save();
            echo 1;
        //}else{
        //    echo 0;
        //}

    }
    // советы пользователей
    public function actionTips(){
        $this->render('tips');
    }
    // создание нового пользователя
    public function actionNewUser(){

        $user = new newUser;

        $criteria = new CDbCriteria();

        $criteria->order = 'id DESC';

        $criteria->condition = ('phone != " "');

        $count = $user::model()->count($criteria);
        $pages = new CPagination($count);

        $pages->pageSize = 20;

        $pages->applyLimit($criteria);
        $userList = $user::model()->findAll($criteria);


        if($_POST['newUser']['phone']){

            $pattern = array('(',')','+','-',' ');
            $phone = str_replace($pattern,'',$_POST['newUser']['phone']);

            if($user->model()->count("phone = :phone",
                array(':phone' => $phone))) {

                $user->addError('phone', 'Пользователь с таким номером существует');
                $this->render('application.views.realtyObject.privateOffice.newUser',array('model' => $user,'userList' => $userList, 'pages'=>$pages));

            }else{


                $pass = rand(1000000, 1500000);

                $user->email         = '';
                $user->username      = $phone;
                $user->password      = md5(md5($pass));
                $user->createtime    = date('Y-m-d H:i:s');
                $user->datePayment   = date('Y-m-d H:i:s');
                $user->countPay      = '0';
                $user->residPublic   = '0';
                $user->activationKey = substr(md5(uniqid(rand(), true)), 0, rand(10, 15));
                $user->status        = '0';
                $user->test          = '0';
                $user->phone         = $phone;


                if($user->save()) {
                    include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/smsaero.php');

                    $mess = 'Квартиры от собственника тут rlpnz.ru, Логин:+'.$phone.', Пароль:'.$pass;

                    $sms = new Smsaero('serega569256@bk.ru', 's89048512165', 'INFORM');
                    $sms->send($phone,$mess);

                    // echo $phone;

                    $this->redirect(array('realtyObject/NewUser/'));
                }else {
                    throw new CHttpException(403, 'Ошибка добавления в базу данных.');
                }

            }

        }else{
           $this->render('application.views.realtyObject.privateOffice.newUser',array('model' => $user,'userList' => $userList, 'pages'=>$pages));
        }

    }

    // настройки
    public function actionOption(){

        $model=$this->loadModelUser(Yii::app()->user->id);

        if(isset($_POST['UserOption']))
        {



            $pattern = array('+','(',')',' ','-');

            $user = str_replace($pattern,'',$_POST['UserOption']['username']);

            if(!Yii::app()->app->find_in_str($model->email, $_POST['UserOption']['email'])){
                if($model->model()->count("email = :email", array(':email' => $_POST['UserOption']['email']))) {
                   $model->addError('email', 'E-mail ('.$_POST['UserOption']['email'].') уже занят');
                   $this->render("application.views.realtyObject.privateOffice.option.index_option", array('model' => $model));
                }else{
                   $model->email = $_POST['UserOption']['email'];
                }
            }

            if(!Yii::app()->app->find_in_str($model->username, $user)){
                if($model->model()->count("username = :username", array(':username' => $user))) {
                    $model->addError('username', 'Такой логин ('.$user.') уже существует');
                    $this->render("application.views.realtyObject.privateOffice.option.index_option", array('model' => $model));
                }else{
                    $model->username = $user;
                }
            }

            if($_POST['UserOption']['password']){
               $model->password = md5(md5($_POST['UserOption']['password']));
            }


            if($model->save()){
               $message = 'Настройки вашего аккаунта успешно изменены.';
               $this->redirect(array('realtyObject/option&mess=1'));
            }

        }

        $this->render('application.views.realtyObject.privateOffice.option.index_option',array('model'=>$model,));
    }
    // пригласить друга
    public function actionInvite(){

        $model = new TableInvite;

        if(isset($_POST['TableInvite'])){

            $pattern = array('+','(',')','-',' ');

            $model->phone_to = str_replace($pattern,'',$_POST['TableInvite']['phone_to']);
            $model->invited  = str_replace($pattern,'',Yii::app()->user->name);
            $model->email    = trim($_POST['TableInvite']['email']);
            $model->active   = 0;

            if($model->model()->count("phone_to = :phone_to", array(':phone_to' => $model->phone_to))) {
               $model->addError('phone_to', 'Этот абонент уже был приглашен');
               $this->render('application.views.realtyObject.privateOffice.invite',array('model'=>$model,));
            }
            else if($model->phone_to == $model->invited){
               $model->addError('phone_to', 'Вы не можете пригласить сам себя');
               $this->render('application.views.realtyObject.privateOffice.invite',array('model'=>$model,));
            }
            else{
               if($model->save()){

                   if($model->email){
                      $email = Yii::app()->email;
                      $email->to = trim($_POST['TableInvite']['email']);
                      $email->from = "=?utf-8?b?" . base64_encode('Недвижимость Пензы') . "?= <admin@rlpnz.ru.ru>";
                      $email->subject = 'Ваш друг рекомендует';
                      $email->message = '
                         <p>Здравствуйте!</p>
                         <p>Ваш друг с номером телефона '.Yii::app()->user->name.' рекомендует вам воспользоваться нашим сервисом.</p>
                         <p>Мы предоставляет вам возможность автоматической размещать ваши объявлений на самых популярных ресурсах Пензы и Пензенской области.</p>
                         <p>Также в вашем распоряжении будет самая большая база недвижимости в Пензе.</p>
                         <p>Перейдя по этой <a href = "http://rlpnz.ru/index.php?r=User/default/registration">ссылке</a>, вы сможете зарегистрироваться.</p>
                       ';

                       $email->send();
                   }

                  $this->redirect(array('realtyObject/invite&act=1'));
               }
            }
        }else{
            $this->render('application.views.realtyObject.privateOffice.invite',array('model'=>$model,));
        }
        //TableInvite

    }

    public function loadModelUser($id)
    {
        $model=UserOption::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    // коды платных категорий
    function actionCodesofpublic(){

        $model = new TableCodesOfPublic;

        if(isset($_POST['TableCodesOfPublic'])){

            $model->attributes=$_POST['TableCodesOfPublic'];
            $model->user = Yii::app()->user->id;
            $model->createDate = date('Y-m-d H:i:s');

            if($model->save()){
               $this->redirect(array('realtyObject/codesofpublic'));
            }
        }

        $criteria = new CDbCriteria();

        $criteria->order = 'id DESC';

        $criteria->condition = 'user = '.Yii::app()->user->id;



        $count = TableCodesOfPublic::model()->count($criteria);
        $pages = new CPagination($count);

        $pages->pageSize = 20;

        $pages->applyLimit($criteria);
        $list = TableCodesOfPublic::model()->findAll($criteria);

        $this->render('application.views.realtyObject.privateOffice.codesofpublic',array('model'=>$model,'list'=>$list,'count'=>$count,'pages'=>$pages));
    }

    // Отметить объект как проданый
     function actionSold($id){
         if(isset($id)){
            realtyObject::model()->updateByPk($id, array('sold' => 2));
         }
    }
    // удаление объяление администратором
    public function actionDelAdsAdmin($id){
        if(isset($id)){
           $this->loadModel($id)->delete();
           //$this->redirect(array('realtyObject'));
        }
    }
    // добавить комментарий
    public function actionAddComments($id,$text){
        $model = new TableComments;

        $model->userId = Yii::app()->user->id;
        $model->text = $text;
        $model->idAds = $id;

        if($model->save()){
            //$this->redirect(array('realtyObject/codesofpublic'));
        }

    }
    // модель для удаления комментариев
    public function loadModelComments($id)
    {
        $model=TableComments::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    // удалить комментарий
    public function actionDelComments($id){
        if(isset($id)){
            $this->loadModelComments($id)->delete();
        }

    }
    // формируем sitemap
    public function actionSitemap(){

        $fileName = $_SERVER['DOCUMENT_ROOT'].'/sitemap.xml';

        if(file_exists($fileName)) unlink($fileName);


        $data = "<?xml version='1.0' encoding='UTF-8'?>\n";

        $data .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";
           $data .= "<url>\n";
           $data .= "<loc>http://rlpnz.ru/</loc>\n";
           $data .= "<lastmod>".date('Y-m-d')."</lastmod>\n";
           $data .= "<changefreq>hourly</changefreq>\n";
           $data .= "<priority>1.0</priority>\n";
        $data .= "</url>\n";

        $q = realtyObject::model()->findAllBySql('SELECT * FROM table_object WHERE dateTime > (NOW() - interval 5 day)');

        foreach($q as $key => $value){
          $url = strtolower('/'.Yii::app()->app->getCityPach($value['city']).'/'.Yii::app()->app->translit($value['title'].'_ob_'.$value['idCat'].'_'.$value['id']).'.html');

            $data .= "<url>\n";
                $data .= "<loc>http://rlpnz.ru".trim($url)."</loc>\n";
                $data .= "<lastmod>".date('Y-m-d')."</lastmod>\n";
                $data .= "<changefreq>weekly</changefreq>\n";
                $data .= "<priority>0.8</priority>\n";
            $data .= "</url>\n";
        }

        $data .= "</urlset>\n";

        $fp = fopen($fileName,'w');
        fwrite($fp, $data);
        fclose($fp);

    }
    // rss лента
    public function actionCreateRss(){
        $fileName = $_SERVER['DOCUMENT_ROOT'].'/rss.xml';

        if(file_exists($fileName)) unlink($fileName);

        $data = "<rss xmlns:atom='http://www.w3.org/2005/Atom' version='2.0'>\n";
           $data .= "<channel>\n";
              $data .= "<title>Недвижимость в Пензе</title>\n";
              $data .= "<link>http://rlpnz.ru</link>\n";
              $data .= "<description>Объявления о продаже недвижимости в Пензе</description>\n";
              $data .= "<language>ru</language>\n";
              $data .= "<copyright>rlpnz.ru</copyright>\n";

        $q = realtyObject::model()->findAllBySql('SELECT * FROM table_object WHERE dateTime > (NOW() - interval 1 day)');

        foreach($q as $key => $value){
            $url = strtolower('/'.Yii::app()->app->getCityPach($value['city']).'/'.Yii::app()->app->translit($value['title'].'_ob_'.$value['idCat'].'_'.$value['id']).'.html');

            $difference = time()-strtotime($value['dateTime']);


            $data .= "<item>\n";
               $data .= "<title>".$value['title']."</title>\n";
               $data .= "<link>http://rlpnz.ru".trim($url)."</link>\n";
               $data .= "<guid>http://rlpnz.ru".trim($url)."</guid>\n";
               $data .= "<description>".$q['description']."</description>\n";
               $data .= "<pubDate>".gmdate('D, d M Y H:i:s \G\M\T', time()-$difference+10800)."</pubDate>\n";
            $data .= "</item>\n";
        }


            $data .= "</channel>\n";
        $data .= "</rss>\n";

        $fp = fopen($fileName,'w');
        fwrite($fp, $data);
        fclose($fp);


    }
    // яндекс недвижимость crreate yml
    public function actionYml(){

        $fileName = $_SERVER['DOCUMENT_ROOT'].'/yml.xml';
        if(file_exists($fileName)) unlink($fileName);

        date_default_timezone_set("UTC"); // Можно установить часовой пояс настроив его
        date_default_timezone_set('Europe/Minsk'); // Например, для Москвы

        $data = "<?xml version='1.0' encoding='utf-8'?>\n";
          $data .= "<realty-feed xmlns='http://webmaster.yandex.ru/schemas/feed/realty/2010-06'>\n";
          $data .= "<generation-date>".date('c')."</generation-date>\n";

             //$data .= "<offer internal-id='1245'>\n";

             //$data .= "</offer>";

        $q = realtyObject::model()->findAllBySql('SELECT * FROM table_object WHERE transaction IN(1,2) AND idCat IN(2,7,8,9,10) AND dateTime > (NOW() - interval 30 day)');

        foreach($q as $key => $value){

           if($value['street'] and $value['countRooms'] > 0 and $value['price'] > 0){
            // тип сделки $transaction
           ($value['transaction'] == 1) ? $transaction = 'аренда' : $transaction = 'продажа';
            echo $transaction.'<br>';
            // тип недвижимости
           $property_type = 'жилая';
           echo $property_type;
            // категория
           ($value['idCat'] == 2) ? $category = 'комната' : $category = 'квартира';
            echo $category.'<br>';
           // url
           $url = strtolower('http://rlpnz.ru/'.Yii::app()->app->getCityPach($value['city']).'/'.Yii::app()->app->translit($value['title'].'_ob_'.$value['idCat'].'_'.$value['id']).'.html');
           echo $url.'<br>';
           // дата создания объявления
           $creation_date = date("c", strtotime($value['dateTime']));
           echo $creation_date.'<br>';
           // страна
           $country = 'Россия';
           echo $country;
           // Город
           $locality_name = trim(Yii::app()->app->getCity($value['city']));
           echo $locality_name.'<br>';
           // адрес
           $address = trim($value['street']);
           echo $address.'<br>';
           // телефон
           $phone = trim($value['phone']);
           echo $phone.'<br>';
           // цена
           $price = trim($value['price']);
           // район
           $district = trim(Yii::app()->app->getDistricts($value['district']));
           // продавец
           $dealer = trim($value['NameDealer']);
           // переод аренды
           if($value['idCat'] == 9){
              $period = 'месяц';
           }elseif($value['idCat'] == 10){
              $period = 'день';
           }
           // агент или владелец
           ($value['agent'] == 2) ? $agent = 'агентство' : $agent = 'владелец';
           // картинки
               $path_pars = Yii::app()->app->get_path_pars_img($value['idPars']);
               $imgPath = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/'.trim($path_pars).'/'.$value['idAds'].'/';
               $images = Yii::app()->app->get_files($imgPath);

               $img = 'http://rlpnz.ru/pars/tmp/images/'.trim($path_pars).'/'.$value['idAds'].'/';
               $imgArray = array();
               for($i = 0; $i < count($images); $i++){
                   $imgArray[] =  $img.$images[$i];
               }
           // описание
           if($value['description']){
               $description = trim(strip_tags(str_replace(array("\n","\r","\xC2\xA0","&"), ' ', $value['description'])));
           }





               $data .= "<offer internal-id='".$value['id']."'>\n";
               $data .= "<type>".$transaction."</type>\n";
               $data .= "<property-type>".$property_type."</property-type>\n";
               $data .= "<category>".$category."</category>\n";

               $data .= "<url>".$url."</url>\n";
               $data .= "<creation-date>".$creation_date."</creation-date>\n";

            $data .= "<location>\n";
                 $data .= "<country>".$country."</country>\n";
                 $data .= "<region>Пензенская область</region>\n";
                 if($district){
                 $data .= "<district>".$district."</district>\n";
                 }
                 $data .= "<locality-name>".$locality_name."</locality-name>\n";
                 $data .= "<address>".$address."</address>\n";
            $data .= "</location>\n";

                 $data .= "<sales-agent>\n";
                    $data .= "<phone>".$phone."</phone>\n";
                    $data .= "<category>".$agent."</category>\n";
                    if($dealer){
                    $data .= "<name>".$dealer."</name>\n";
                    }
                 $data .= "</sales-agent>\n";

                 $data .= "<price>\n";
                    $data .= "<value>".$price."</value>\n";
                    $data .= "<currency>RUR</currency>\n";
                    if($period and $value['transaction'] == 1){
                    $data .= "<period>".$period."</period>\n";
                    }
                 $data .= "</price>\n";

                 $data .= "<haggle>0</haggle>\n";
                 if(count($imgArray)>0){
                    for($i = 0; $i < count($imgArray); $i++){
                        $data .= "<image>".$imgArray[$i]."</image>\n";
                    }
                 }
                 if($description){
                    $data .= "<description>".$description."</description>\n";
                 }
                 if($value['totalArea']){
                     $data .= "<area>\n";
                       $data .= "<value>".$value['totalArea']."</value>\n";
                       $data .= "<unit>кв.м</unit>\n";
                     $data .= "</area>\n";
                 }
                 if($value['area']){
                     $data .= "<living-space>\n";
                        $data .= "<value>".$value['area']."</value>\n";
                        $data .= "<unit>кв.м</unit>\n";
                     $data .= "</living-space>\n";
                 }
                 if($value['countRooms']){
                    $data .= "<rooms>".$value['countRooms']."</rooms>\n";
                 }
                 if($value['countRooms']){
                    $data .= "<rooms-offered>".$value['countRooms']."</rooms-offered>\n";
                 }
                 if($value['floor']){
                     $data .= "<floor>".$value['floor']."</floor>\n";
                 }
                 if($value['floors']){
                     $data .= "<floors-total>".$value['floors']."</floors-total>\n";
                 }

            $data .= "</offer>\n";



           }

        }

        $data .= "</realty-feed>\n";

        $fp = fopen($fileName,'w');
        fwrite($fp, $data);
        fclose($fp);

    }
    // отправка почтового сообщения
    public function actionGetMail(){

        $mess = "<html>";
           $mess .= "<body>";
             if($_POST['name']){
               $mess .= "<b>Имя:</b> ".trim($_POST['name']).'<br>';
             }
             if($_POST['email']){
               $mess .= "<b>email:</b> ".trim($_POST['email']).'<br>';
             }
             if($_POST['phone']){
               $mess .= "<b>Телефон:</b> ".trim($_POST['phone']).'<br>';
             }
             if($_POST['description']){
                 $mess .= '<b>Вопрос</b><br>';
                 $mess .= trim($_POST['description']).'<br>';
             }
           $mess .= "</body>";
        $mess .= "</html>";
        $title = 'Вопрос по вашему объекту';

        Yii::app()->app->getMessage('aligoweb@ya.ru',$mess,$title);
    }
    // отправить ссылку другу
    public function actionSendLink(){
        //echo $_POST['email'];
        $Main_email = $_POST['mainMail'];
        $title = 'Ваш друг рекомендует';
        $mess = "<b>Ваш друг email(".$Main_email.") советует вам просмотреть это объявление</b> <a href = '".$_POST['link']."'>Перейти по ссылке для просмотра</a>";
        Yii::app()->app->getMessage(trim($_POST['email']), $mess, $title);
    }

    // рекомендации
    public function actionRecommendations(){
      $this->render('recommendations');
    }

}
