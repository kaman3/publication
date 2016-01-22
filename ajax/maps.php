<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

$d = $mysql->Select('SELECT id,coordinaty FROM table_object WHERE coordinaty != 0');
 foreach ($d as $key => $value){
    $setup['maps'][$key] = $value;
 }

 echo json_encode($setup['maps']);

?>