<?php
class app extends CApplicationComponent{
      
      // иницализируем компонент
      public function init(){
             parent::init();
      }
      // пулучаем файлы из директории
      public function get_files($path, $order = 0, $mask = '*') {
	    $sdir = array();
	    // получим все файлы из дирректории
	    if (file_exists($path) && false !== ($files = scandir($path, $order))){
	      foreach ($files as $i => $entry){
	        // если имя файла подходит под маску поика
	        if ($entry != '.' && $entry != '..' && is_file($path.$entry) && fnmatch($mask, $entry)){
	          $sdir[] = $entry;
	        }
	      }
	    }
	    return ($sdir);
	  }
      // удаляем ненужные файлы
      // 'pars/tmp/images/'.$parserName.'/'.$value[0].'';
      public function removeDirRec($dir)
      {
        if ($objs = glob($dir."/*")) {
            foreach($objs as $obj) {
                is_dir($obj) ? $this->removeDirRec($obj) : unlink($obj);
            }
        }
        rmdir($dir);
      }
    // получаем путь до картинок по id парсера
	  public function get_path_pars_img($id){
	  	 
	  	 $post = new TableIdpars;
	  	 $data = $post::model()->findBySql('SELECT name FROM table_idpars WHERE idPars = :num',array(':num' => $id));
	  	 
	  return $data['name'];
	  }

	  // дата
	  public function formatDate($odate, $templ = '%d %m %y %h:%i', $return = 'tmp') {
    $date = array();
    list($ymd,$hms) = explode(' ',$odate);
    list($date['y'],$date['m'],$date['d']) = explode('-',$ymd);
    list($date['h'],$date['i'],$date['s']) = explode(':',$hms);

    if($ymd == date('Y-m-d')){
       $date = 'Сегодня '.$date['h'].':'.$date['i'];
    }else{

        if($return == 'tmp'){
          switch ($date['m']) {
            case 1:$date['m'] = 'января';break;
            case 2:$date['m'] = 'февраля';break;
            case 3:$date['m'] = 'марта';break;
            case 4:$date['m'] = 'апреля';break;
            case 5:$date['m'] = 'мая';break;
            case 6:$date['m'] = 'июня';break;
            case 7:$date['m'] = 'июля';break;
            case 8:$date['m'] = 'августа';break;
            case 9:$date['m'] = 'сентября';break;
            case 10:$date['m'] = 'октября';break;
            case 11:$date['m'] = 'ноября';break;
            case 12:$date['m'] = 'декабря';break;
          }

          $templ = str_replace(
            array("%d","%m","%y","%h","%i","%s"), 
            array($date['d'],$date['m'],$date['y'],$date['h'],$date['i'],$date['s']), 
            $templ);

           

          return $templ;
        }else {
          return $date;
        }
    }
    return $date;
  }

  public function getPathCat($parent){

        $criteria = new CDbCriteria();

        $criteria->select = 'id,bid';
        $criteria->condition = 'parent='.$parent;
      
        //$criteria->params = array(':parent'=>$parent);

        $models = TableNewCategory::model()->findAll($criteria);

        static $arrayCat = array();

        foreach($models as $key => $value){

            if($value['id']){
               $arrayCat[] =  $value['bid'];
               $this->getPathCat($value['id']);
            }

        }

      $str = '';

      foreach($arrayCat as $val){
          $str .= $val.',';
      }

      $str = substr($str,0,-1);


             if($str){
                $Sql = 'idCat in ('.$str.')';
             }elseif($parent){
                $Sql = 'idCat = '.$parent;
             }else{
                $Sql = '';
             }

      return $Sql;





    }

   function countElement($sql = 1){
      $post = new realtyObject;
      
      // точный подсчет сколько объявлений относятся к какому типу продажи частный\агент\все
      $agent = $_COOKIE["seller"];
      if($agent == 1){
        $sql = $sql.' AND agent = 1';
      }elseif($agent == 2){
        $sql = $sql.' AND agent = 2';
      }else{
        $sql = $sql;
      }

      $count = $post::model()->count(array(
       'select'=>'id',
       'condition'=> $sql,
      ));
     return $count;
  }

