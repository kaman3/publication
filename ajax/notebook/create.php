<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

$name = trim($_POST['name']);
$user = trim($_POST['user']);

$arr = array();

   if($name and $user){
      $dataInsert['user'] = $user;
      $dataInsert['name'] = $name;

      $res = $mysql->Insert('table_n_book_cat', $dataInsert);
      if($res == true){
         $newId = $mysql->Select('SELECT id FROM table_n_book_cat WHERE user = '.$user.' ORDER BY id DESC LIMIT 1');
      }

      if(count($newId) > 0){
         echo $newId[0][0];
      }else{
         echo false;
      }

   }
?>