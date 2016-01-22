<?
include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/config.php');     // настройки базы данных

$connection = new Connection();
$mysql = $connection->config();

$buyCode = $mysql->Select("SELECT id,code FROM table_codes_of_public WHERE user = 102 AND createDate > (NOW() - interval 30 day)");

$codeID = array();

$codeID = $buyCode[rand(0,count($buyCode)-1)];

if(count($codeID) > 0){
   $tmp['paid_code'] = trim($codeID[1]);
   $tmp['paid_code_id'] = trim($codeID[0]);
}else{
   die('Стоп');
}


print_r($tmp);

//($buyCode);
    /*
       
        if(isset($buyCode)){
           $tmp['paid_code'] = trim($buyCode[0][1]);
           $tmp['paid_code_id'] = trim($buyCode[0][0]);
        }else{
           die('У вас нет возможности размещать объявления в платные разделы');
        }


        print_r($tmp);


?>