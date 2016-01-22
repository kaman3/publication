<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

$id    = trim($_POST['id']);
$title = trim($_POST['title']);

if($id){

    $dataUpdate['name']  = $title;
    $res = $mysql->Update('table_n_book_cat', $dataUpdate, 'id = '.$id);

    ($res == true) ? $res = 1 : $res = 0;
    echo $res;
}
?>