<?
include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();


function startTimeout($seconds = 1) {
   if($seconds==0) return;
   $start_time = time();
   while(true) if ((time() - $start_time) >= $seconds) return false;
}


//startTimeout(20);


  //$hours = str_replace('0', '', date('H'));
  //$weekday = date('w');

  $hours = 10;
  $weekday = 3;

  $array_url = array();

  $option = $mysql->Select('SELECT idAds, hours, days FROM table_publich_day_time WHERE hours = '.$hours);

  foreach ($option as $key => $value) {
  	  $a = explode(',', $value[2]);
  	  if(in_array($weekday, $a)){
  	  	 $array_url[$key] = $value;
  	  }  
  }


  $arr = array();

foreach ($array_url as $key => $value) {

  $user1 = $mysql->Select('SELECT userId FROM table_publication_object WHERE id = '.$value[0]);

  if($user1[0][0]){
     $arr[$key]['user']  = $user1[0][0];
     $arr[$key]['idAds'] = $value[0];
     $arr[$key]['hours'] = $value[1];
     $arr[$key]['days']  = $value[2];

     $username = $mysql->Select('SELECT username FROM table_User WHERE id = '.$user1[0][0]);
     $arr[$key]['username'] =  $username[0][0];
  }


}
print_r($arr);

/*
include_once($_SERVER['DOCUMENT_ROOT'].'/test/cron/Ssh2_crontab_manager.php');

$crontab = new Ssh2_crontab_manager('46.30.42.79', '22', 'root', '89048512165');

$crontab->remove_crontab();

foreach ($arr as $key => $value) {

  $time_cron = ''.rand(10,55).' '.$value['hours'].' * * '.$value['days'].'';

  $nameUser = str_replace('+','',$value['username']);

  $comand = $value['user'].':'.$value['idAds'].':'.$nameUser;

  $crontab->append_cronjob(''.$time_cron.'  /usr/bin/curl -s http://vz67014.eurodir.ru/publish/index.php?parametrs='.$comand.' >/dev/null 2>&1');

}




?>