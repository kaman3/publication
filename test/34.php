<?

include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();


function startTimeout($seconds = 1) {
   if($seconds==0) return;
   $start_time = time();
   while(true) if ((time() - $start_time) >= $seconds) return false;
}


//startTimeout(20);

  if(date('H') == 10){
    $hours = date('H');
  }else{
    $hours = str_replace('0', '', date('H'));
  }
  
  if(date('w') == 0){
     $weekday = 7;
  }else{
     $weekday = date('w');
  }
  

  $array_url = array();

  $option = $mysql->Select('SELECT idAds, hours, days FROM table_publich_day_time WHERE hours = '.$hours);

  foreach ($option as $key => $value) {
      $a = explode(',', $value[2]);
      if(in_array($weekday, $a)){
         $array_url[$key] = $value;
      }  
  }


  $arr = array();

  print_r($array_url);

//$array_time = [10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55];

foreach ($array_url as $key => $value) {

  $user1 = $mysql->Select('SELECT userId FROM table_publication_object WHERE id = '.$value[0]);

  if(isset($user1[0][0])){
     $arr[$key]['user']  = $user1[0][0];
     $arr[$key]['idAds'] = $value[0];
     $arr[$key]['hours'] = $value[1];
     $arr[$key]['days']  = $value[2];

     $username = $mysql->Select('SELECT username FROM table_User WHERE id = '.$user1[0][0]);
     $arr[$key]['username'] =  $username[0][0];

     $arr[$key]['time'][$user1[0][0]] = $array_time;
  }


}

//print_r($arr['time']['79272891848']);

//foreach ($arr as $key => $value) {
  //print_r($value['time'][290]).'<br>';
//}


include_once($_SERVER['DOCUMENT_ROOT'].'/test/cron/Ssh2_crontab_manager.php');

$crontab = new Ssh2_crontab_manager('46.30.42.79', '22', 'root', '629265');

$crontab->remove_crontab();
$i = 0;

foreach ($arr as $key => $value) {

  $time_cron = ''.$value['time'][$value['user']][$key].' '.$value['hours'].' * * '.$value['days'].'';

  $nameUser = str_replace('+','',$value['username']);

  $comand = $value['user'].':'.$value['idAds'].':'.$nameUser;

  //$crontab->append_cronjob(''.$time_cron.'  /usr/bin/curl -s http://publishads.ru/publish/index.php?parametrs='.$comand.' >/dev/null 2>&1');
  //echo $time_cron.'<br>';


 // print_r($value['time'][290]);

}