  // хлебные крошки
  public function breadcrumbs($idCat){
      
      $Post = new TableCategory;
      $data = $Post::model()->findBySql('SELECT * FROM table_category WHERE idCat = :num',array(':num' => $idCat));

      if($data['parent']) $this->breadcrumbs($data['parent']);

      //$url = Yii::app()->createUrl('realtyObject/index&cat='.$data['idCat']);
      $url = strtolower('/'.$this->getCatPach(trim($idCat)).'_'.$idCat.'.html');

      echo "<li><i><img src = '/images/breadcrumbs.jpg'></i><a href = '".$url."' title = '".$data['name']." купить, продать, сдать в Пензе'>".$data['name']."</a></li>";

  }
  // title категории
  public function titleCat($idCat){
      $Post = new TableCategory;
      $data = $Post::model()->findBySql('SELECT * FROM table_category WHERE idCat = :num',array(':num' => $idCat));

      return $data['name'];
  }
  // определение города (выбранное области)
  public function getCity($id){
      
      $Post = new TableCityRegion;
      $data = $Post::model()->findBySql('SELECT name FROM table_city_region WHERE id = :num',array(':num' => $id));

  return $data['name'];
  }
  // определение районна города
  public function getDistricts($id){

     $Post = new TableCityDistricts;
     $data = $Post::model()->findBySql('SELECT name FROM table_city_districts WHERE id = :num',array(':num' => $id));

  return $data['name'];
  }
  // опредеялем микрорайон
  public function getMicrodistrict($id){

     $Post = new TableCityMicrodistricts;
     $data = $Post::model()->findBySql('SELECT name FROM table_city_microdistricts WHERE id = :num',array(':num' => $id));

  return $data['name'];
  }
  // тип сделки
  public function getTransaction($id){
     
     $Post = new TableTypeTransaction;
     $data = $Post::model()->findBySql('SELECT name FROM table_type_transaction WHERE id = :num',array(':num' => $id));

  return $data['name'];
  }
  // тип дома
  public function getTypeHouse($id){

    $Post = new TableHouseTypes;
    $data = $Post::model()->findBySql('SELECT name FROM table_house_types WHERE id = :num',array(':num' => $id));

  return $data['name'];
  }

