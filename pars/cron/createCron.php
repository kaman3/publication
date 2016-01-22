<?
 ini_set("display_errors",1);
 error_reporting(E_ALL);

include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных


$connection = new Connection();
$mysql = $connection->config();

function startTimeout($seconds = 1) {
   if($seconds==0) return;
   $start_time = time();
   while(true) if ((time() - $start_time) >= $seconds) return false;
}

function randNumber($min = 1,$all = 1000){
  //$min= 1; // начало диапазона
  $max = 1000; // конец диапазона
  //$all = 1000; // количество уникальных чисел, которые нужно получить
   
  $array = range($min, $max);

  $data = array();
   
  $nums = array_rand($array, $all);
  shuffle($nums);
   
  foreach($nums as $num) {
    $data[] = $array[$num];
  }
return $data;
}


startTimeout(20);



  if(date('H') == 10 or date('H') == 20){
    $hours = date('H');
  }else{
    $hours = str_replace('0', '', date('H'));
  }

  //$hours = '18';
  
  if(date('w') == 0){
     $weekday = 7;
  }else{
     $weekday = date('w');
  }
/*
  // меняем сортировку каждый день
  if (date('j')%2 == 0){
      $sort = 'ORDER by id ASC';
  }else{
      $sort = 'ORDER by id DESC';
  }
*/
  $array_url = array();

  $option = $mysql->Select('SELECT idAds, hours, days FROM table_publich_day_time WHERE hours = '.$hours);

  foreach ($option as $key => $value) {
      $a = explode(',', $value[2]);
      if(in_array($weekday, $a)){
         $array_url[$key] = $value;
      }  
  }


  $arr = array();
  $time_plus = 10;

  //print_r($array_url);

foreach ($array_url as $key => $value) {

  $user1 = $mysql->Select('SELECT userId, contact_id FROM table_publication_object WHERE id = '.$value[0].' and publich = 1');//and userId = 356

  if(isset($user1[0][0])){
     $arr[$key]['user']  = $user1[0][0];
     $arr[$key]['idAds'] = $value[0];
     $arr[$key]['hours'] = $value[1];
     $arr[$key]['days']  = $value[2];

     $username = $mysql->Select('SELECT username FROM table_User WHERE id = '.$user1[0][0]);
     $arr[$key]['username'] =  $username[0][0];
 
     // номер телефона
     $phone = $mysql->Select('SELECT phone FROM table_public_contacts WHERE id = '.$user1[0][1]);

         $pattern = array('+',')','(',' ','-');
         $phone_number = str_replace($pattern, '', $phone[0][0]);
         $arr[$key]['phone'] = $phone_number;
         //echo $user1[0][1].'<br>';
    
     $arr[$key]['time'] = $time_plus++;
  }


}

//print_r($user1);

$number = array();

foreach ($arr as $key => $value) {
  $number[] =  $value['phone'];
}

$rs = array_unique($number);


//shuffle($rs);

//$randomQueue = randNumber(1,count($arr));
$n = 0;
$mas = array();

foreach ($rs as $key => $value) {
  
  foreach ($arr as $key2 => $value2) {
    
    if($value == $value2['phone']){
           
       $time_cron = $value2['hours'].' * * '.$value2['days'].'';

       $comand = $value2['user'].':'.$value2['idAds'].':'.$value2['phone'];
       
       $mas[$value2['phone']]['comand'][] = $time_cron.'  /usr/bin/curl -s http://publishads.ru/publish/index.php?parametrs='.$comand.' >/dev/null 2>&1';
       $mas[$value2['phone']]['idAds'][]  = $value2['idAds'];
       
         
       $n++;
    }
  }
}

include_once($_SERVER['DOCUMENT_ROOT'].'/test/cron/Ssh2_crontab_manager.php');

$crontab = new Ssh2_crontab_manager('46.30.42.79', '22', 'root', '629265');

$crontab->remove_crontab();

// увеличиваем время на час
$hours = array();

if(date('H') == 10 or date('H') == 20){
  $hours_interval = date('H');
}else{
  $hours_interval = str_replace('0', '', date('H'));
}

$t_base = $hours_interval;


$hours['hours'] = $hours_interval+2;

