<?
include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

$array_url = array();

$option = $mysql->Select('SELECT * FROM table_error_pars WHERE parser_id = 10');

foreach ($option as $key => $value) {
    $array_url[$key]['id']        = $value[0];
    $array_url[$key]['url']       = $value[1];
    $array_url[$key]['parser_id'] = $value[2];
}

$url = array();

foreach($array_url as $key => $value){
    if($value['parser_id'] == 10){
        $url[] = str_replace('http://www.avito.ru','',$value['url']);
        $mysql->Delete('table_error_pars', 'id = '.$value['id']);
    }
}
//print_r($url);

if(count($url) > 0){
    $_POST['sp'] = 0;
    $_POST['timeout'] = 5;
    $_POST['countPage'] = 0;
    $_POST['uploadImages'] = 1;
    $_POST['saveDb'] = 1;
    $_POST['city'] = 2;
    $_POST['repeat_object'] = $url;
    $_POST['repeat_error'] = 1;
    include_once($_SERVER['DOCUMENT_ROOT'].'/pars/parametrs.php');
}else{
    die('Нет ошибок');
}