 // массивы данных для поиска
 public function dataSearch(){
      $City = new TableCityRegion;
      $Districts = new TableCityDistricts;
      $Microdistricts = new TableCityMicrodistricts;
      $Transaction = new TableTypeTransaction;
      $HouseTypes = new TableHouseTypes;
      $Category = new TableCategory;
      $Contact = new TablePublicContacts;

      $cat = new TableNewCategory();
      //$cata = $cat::model()->findBySql('SELECT * FROM table_new_category WHERE bid = '.$id);

      
      $data['city'] = $City::model()->cache(5000)->findAllBySql('SELECT * FROM table_city_region');
      $data['districts'] = $Districts::model()->cache(5000)->findAllBySql('SELECT * FROM table_city_districts');
      $data['microdistricts'] = $Microdistricts::model()->cache(5000)->findAllBySql('SELECT * FROM table_city_microdistricts ORDER BY name');
      $data['transaction'] = $Transaction::model()->cache(5000)->findAllBySql('SELECT * FROM table_type_transaction');
      $data['houseTypes'] = $HouseTypes::model()->cache(5000)->findAllBySql('SELECT * FROM table_house_types');
      $data['category'] = $cat::model()->findAllBySql('SELECT * FROM table_new_category WHERE parent = 0');

      if(!Yii::app()->user->isGuest){
         $data['contact'] =  $Contact::model()->findAllBySql('SELECT * FROM table_public_contacts WHERE userid = '.Yii::app()->user->id);
      }
 
 return $data;
 }

// сортировка по собственикам
public function dealerSort(){
       $agent = array('Все' => 0,'Частные' => 1, 'Агентство' => 2 );

       foreach ($agent as $key => $value) {
         $temp .= '<div class = "sortAgent" id = "'.$value.'">'.$key.'</div>';
       }
return $temp;
} 

// общее количество объявлений
public function allCountAds(){
       $criteria = new CDbCriteria();
       $criteria->order = 'id DESC';
       $count = realtyObject::model()->cache(300)->count($criteria);
return $count;
}

// перриод оплаты
public function testPeriod($period = 7){
  
  $id = Yii::app()->user->id;
  
  $user = new User();
  $q = $user::model()->findBySql('SELECT  datePayment FROM table_User WHERE id = :num',array(':num' => $id));
  
  $payment = $q['datePayment'];
  $now     = date('Y-m-d H:i:s');

  ($now > $payment) ? $status = 0 : $status = 1;

return $status;
}

// определение логина пользователя по id
public function nameUser($id){
      $user = new User();
      $q = $user::model()->findBySql('SELECT username FROM table_User WHERE id = :num',array(':num' => $id));

return $q['username'];
}
// название блокнота
public function nameNoteCat($id){
    $q = NBookCat::model()->findBySql('SELECT name FROM table_n_book_cat WHERE id = :num',array(':num' => $id));
return $q['name'];
}

// конец публикуемых объявлений
public function endCountAds(){
    $id = Yii::app()->user->id;
    $user = new User();
    $q = $user::model()->findBySql('SELECT  residPublic FROM table_User WHERE id = :num',array(':num' => $id));
    if($q['residPublic'] == 0){
       return 1;
    }else{
       return 0;
    }
}

// информер срок окончания оплаты
public function dateEndPay(){

       $id = Yii::app()->user->id;
       $user = new User();

       if($this->activeConroller('publication')){
           $q = $user::model()->findBySql('SELECT  countPay,residPublic FROM table_User WHERE id = :num',array(':num' => $id));
           if($q['residPublic'] > 0){
              $result = "<span>Оплачено:</span> ".number_format($q['countPay'],0,'',' ')." | <b> Остаток: </b>".number_format($q['residPublic'],0,'',' ');
           }else{
               $result = "<span>Не оплачено</span>";
           }
       }
       else{
           $q = $user::model()->findBySql('SELECT  datePayment FROM table_User WHERE id = :num',array(':num' => $id));
           $result = "<span>Оплачено до:</span> ".Yii::app()->app->formatDate($q['datePayment']);
       }

    return $result;
}

// получить email для входа на сайт
public function emailData($password,$login){
  $user = new User();
  $q = $user::model()->findBySql('SELECT  id, email, phone, status FROM table_User WHERE password = :num AND username = :log',array(':num' => $password,':log' => $login));

  return $q;
}
// достаем id и количество интервалов разрешеных для публикации
public function public_ads_count($password,$login){
    $user = new User();
    $q = $user::model()->findBySql('SELECT  id FROM table_User WHERE password = :num AND username = :log',array(':num' => $password,':log' => $login));

    $q = TableCountAdsPublic::model()->findBySql('SELECT count FROM table_count_ads_public WHERE userId = '.$q['id']);
    return $q['count'];
}

// определение браура
public function browser($browser = 'firefox'){
   $nav = (isset( $_SERVER['HTTP_USER_AGENT'] ) ) ? strtolower( $_SERVER['HTTP_USER_AGENT'] ) : '';
         
   if(stristr($nav, $browser)){
      echo '<link rel="stylesheet" type="text/css" href="/css/realty/firefox.css" />';
   }
}
// определение категории
public function showCat($id){
    $user = new TableCategory();
    $q = $user::model()->findBySql('SELECT name FROM table_category WHERE idCat = :num',array(':num' => $id,));
return $q['name'];
}
// id последнего элемента
public function lastId(){
    $url = trim($_GET['r']);
    $pos = strpos($url, 'create');
    if ($pos !== false) {
        session_start();
        $loadCache = $_SESSION['upload'] = md5(date('Y-m-d H:i:s').rand(0,20));
    }else{
        $loadCache = 0;
    }
return $loadCache;
}
// загрузка фотографий
public function loadImgUpdate($userId,$idTmp){
    $url = $_SERVER['DOCUMENT_ROOT'].'/publish/images/user'.$userId.'/'.$idTmp.'/';
    $arr = $this->get_files($url);

    foreach($arr as $key => $value){
       (preg_match('/_1/', $value)) ? $move = 1 : $move = 0;
       echo '<li id = "'.$userId.'/'.$idTmp.'/'.$value.'" class = "success">';
         echo '<div class = "imgHidden">';
              echo '<div class = "del_img"></div>';
              echo '<div class = "general" move = "'.$move.'"></div>';
              echo '<img src="/publish/images/user'.$userId.'/'.$idTmp.'/'.$value.'">';
         echo '</div>';
       echo '</li>';
    }
}
    // загрузка фотографий в созданные объявления
    public function loadImgUpdateRealty($idTmp){
        $url = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/user/'.$idTmp.'/';
        $arr = $this->get_files($url);

        foreach($arr as $key => $value){
            //(preg_match('/_1/', $value)) ? $move = 1 : $move = 0;
            echo '<li id = "/'.$idTmp.'/'.$value.'" class = "success">';
            echo '<div class = "imgHidden">';
            echo '<div class = "del_img_ads"></div>';
            //echo '<div class = "general" move = "'.$move.'"></div>';
            echo '<img src="/pars/tmp/images/user/'.$idTmp.'/'.$value.'">';
            echo '</div>';
            echo '</li>';
        }
    }
// проверка соществует ли контактные данные
public function cCheck($userId){
    $public = new TablePublicContacts();
    $q = $public::model()->findBySql('SELECT userId FROM table_public_contacts WHERE userId = :num',array(':num' => $userId,));
    ($q) ? $r = 1 : $r =0;
return $r;
}

// выводим контактные данные
public function writeContact($userId)
{
    $public = new TablePublicContacts();
    $q = $public::model()->findBySql('SELECT * FROM table_public_contacts WHERE userId = :num',array(':num' => $userId,));

    $data = array();
    $data['phone'] = $q['phone'];
    $data['email'] = $q['email'];
    $data['name']  = $q['name'];

    //print_r($data);

return $data;
}
// состояния объявления на авито
public function statusBazar($idAds){

    $arr = array();

    $public = new TablePublicBazarpnz();
    $q = $public::model()->findBySql('SELECT deliteLink,datePublic FROM table_public_bazarpnz WHERE idAds = :num',array(':num' => $idAds,));

    if($q['deliteLink']){
        $arr['deliteLink'] = $q['deliteLink'];
        $arr['datePublic'] = $q['datePublic'];
        return $arr;
    }else{
        return 0;
    }
}
// состояния объявления на авито
public function statusAvito($idAds){
     $public = new TablePublicAvito();
     $q = $public::model()->findBySql('SELECT link FROM table_public_avito WHERE idAds = :num',array(':num' => $idAds,));

     if($q['link']){
        return $q['link'];
     }else{
        return 0;
     }
}

//////////////////////////////////////////////////////////
    function lowering($dirname,$dirdestination)
    {
        $arr = $this->get_files($dirname);

        mkdir($dirdestination,0777,true);
        foreach($arr as $key => $value){
            copy($dirname.$value, $dirdestination.$value);
        }
        $this->removeDirRec($dirname);
    }
/////////////////////////////////////////////////////////////
// количесто публикуемых объявления для каждго контакта
public function countUserAds(){

    $contact = new TablePublicContacts();
    $q = $contact::model()->findAllBySql('SELECT id,name FROM table_public_contacts WHERE userId = :num',array(':num' => Yii::app()->user->id,));

    $data = array();

    foreach($q as $key => $value){
        $sql = 'contact_id = '.$value['id'];
        $count = publication::model()->count(array(
            'select'=>'id',
            'condition'=> $sql,
        ));
        $data['contactCount'][$key]['name']  = $value['name'];
        $data['contactCount'][$key]['count'] = $count;
    }
    return $data;
}
    // выбранное время
    public function selectedTime($id){

        $pDt = PublichDayTime::model()->findAll('idAds = '.$id);  // получаем данные крона
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

        foreach($cronData as $k => $value){
            $time = '';
            foreach($timeInterval as $key => $t){
                if($key == $value['hours']){
                    $time = $t;
                }
            }
            $days = '';
            $day = explode(',',$value['days']);
            foreach($week as $key => $d){
                for($i = 0; $i < count($day); $i++){
                    if($key == $day[$i]){
                        $days .= $d.'-';
                    }
                }
            }
            $res[$k] = '<div class = "timeItem-p-days">'.substr($days,0,-1).'</div><div class = "timeItem-p-hours">'.$time.'</div>';
        }
        return $res;

    }
    // функция для проверки вхождения строки
    public function find_in_str($from,$what){
        if (mb_strpos(mb_strtolower($from,'UTF-8'), mb_strtolower($what,'UTF-8'), 0, 'UTF-8')!==false) return true;
        return false;
    }
    // активный контроллер
    public function activeConroller($str_search){
        $render = trim($_GET['r']);
        if($str_search){
           if($this->find_in_str($render,$str_search)){
              return 1;
           }else{
              return 0;
           }
        }

    }
    // получить созданые категории в блокноте
    public function showNotebookCat(){
        $q = NBookCat::model()->findAllBySql('SELECT id,name FROM table_n_book_cat WHERE user = :num',array(':num' => Yii::app()->user->id,));
    return $q;
    }
    // добавленно в блокнот или нет
    public function checkElemNotebook(){
        $arr['notebook'] = array();
        $q = Notebook::model()->findAllBySql('SELECT id,idAds,idCat FROM table_notebook WHERE userId = :num',array(':num' => Yii::app()->user->id,));

        foreach($q as $key => $value){
            $arr['notebook'][$key]['idAds']  = $value['idAds'];
            $arr['notebook'][$key]['idCat']  = $value['idCat'];
        }
    return $arr['notebook'];
    }
    // breadcrumbs блокнот
    public function breadNoteBook($id){
        $q = NBookCat::model()->findBySql('SELECT id,name FROM table_n_book_cat WHERE id = :num',array(':num' => $id,));
        $url = Yii::app()->createUrl('realtyObject/notebook&cat='.$q['id']);
        $r  = "<li><i><img src='/images/breadcrumbs.jpg'></i><a href = '".Yii::app()->createUrl('realtyObject/notebook')."'>Блокнот</a></li>";
        $r .= "<li><i><img src='/images/breadcrumbs.jpg'></i><a href = '".$url."'>".$q['name']."</a></li>";

    return  $r;
    }
    // форматирование телефонных номеров
    function format_phone($phone = '', $convert = false, $trim = true)
    {
        // If we have not entered a phone number just return empty
        if (empty($phone)) {
            return '';
        }

        // Strip out any extra characters that we do not need only keep letters and numbers
        $phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);

