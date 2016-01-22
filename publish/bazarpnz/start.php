<?
ini_set('max_execution_time', 1200);
echo ini_get('max_execution_time'); // 100
set_time_limit(1200);



include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/bazarpnz/public.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/application.php');

//die('Стоп');
// соединяемся с баззой данных
$connection = new Connection();
$mysql = $connection->config();

// если произолша ошибка останавливаем все публикацию
$stop = $mysql->Select("SELECT count FROM table_option_not_publish WHERE id = 1");

if($stop[0][0] == 20){
   die('Стоп');
}


// начинаем работу публикатора
$userId = trim($_POST['userId']);
$idAds  = $_POST['idAds'];
$phone  = $_POST['phone'];
$email  = $_POST['email'];
$nameDealer = $_POST['nameDealer'];
$showContact = $_POST['show'];
$randIp = $_POST['randIp'];

//$userId = 2;
// массив объектов для публикации
$ObjectAll     = array();
$ObjectAllDell = array();
$tmp           = array();
$deleteAds     = array();

$public_bazarpnz = new public_bazarpnz;

// объекты для удаления
$deleteArr = $mysql->Select("SELECT * FROM table_public_bazarpnz WHERE idAds = ".$idAds." AND public = 1");

foreach($deleteArr as $key => $value){
    $ObjectAllDell[$key] = $value;
}

for($i = 0; $i < count($ObjectAllDell); $i++){
    // смотрим какие объявления уже были размещенны
    $deleteAds[$i]['linkAds'] =  $ObjectAllDell[$i][3];
    $deleteAds[$i]['link'] =  $ObjectAllDell[$i][4];
    $deleteAds[$i]['id']   =  $ObjectAllDell[$i][1];
}
//print_r($deleteAds);

// объекты для публикации
$array = $mysql->Select("SELECT * FROM table_publication_object WHERE id = ".$idAds." AND userId = ".$userId." AND publich = 1"); //ORDER BY id DESC LIMIT 0,1

foreach($array as $key => $value){
    $ObjectAll[$key] = $value;
}
//print_r($ObjectAll);

if(count($ObjectAll) == 0) die('Массив объектов пуст');

