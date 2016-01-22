<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

$id = trim($_GET['id']);
$action = trim($_GET['action']);
$phone = trim($_GET['phone']);

$pattern = array('+','(',')',' ','-');
$phone = str_replace($pattern,'',$phone);

if($phone){   
	if($action == 1){
	   $data['agent'] = 2;
	   $agent['show'] = 1;

       $mysql->Update('table_object', $data, 'phone = '.$phone);
       $mysql->Update('table_agent_phone', $agent, 'phone = '.$phone);
	
	}elseif($action == 2){
       $mysql->Delete('table_agent_phone', 'phone ='.$phone);
	}
}
?>