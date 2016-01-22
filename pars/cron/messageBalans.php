<?
 ini_set("display_errors",1);
 error_reporting(E_ALL);

include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных


$connection = new Connection();
$mysql = $connection->config();


$option = $mysql->Select('SELECT email, residPublic  FROM table_User');

foreach ($option as $key => $value) {

     if($value[1] == 0){

     	$headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: =?utf-8?b?" . base64_encode('Закончился баланс') . "?= <admin@rlpnz.ru.ru>\r\n";

        $mess = '
              <p>Уважаемый пользователь сайта http://publishads.ru/. У вас на счету не достаточно средств для дальнейшей публикации объявлений.</p> 
              <p>Для дальнейшей работы, пожалуйста пополните баланс!</p>
        ';

        mail(trim($value[0]), 'Публикация объявлений остановлена',$mess, $headers);
        
     }
  }


  
?>