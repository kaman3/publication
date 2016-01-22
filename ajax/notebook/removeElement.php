<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

$id = trim($_POST['id']);
$cat = trim($_POST['cat']);

if($id){
    if($cat){
       $resElements = $mysql->Delete('table_notebook', 'idAds = '.$id.' and idCat = '.$cat);
    }else{
       $resElements = $mysql->Delete('table_notebook', 'idAds = '.$id);
    }

    ($resElements == true) ? $res = 1 : $res = 0;
    echo $resElements;
}
?>