<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();


    $pattern = array('+','(',')',' ','-');
    $phone = str_replace($pattern,'',trim($_GET['phone']));

// это для таблицы агентов
	$agentArr['phone'] = $phone;
	$agentArr['show'] = 0;
	$agentArr['objectid'] = trim($_GET['objectid']);



	$d = array_shift($mysql->Select('SELECT phone FROM table_agent_phone WHERE phone = '.$agentArr['phone']));

	if(!$d){
	   $mysql->Insert('table_agent_phone', $agentArr);
	}  

	

?>