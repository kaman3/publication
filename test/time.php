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


startTimeout(10);


  $hours = str_replace('0', '', date('H'));
  $weekday = date('w');


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
  //echo $value[0].'<br>';

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

include_once($_SERVER['DOCUMENT_ROOT'].'/test/cron/Ssh2_crontab_manager.php');

$crontab = new Ssh2_crontab_manager('46.30.42.79', '22', 'root', '89048512165');

$crontab->remove_crontab();

foreach ($arr as $key => $value) {

  $time_cron = ''.rand(10,60).' '.$value['hours'].' * * '.$value['days'].'';

  $nameUser = str_replace('+','',$value['username']);

  $comand = $value['user'].':'.$value['idAds'].':'.$nameUser;

  $crontab->append_cronjob(''.$time_cron.'  /usr/bin/curl -s http://vz67014.eurodir.ru/publish/index.php?parametrs='.$comand.' >/dev/null 2>&1');

}

  $crontab->append_cronjob('*/5 * * * *  /usr/local/ispmgr/sbin/cron.sh sbin/eximquota.check.sh');
  $crontab->append_cronjob('*/5 * * * *  /usr/local/ispmgr/sbin/cron.sh sbin/ihttpd.check.sh');
  $crontab->append_cronjob('10 0 * * *  /usr/local/ispmgr/sbin/cron.sh sbin/mgrctl -m ispmgr task.daily');
  $crontab->append_cronjob('57 2 * * *  /usr/local/ispmgr/sbin/cron.sh sbin/update.sh ispmgr');
  $crontab->append_cronjob('*/30 * * * *  /usr/local/ispmgr/sbin/dbcache');
  $crontab->append_cronjob('1 * * * *  /usr/local/ispmgr/sbin/rotate');
  $crontab->append_cronjob('15 2 * * *  /usr/local/ispmgr/sbin/traffic.pl');


  $crontab->append_cronjob('* */04 * * *  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/1gs.php >/dev/null 2>&1');
  $crontab->append_cronjob('*/30 * * * *  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/avito.php >/dev/null 2>&1');
  $crontab->append_cronjob('*/15 * * * *  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/bazarpnz.php >/dev/null 2>&1');
  $crontab->append_cronjob('* */02 * * *  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/bazarRepeat.php >/dev/null 2>&1');
  $crontab->append_cronjob('@daily  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/deleteAdsOld.php >/dev/null 2>&1');
  $crontab->append_cronjob('@weekly  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/ipr.php >/dev/null 2>&1');
  $crontab->append_cronjob('@daily  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/deleteAdsOld.php >/dev/null 2>&1');
  $crontab->append_cronjob('* */04 * * *  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/kvp.php >/dev/null 2>&1');
  $crontab->append_cronjob('@monthly  /usr/bin/curl -s http://vz67014.eurodir.ru/pars/cron/list_agent.php >/dev/null 2>&1');

  $crontab->append_cronjob('@hourly  /usr/bin/curl -s http://vz67014.eurodir.ru/test/time.php >/dev/null 2>&1');
  $crontab->append_cronjob('*/15 * * * *  /usr/bin/curl -s http://vz67014.eurodir.ru/publish/repeat.php >/dev/null 2>&1');



    

?>