        // Do we want to convert phone numbers with letters to their number equivalent?
        // Samples are: 1-800-TERMINIX, 1-800-FLOWERS, 1-800-Petmeds
        if ($convert == true) {
            $replace = array('2'=>array('a','b','c'),
                '3'=>array('d','e','f'),
                '4'=>array('g','h','i'),
                '5'=>array('j','k','l'),
                '6'=>array('m','n','o'),
                '7'=>array('p','q','r','s'),
                '8'=>array('t','u','v'), '9'=>array('w','x','y','z'));

            // Replace each letter with a number
            // Notice this is case insensitive with the str_ireplace instead of str_replace
            foreach($replace as $digit=>$letters) {
                $phone = str_ireplace($letters, $digit, $phone);
            }
        }

        // If we have a number longer than 11 digits cut the string down to only 11
        // This is also only ran if we want to limit only to 11 characters
        if ($trim == true && strlen($phone)>11) {
            $phone = substr($phone,  0, 11);
        }

        // Perform phone number formatting here
        if (strlen($phone) == 7) {
            return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone);
        } elseif (strlen($phone) == 10) {
            return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "($1) $2-$3", $phone);
        } elseif (strlen($phone) == 11) {
            return preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1($2) $3-$4", $phone);
        }

        if(strlen($phone) == 6){
            $add='';
            if (strlen($phone)%2)
            {
                $add = $phone[ 0];
                $add .= (strlen($phone)<=5? "-": "");
                $number = substr($phone, 1, strlen($phone)-1);
            }
            $phone =  $add.implode("-", str_split($phone, 2));
        }

        // Return original phone if not 7, 10 or 11 digits long
        return $phone;
    }

    function pathReturn(){
        $r = $_COOKIE['path'];
        $e = explode(';',$r);

        if(count($e) < 2){ $r .= ';'.$_SERVER['REQUEST_URI']; SetCookie("path",$r);
        }else{
            array_shift($e);
            $str = $e[0]; $str .=';'.$_SERVER['REQUEST_URI'];
            SetCookie("path",$str);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// смена ключа элемента в массиве
    public function change_key($key,$new_key,$arr,$rewrite=true){
        if(!array_key_exists($new_key,$arr) || $rewrite){
            $last = $arr[$new_key];
            $arr[$new_key]=$arr[$key];
            unset($arr[$key]);
            $arr[$key] = $last;
            return $arr;
        }
        return false;
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// поиск и перемещение изображения (выбираем главную картинку)
    public function sFileMove($img){
        foreach ($img as $key => $value) {
            if(preg_match('/_1/', $value)){
                $arr = $this->change_key($key,0,$img);
            }else{
                $arr[$key] = $value;
            }
        }
        return $arr;
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// отправка приглашений друзьям
   public function resolutionInvite(){
         $User = new User;
         $q = $User::model()->findBySql('SELECT countPay FROM table_User WHERE id = :num',array(':num' => Yii::app()->user->id,));
       return $q['countPay'];
   }
   // получаем количество ключей доступа
   public function getBuyCode(){
       $criteria = new CDbCriteria();

       $criteria->order = 'id DESC';

       $criteria->condition = 'user = '.Yii::app()->user->id;

       $count = TableCodesOfPublic::model()->count($criteria);

       return $count;
   }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// предупреждение о оплате платных ключей
    public function payAccessKey(){
        $data = array();
        $q = publication::model()->findAllBySql('SELECT idCat FROM table_publication_object WHERE userId = :num and publich = :publich and (idCat = 9 or idCat = 10)',array(':num' => Yii::app()->user->id,':publich'=> 1));
        if(count($q) > 0){
            $data['countBuyCode'] = $this->getBuyCode();
        }else{
            $data['nonePublic'] = 1;
        }
        return $data;
    }

// количество объявления на определеном номере
   public function countOffers($phone, $id){
       $q = realtyObject::model()->findAllBySql('SELECT id FROM table_object WHERE phone = :num AND id NOT IN(:id)',array(':num' => trim($phone),':id' => $id));
       $count = count($q);
       if($count > 2){
          return 1;
       }else{
          return 2;
       }

   }
   // перевод в транслит
    public function translit($str) {

        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',' ',',','/','.','!','*','$','"','(',')','&#178','«','»','%','²','Â',"\n","\r","\xC2\xA0",':',';','№','>','<',' ','   ','+');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya','_','','','_','','','','','','','','','','','','','','','','','','','','','','','');
        $text = str_replace($rus, $lat, $str);
        return  preg_replace('/\s+/','',$text);

    }

    // плучаем город
    public function getCityPach($id){
          $q = TableCityRegion::model()->findBySql('SELECT name FROM table_city_region WHERE id = :num',array(':num' => trim($id)));
        return $this->translit($q['name']);
    }
    // полчаем категорию
    public function getCatPach($id){
         $q = TableCategory::model()->findBySql('SELECT name FROM table_category WHERE idCat = :num',array(':num' => trim($id)));
        return $this->translit($q['name']);
    }
    public function getH1($id){
        $q = TableCategory::model()->cache(300)->findBySql('SELECT name FROM table_category WHERE idCat = :num',array(':num' => trim($id)));
        return trim($q['name']);
    }
    // получаем описание для метатега description
    public function getDesTitle($id){
        $data = array();

        $q = realtyObject::model()->findBySql('SELECT description, title FROM table_object WHERE id = :num',array(':num' => trim($id)));
          $data['description'] = mb_substr(strip_tags($q['description']),0,500,'utf-8');
          $data['title'] = strip_tags($q['title']);

    return $data;
    }
    // подсчет колличества объявлений в микрорайонахх
    function countEmircodistrict($id){

        $post = new realtyObject;

        $sql = "microdistrict =".$id." AND idCat IN(7,8)";

        $count = $post::model()->cache(5000)->count(array(
            'select'=>'id',
            'condition'=> $sql,
        ));
        return $count;
    }
    function mb_ucfirst($str, $encoding='utf-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }
    public function getMessage($to,$mess,$title){

        $headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: =?utf-8?b?" . base64_encode(''.$title.'') . "?= <admin@rlpnz.ru.ru>\r\n";

        mail($to, ''.$title.'',$mess, $headers);
    }
    // определение назавания категории
    public function getCatPublic($id){
        $cat = new TableNewCategory();
        $cata = $cat::model()->findBySql('SELECT * FROM table_new_category WHERE bid = '.$id);
        return $cata['name'];
    }



}


?>