<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/application.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cron/smsaero.php');

ini_set('display_errors', 1);

// соединяемся с баззой данных
$connection = new Connection();
$mysql = $connection->config();

$app = new app();

// число повторений, (набираем набор из 5 елементов)
//$repeat = 5;

$data = array();

$array = $mysql->Select("SELECT * FROM table_not_published");

$countAds = count($array);
 
 if($countAds > 20){
 	// если неопубликованых объявлений больше 10 отправляем сообщение
    $app->getMessage('aligoweb@ya.ru','Дела труба слишком много не опубликованых объявлений');

    $body=file_get_contents("http://sms.ru/sms/send?api_id=be6a15b0-7cf4-0074-d5cb-2e7b88c14a99&to=79374376600&text=Много_не_опубликованых");
    // останавливаем публикацию для всех объявлений
    $dataUpdate['count'] = 20;
    $mysql->Update('table_option_not_publish',$dataUpdate, "id = 1");

    die('Стоп');


 }else{
 
    foreach ($array as $key => $value) {
    	
	     $link = 'http://publishads.ru/publish/index.php?parametrs='.$value[1].':'.$value[2];

         if($link){
              // удаляем перед публикацией
         	  $mysql->Delete('table_not_published', "idAds = ".$value[2]);

		      $ch = curl_init($link);
	          curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");
	          curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
	          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
	          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	          curl_setopt($ch, CURLOPT_VERBOSE, 1);
	          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

	          $result2 = curl_exec($ch);

	          //echo iconv('windows-1251','utf-8',$result2);

	          sleep(30);

        }

    }

}


    


?>