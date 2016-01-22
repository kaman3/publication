<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 17.12.14
 * Time: 15:21
 */
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/avito/tmp.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/avito/public.php');

// соединяемся с баззой данных
$connection = new Connection();
$mysql = $connection->config();

// массив объектов для публикации
$ObjectAll = array();
$template = new tmp;
$tmp = array();
$deleteAds = array();
$ObjectAllDell = array();

// начинаем работу публикатора
//$userId = 109;
$userId   = $_POST['userId'];
$login    = $_POST['login'];
$password = $_POST['password'];
$idAds    = $_POST['idAds'];
$phone  = $_POST['phone'];
$email  = $_POST['email'];
$nameDealer = $_POST['nameDealer'];

$deleteArr = $mysql->Select("SELECT * FROM table_public_avito WHERE idAds = ".$idAds." AND public = 1");

foreach($deleteArr as $key => $value){
    $ObjectAllDell[$key] = $value;
}

for($i = 0; $i < count($ObjectAllDell); $i++){
    // смотрим какие объявления уже были размещенны
    $deleteAds[$i]['deliteLink'] =  $ObjectAllDell[$i][4];
    $deleteAds[$i]['id']   =  $ObjectAllDell[$i][1];
}

$array = $mysql->Select("SELECT * FROM table_publication_object WHERE id = ".$idAds." AND userId = ".$userId." AND publich = 1"); //ORDER BY id DESC LIMIT 0,1

foreach($array as $key => $value){
    $ObjectAll[$key] = $value;
}

if(count($ObjectAll) == 0) die('Массив объектов пуст');

// дальше передаем массив объектов для составления шаблонов
for($i = 0; $i < count($ObjectAll); $i++){

    // добавляем параметры для каждой категории
    // квартиры
    if(trim($ObjectAll[$i][2]) >= 7 and trim($ObjectAll[$i][2]) <= 10){
        $tmp[$i] = $template->apartments($ObjectAll[$i]);
    }
    // комнаты
    if(trim($ObjectAll[$i][2]) == 2){
        $tmp[$i] = $template->rooms($ObjectAll[$i]);
    }
    // дома, дачи, коттеджи, таунхаусы
    if(trim($ObjectAll[$i][2]) >= 11 and trim($ObjectAll[$i][2] <=14)){
        $tmp[$i] = $template->hCottadge($ObjectAll[$i]);
    }
    // земельные участки
    if(trim($ObjectAll[$i][2]) >= 15 and trim($ObjectAll[$i][2] <=17)){
        $tmp[$i] = $template->land($ObjectAll[$i]);
    }
    // комерческая недвижимость
    if(trim($ObjectAll[$i][2]) >= 18 and trim($ObjectAll[$i][2] <=22)){
        $tmp[$i] = $template->commercial($ObjectAll[$i]);
    }
    // гараж
    if(trim($ObjectAll[$i][2]) == 23){
        $tmp[$i] = $template->garage($ObjectAll[$i]);
    }

/////////////////////////////////////////////////// общие поля формы ///////////////////////

    if(isset($ObjectAll[$i][9])){
        $tmp[$i]['description'] = trim($ObjectAll[$i][9]);
    }
///////////////////////////////////////// описание End ////////////////////////////////////

///////////////////////////////////////// цена ////////////////////////////////////
    if(isset($ObjectAll[$i][22])){
        $tmp[$i]['price'] = trim($ObjectAll[$i][22]);
    }
///////////////////////////////////////// цена end ////////////////////////////////////

///////////////////////////////////////// регион ////////////////////////////////////
    if(isset($ObjectAll[$i][3])){
        $tmp[$i]['region_id'] = '643250';  // пензенская область
    }
///////////////////////////////////////// регион end ////////////////////////////////////

///////////////////////////////////////// Город ////////////////////////////////////
    if(isset($ObjectAll[$i][4])){

        $arrCity = array(
            1 => '643260', // башмаково
            2 => '643560', // пенза
            3 => '643290', // белинский
            4 => '643300', // бессоновка
            5 => '643320', // вадинск
            6 => '643340', // городище
            7 => '643390', // земетченно
            8 => '643410', // исса
            9 => '643420', // каменка
            10 => '643600',// русский камешкир
            11 => '643430',// камешкир
            12 => '643450',// кузнетск
            13 => '643460',// лопатино
            14 => '643470',// лунино
            15 => '643480',// малая сердоба
            16 => '643500',// мокшан
            17 => '643510',// наровчат
            18 => '643520',// неверкино
            19 => '643530',// нижний ломов
            20 => '643540',// никольск
            21 => '643550',// пачелма
            22 => '643440',// кондоль
            23 => '643610',// сердобск
            24 => '643620',// сосоновоборск
            25 => '643270',// спасск
            26 => '643660',// тамала
            27 => '643690',// шемышейка
            28 => '643280',// беково
            29 => '643370',// заречный
            30 => '',
            31 => '643350',// грабово
            32 => '',
            33 => '',
            34 => '',
            35 => '',
            36 => '643680',// чемодановка
            37 => '',
            38 => '',
            39 => '',
            40 => '',
            41 => '643310',// богословка
            42 => '',
            43 => '',
            44 => '',
            45 => '',
            46 => '',
            47 => '',
            48 => '',
        );
        for($f = 1; $f < count($arrCity); $f++){
            if($ObjectAll[$i][4] == $f){
                $tmp[$i]['location_id'] = $arrCity[$f];
                break;
            }
        }
    }
///////////////////////////////////////// Город end////////////////////////////////////

///////////////////////////////////////// район ////////////////////////////////////
    if($tmp[$i]['location_id'] == 643560){ // если пенза

        if(isset($ObjectAll[$i][5])){
            $arrDistrict = array(
                1 => '192',
                2 => '193',
                3 => '194',
                4 => '195',
            );
            for($f = 1; $f < count($arrDistrict); $f++){
                if($ObjectAll[$i][5] == $f){
                    $tmp[$i]['district_id'] = $arrDistrict[$f];
                    break;
                }
            }
        }

    }
///////////////////////////////////////// район end////////////////////////////////////

///////////////////////////////////////// ваше имя ////////////////////////////////////
    if(isset($ObjectAll[$i][18])){
        $tmp[$i]['manager'] = $nameDealer;
    }
///////////////////////////////////////// ваше имя end////////////////////////////////////

///////////////////////////////////////// номер телефона ////////////////////////////////////
    if(isset($ObjectAll[$i][16])){
        $tmp[$i]['phone'] = $phone;
    }
///////////////////////////////////////// номер телефона end ////////////////////////////////////

    // изображения
    $tmp[$i]['image'] = 'image';
    // капча
    $tmp[$i]['captcha'] = '';
    // направление
    $tmp[$i]['road_id'] = '';

    $tmp[$i]['seller_name'] = $nameDealer;
    $tmp[$i]['metro_id'] = '';
    $tmp[$i]['title'] = $ObjectAll[$i][7];
    $tmp[$i]['allow_mails'] = '0';
    $tmp[$i]['id'] = $ObjectAll[$i][0];
    $tmp[$i]['userId'] = $userId;

}
// конец формирования шаблона для отправки на сайт


$r = new public_avito($login,$password);

// удаляем опубликованные объявления
if(count($deleteAds) > 0){
   $r->deleteAds($deleteAds);
}
// запускаем публикатор
$r->main($tmp);

print_r($tmp);
?>






