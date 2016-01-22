<?
 ini_set("display_errors",1);
 error_reporting(E_ALL);

include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных


$connection = new Connection();
$mysql = $connection->config();

$mysql->clearTable('table_ip_public');  

?>