<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

$phone = $_GET['phone'];
$action = trim($_GET['action']);

$pattern = array('+','(',')',' ','-');
$phone = str_replace($pattern,'',$phone);

if($phone){
   if($action == 1){
   	  
   	  $data['agent'] = 2;
	  $agent['show'] = 1;

      foreach ($phone as $key => $value) {
         if($value){
            $mysql->Update('table_object', $data, 'phone = '.$value);
            $mysql->Update('table_agent_phone', $agent, 'phone = '.$value);
         }     
      }
   
   }elseif($action == 2){
   	   foreach ($phone as $key => $value) {
   	   	  if($value){
             $mysql->Delete('table_agent_phone', 'phone ='.$value);
          }
       }
   }	
}
?>