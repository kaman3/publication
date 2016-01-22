<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

$max_id_ip = $mysql->Select('SELECT id FROM table_user_ip WHERE contact_id = 0 and ban = 0');

///$max_id_ip = array();

foreach ($max_id_ip as $key => $value) {
   $max_id[] =  $value[0];
}

//print_r($max_id);

echo $max_id[rand(0,(count($max_id)-1))];

//$random_id_ip = mt_rand(0, $max_id);

//print_r($random_id_ip);

?>