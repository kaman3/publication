<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');

ini_set('display_errors', 1);

// соединяемся с баззой данных
$connection = new Connection();
$mysql = $connection->config();

// получаем входные переменные от крона
$parametrs = trim($_GET['parametrs']);
//$idAds  = trim($_GET['Ads']);

$arr = explode(':', $parametrs);

$userId = $arr[0];
$idAds  = $arr[1];

$arrContact_id = $mysql->Select("SELECT contact_id FROM table_publication_object WHERE id = ".trim($idAds));
$contact_id = $arrContact_id[0][0];

$data = $mysql->Select("SELECT * FROM table_public_contacts WHERE userId = ".trim($userId)." AND id = ".$contact_id);
$arr = $data[0]; // сложили в один массив

$residArr = $mysql->Select("SELECT residPublic FROM table_User WHERE id = ".trim($userId)."");
$residue = $residArr[0][0];

if($residue > 0){
//print_r($arr);
// для базар пнз
/*
if(isset($arr[2]) and isset($arr[3]))
{
    // проверяем есть имя и телефон
    $_POST['userId'] = $userId;
    $_POST['idAds'] = $idAds;  // публикуемое объявление

    $_POST['phone'] = $arr[3];
    $_POST['email'] = $arr[4];
    $_POST['nameDealer'] = $arr[2];

    $_POST['show'] = $arr[8];

    include_once($_SERVER['DOCUMENT_ROOT'].'/publish/bazarpnz/start.php');
}

*/
// подключаем авито
if(isset($arr[2]) and isset($arr[4]) and isset($arr[3]) and isset($arr[7]))  // email phone password
{
    $_POST['userId'] = $userId;     // user
    $_POST['login']  = 'serzh_krasnov_1997@mail.ru';     // logon
    $_POST['password']  = 's89048512165';  // password
    $_POST['idAds'] = $idAds;      // публикуемое объявление

    $_POST['phone'] = '89379138688';
    $_POST['email'] = 'serzh_krasnov_1997@mail.ru';
    $_POST['nameDealer'] = 'Сергей';

    include_once($_SERVER['DOCUMENT_ROOT'].'/publish/avito/start.php');
}

}

/*
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/avito/public.php');

$p = new public_avito('serzh_krasnov_1997@mail.ru','s89048512165');

$p->get_capcha();


?>