<?

include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');

ini_set('display_errors', 1);

// соединяемся с баззой данных
$connection = new Connection();
$mysql = $connection->config();

$d = $mysql->Select("SELECT dateTime FROM table_object WHERE id = 316125");



$raz = time()-strtotime($d[0][0]);
echo $raz;

header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', time()-$raz+10800));

//strtotime(date("Y-m-d"));

?>