for($i = 0; $i < count($ObjectAll); $i++){

   // print_r($ObjectAll[$i][10]);
    // поля по умолчанию
    $tmp[$i]['id']      = $ObjectAll[$i][0];     // id объявления
    $tmp[$i]['userId']  = trim($userId);         // id пользователя
    $tmp[$i]['contact_id'] = $ObjectAll[$i][25]; // contact_id
    $tmp[$i]['addtype'] = 'main';
    $tmp[$i]['curr']    = '1';                     //  валюта
    $tmp[$i]['rub']     = '247';                   //  категория  (главная) по умолчанию Недвижимость
    $tmp[$i]['rights']  = '1';                     //  согласимся с условиями публикации
    $tmp[$i]['icq']     = '';
    $tmp[$i]['skype']   = '';

    $arrPeriod = array(0 => '5',1 => '6',2 => '1');
    $tmp[$i]['period']  = '5'; //$arrPeriod[rand(0,count($arrPeriod)-1)]; // публикуем на месяц

    $tmp[$i]['userls']  = '';
    $tmp[$i]['subm']    = mb_convert_encoding('Отправить', "windows-1251", "utf-8");
    $tmp[$i]['key']     = '';
    $tmp[$i]['comm']    = '0';

    // поля из базы данных

    if($showContact == 1){
       $tmp[$i]['email'] = $email;
       $tmp[$i]['name']  = mb_convert_encoding($nameDealer, "windows-1251", "utf-8");
    }else{
       $tmp[$i]['email'] = '';
       $tmp[$i]['name']  = '';
    }

     // телефон
     $pattern = array('+','-',')','(',' ',':',',');
     
     $ClearPhone = str_replace($pattern, '', $phone);

     //echo strlen($ClearPhone);
     /*
     if(strlen($ClearPhone) == 11){
        $p = substr($ClearPhone, 1);
        $end = '+7'.$p;
     }else if(strlen($ClearPhone) == 10){
        $end = '+7'.$ClearPhone;
     }else if(strlen($ClearPhone) == 6){
       $end = '+78412'.$ClearPhone;
     }
     */
     if(strlen($ClearPhone) == 11){
       // код
       $rest_1 = substr($ClearPhone, 1, 3);
       // первая часть номера
       $rest_2 = substr($ClearPhone, 4, 3);
       // вторая часть номера
       $rest_3 = substr($ClearPhone, 7, 2);
       // третья часть номера
       $rest_4 = substr($ClearPhone, 9, 2);

       // собираем номер
       $end = '+7'.' ('.$rest_1.') '.$rest_2.'-'.$rest_3.'-'.$rest_4;
    }elseif(strlen($ClearPhone) == 6){
       $rest_1 = substr($ClearPhone, 0, 2);
       $rest_2 = substr($ClearPhone, 2, 2);
       $rest_3 = substr($ClearPhone, 4, 2);


       $end = '+7 (8412) '.$rest_1.'-'.$rest_2.'-'.$rest_3;
    }else{
       $public_bazarpnz->getMessage('serega569256@bk.ru','Номер не правильный');
       die();
    }
    //$tmp[$i]['phone'] = 
    $tmp[$i]['phones_set[]'] = $end;
    
    //$tmp[$i]['phones_set[]'] = $phone;
    $tmp[$i]['title'] = mb_convert_encoding($ObjectAll[$i][7], "windows-1251", "utf-8");
    $tmp[$i]['text']  = mb_convert_encoding($public_bazarpnz->gap_paste($ObjectAll[$i][9]), "windows-1251", "utf-8");
    $tmp[$i]['price'] = $ObjectAll[$i][22];

    // район города
    if($ObjectAll[$i][6]){
        $microdistrict = array(
            1 => '1',
            2 => '7',
            3 => '8',
            4 => '11',
            5 => '65',
            6 => '21',
            7 => '23',
            8 => '37',
            9 => '24',
            10 => '20',
            11 => '25',
            12 => '46',
            13 => '39',
            14 => '34',
            15 => '30',
            16 => '2',
            17 => '9',
            18 => '4',
            19 => '41',
            20 => '63',
            21 => '40',
            22 => '53',
            23 => '33',
            24 => '12',
            25 => '27',
            26 => '5',
            27 => '50',
            28 => '58',
            29 => '59',
            30 => '55',
            31 => '56',
            32 => '13',
            33 => '19',
            34 => '38',
            35 => '67',
            36 => '67',
            37 => '31',
            38 => '32',
            39 => '64',
            40 => '36',
            41 => '54',
            42 => '29',
            43 => '10',
            44 => '66',
            45 => '45',
            46 => '18',
            47 => '61',
            48 => '51',
            49 => '60',
            50 => '40',
            51 => '42',
            52 => '3',
            53 => '6',
            54 => '16',
            55 => '17',
            56 => '35',
            57 => '15',
            58 => '26',
            59 => '48',
        );
        for($f = 1; $f < count($microdistrict); $f++){
            if($ObjectAll[$i][6] == $f){
                $tmp[$i]['rn'] = $microdistrict[$f];
                break;
            }
        }
    }else{
        $tmp[$i]['rn'] = 0;
    }
    //$tmp[$i]['rn'] = $mDistrict;
    ////////////// микрорайон конец //////////////////////////////////////////////////////////////

    $tmp[$i]['rub_select'] = trim($ObjectAll[$i][2]);
    // тип Сделки
    if(isset($ObjectAll[$i][10])){
        // состояние
        $cond = '';
	    // сдам
	    if($ObjectAll[$i][10] == 1){
	       $typ = 3;
	    }
	    // продам
	    else if($ObjectAll[$i][10] == 2){
	       $typ = 1;
           $cond = 2;
	    }
	    // куплю
	    else if($ObjectAll[$i][10] == 3){
	       $typ = 2;
	    }
	    // сниму
	    else if($ObjectAll[$i][10] == 4){
	       $typ = 4;
	    }
        else if($ObjectAll[$i][10] == 5){
            $typ = 4;
        }
        else if($ObjectAll[$i][10] == 6){
            $typ = 6;
        }
        else if($ObjectAll[$i][10] == 6){
            $typ = 7;
        }
	    $tmp[$i]['typ'] = $typ; 
        // состояние
        if($cond){
           $tmp[$i]['cond'] = 2;
        }
    }

    // количество комнат
    if(isset($ObjectAll[$i][15])){

	     if($ObjectAll[$i][15] == 1){
	       $tmp[$i]['rooms'] = 1;       // С общей кухней
	    } 
	    else if($ObjectAll[$i][15] == 2){
	       $tmp[$i]['rooms'] = 2;       // Студия
	    }
	    else if($ObjectAll[$i][15] == 3){
	       $tmp[$i]['rooms'] = 3;       // 1 комната
	    }  
	    else if($ObjectAll[$i][15] == 4){
	       $tmp[$i]['rooms'] = 4;       // 2 комнаты
	    }
        else if($ObjectAll[$i][15] == 5){
            $tmp[$i]['rooms'] = 5;      // 3 комнаты
        }
        else if($ObjectAll[$i][15] > 5){
            $tmp[$i]['rooms'] = 6;      // 4 и более
        }
    }else{
        $tmp[$i]['rooms'] = '';
    }
	// общая площадь
	if(isset($ObjectAll[$i][11])){
	   $tmp[$i]['main_size'] = $ObjectAll[$i][11];
	}else{
       $tmp[$i]['main_size'] = '';
    }
    // если существует ссылка на удаление, то при удачной публикации удаляем старое объявление иначе оставляем его
    if(isset($deleteAds[0]['link'])){
       $tmp[$i]['link_del'] = $deleteAds[0]['link'];
       $tmp[$i]['link_ads'] = $deleteAds[0]['linkAds'];
    }

    // если это категории относящиеся к аренде добавляем код для платной публикации
    if($ObjectAll[$i][2] == 9 or $ObjectAll[$i][2] == 10){
        $buyCode = $mysql->Select("SELECT id,code FROM table_codes_of_public WHERE user = ".trim($userId)." AND createDate > (NOW() - interval 30 day)");

        $codeID = array();
        $codeID = $buyCode[rand(0,count($buyCode)-1)];


        if(count($codeID) > 0){
            $tmp[$i]['paid_code'] = trim($codeID[1]);
            $tmp[$i]['paid_code_id'] = trim($codeID[0]);
        }else{
            die('Стоп');
        }
    }
}

// подбираем ip
$app = new app();


//$public_bazarpnz->create_and_load_user(33);

//print_r($ar);


$public_bazarpnz->main($tmp,$randIp);
unset($tmp);

?>