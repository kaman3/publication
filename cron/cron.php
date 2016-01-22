<?php
include($_SERVER['DOCUMENT_ROOT'].'/test/cron/Ssh2_crontab_manager.php');
ini_set("display_errors",1);
//error_reporting(E_ALL);
// Установка соединения

$crontab = new Ssh2_crontab_manager('46.30.42.79', '22', 'root', '89048512165');
//$crontab->append_cronjob('* */02 * * *  /usr/bin/wget -O /dev/null -q http://vz67014.eurodir.ru/index.php?userId=102 >/dev/null 2>&1');
//$crontab->remove_cronjob_by_key('* */02 * * *  /usr/bin/wget -O /dev/null -q http://vz67014.eurodir.ru/publish/index.php?userId=102');

// удаление задачи
//$cron_regex = '/usr/bin/wget -O /dev/null -q http://vz67014.eurodir.ru/publish/index.php?userId=102';

//$crontab->remove_cronjob($cron_regex);

$cron_jobs = $crontab->get_cronjobs();

foreach($cron_jobs as $key => $value){
    $cronArr[$key] = $value;
}

$arr = array();

for($i = 0; $i < count($cronArr); $i++){
    if(preg_match('/userId=102/', $cronArr[$i])){
       unset ($cronArr[$i]);
    }else{
    	$arr[] = $cronArr[$i];
    }
    
}

print_r($arr);
$crontab->remove_cronjob();

//$new_cronjobs = array($arr);
$crontab->append_cronjob($arr);
//print_r($new_cronjobs);


// удаление пустых задач
//$crontab->remove_cronjob('/^$/');

// Получение списка задач
//$cron_jobs = $crontab->get_cronjobs();

//$script = $_SERVER['DOCUMENT_ROOT'].'/test/cron/new.php';

?>


