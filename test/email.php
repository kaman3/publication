<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');

$connection = new Connection();
$mysql = $connection->config();

$deleteArr = $mysql->Select("SELECT * FROM table_public_contacts");

foreach($deleteArr as $key => $value){
    $ObjectAllDell[$key] = $value;
}

foreach ($ObjectAllDell as $key => $value) {
	echo $value[3].'<br>';
}
?>