foreach ($mas as $key => $value) {
   $mesh = rand(2, 10);  
   if($mesh%2 == 0){
     $value['comand'] = array_reverse($value['comand']);
   }

    // считаем количество элементов в массиве, выставляем разные временные интервалы 
    $countAds = count($value['comand']);

    if($countAds >= 20 or $countAds >= 15){  //if($countAds >= 20 or $countAds >= 15){
     
       $b = 2;
       $c = 3;
       
       //$b = $c = rand(3,6);
    }
    else if($countAds <= 14 and $countAds >= 12){
       $b = $c = 4;
       //$b = $c = rand(3,6);
    }
    else if($countAds <= 11 and $countAds >= 8){
       $b = $c = rand(3,6);
    }
    else if($countAds == 7 or $countAds == 6){
       $b = $c = 8; 
    }else if($countAds == 5 or $countAds == 4){
       $b = $c = 10; 
    }else if($countAds == 3){
       $b = $c = 15;
    }else if($countAds == 2){
       $b = $c = 23;
    }else if($countAds == 1){
       $b = $c = rand(10,50);
    }
    

   for ($i=0; $i < count($value['comand']); $i++) { 
         echo $b.'<br>';
        if($b < 60){     
           $crontab->append_cronjob(''.trim($b).' '.trim($value['comand'][$i]).''); 
        }else{
           $mysql->Update('table_publich_day_time', $hours, 'idAds = '.$value['idAds'][$i].' and hours = '.$t_base);
        }
    
        $b = $b + $c;

   }

}

  // системные 
  $crontab->append_cronjob('*/5 * * * *  /usr/local/ispmgr/sbin/cron.sh sbin/eximquota.check.sh');
  $crontab->append_cronjob('*/5 * * * *  /usr/local/ispmgr/sbin/cron.sh sbin/ihttpd.check.sh');
  $crontab->append_cronjob('10 0 * * *  /usr/local/ispmgr/sbin/cron.sh sbin/mgrctl -m ispmgr task.daily');
  $crontab->append_cronjob('57 2 * * *  /usr/local/ispmgr/sbin/cron.sh sbin/update.sh ispmgr');
  $crontab->append_cronjob('*/30 * * * *  /usr/local/ispmgr/sbin/dbcache');
  $crontab->append_cronjob('1 * * * *  /usr/local/ispmgr/sbin/rotate');
  $crontab->append_cronjob('15 2 * * *  /usr/local/ispmgr/sbin/traffic.pl');

  // парсеры
  $crontab->append_cronjob('* */04 * * *  /usr/bin/curl -s http://rlpnz.ru/pars/cron/1gs.php >/dev/null 2>&1');
  $crontab->append_cronjob('*/20 * * * *  /usr/bin/curl -s http://rlpnz.ru/pars/cron/avito.php >/dev/null 2>&1');
  $crontab->append_cronjob('*/15 * * * *  /usr/bin/curl -s http://rlpnz.ru/pars/cron/bazarpnz.php >/dev/null 2>&1');
  //$crontab->append_cronjob('*/45 * * * *  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/emulant.php >/dev/null 2>&1');
  $crontab->append_cronjob('* */02 * * *  /usr/bin/curl -s http://rlpnz.ru/pars/cron/bazarRepeat.php >/dev/null 2>&1');
  $crontab->append_cronjob('* */02 * * *  /usr/bin/curl -s http://rlpnz.ru/pars/cron/avitoRepeat.php >/dev/null 2>&1');
  $crontab->append_cronjob('@daily  /usr/bin/curl -s http://rlpnz.ru/pars/cron/deleteAdsOld.php >/dev/null 2>&1');
  $crontab->append_cronjob('@daily  /usr/bin/curl -s http://rlpnz.ru/index.php?r=realtyObject/sitemap >/dev/null 2>&1');
  $crontab->append_cronjob('* */04 * * *  /usr/bin/curl -s http://rlpnz.ru/index.php?r=realtyObject/yml >/dev/null 2>&1');
  $crontab->append_cronjob('* */04 * * *  /usr/bin/curl -s http://rlpnz.ru/index.php?r=realtyObject/CreateRss >/dev/null 2>&1');
  $crontab->append_cronjob('@weekly  /usr/bin/curl -s http://rlpnz.ru/pars/cron/ipr.php >/dev/null 2>&1');
  $crontab->append_cronjob('* */04 * * *  /usr/bin/curl -s http://rlpnz.ru/pars/cron/kvp.php >/dev/null 2>&1');
  //$crontab->append_cronjob('* */02 * * *  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/irr.php >/dev/null 2>&1');
  $crontab->append_cronjob('@monthly  /usr/bin/curl -s http://rlpnz.ru/pars/cron/list_agent.php >/dev/null 2>&1');

  $crontab->append_cronjob('@hourly  /usr/bin/curl -s http://publishads.ru/pars/cron/createCron.php >/dev/null 2>&1');
  // проверяем есть ли не опубликованные объявления
  //$crontab->append_cronjob('*/19 * * * *  /usr/bin/curl -s http://publishads.ru/publish/publish_not_publish.php >/dev/null 2>&1');

  //$crontab->append_cronjob('*/15 * * * *  /usr/bin/curl -s http://publishads.ru/publish/repeat.php >/dev/null 2>&1');

  $crontab->append_cronjob('@weekly  /usr/bin/curl -s http://publishads.ru/pars/cron/messageBalans.php >/dev/null 2>&1');
  //$crontab->append_cronjob('@hourly  /usr/bin/curl -s http://publishads.ru/pars/cron/truncate_ip_table.php >/dev/null 2>&1');
?>