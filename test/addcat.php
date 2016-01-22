<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');

ini_set('display_errors', 1);

// соединяемся с баззой данных
$connection = new Connection();
$mysql = $connection->config();


if($_POST['name']){

	$data['parent'] = $_POST['parent'];
	$data['bid'] = $_POST['bid'];
	$data['name'] = $_POST['name'];

    $mysql->Insert('table_new_category', $data);

}


?>

<form action = '' method = 'POST'>
      <input type = 'text' name = 'parent' value = '511'></br>
      <input type = 'text' name = 'bid' value = ''></br>
      <input type = 'text' name = 'name'></br>
      <input type = 'submit' value = 'сохранить'>
</form>