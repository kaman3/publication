<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

$id = trim($_POST['id']);

if($id){
   $res = $mysql->Delete('table_n_book_cat', 'id = '.$id);
   $resElements = $mysql->Delete('table_notebook', 'idCat = '.$id);
   ($res == true) ? $res = 1 : $res = 0;
    echo $res;
}
?>