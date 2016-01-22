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
  /*
  if(date('H') == 10){
    $hours = date('H');
  }else{
    $hours = str_replace('0', '', date('H'));
  }

  $weekday = date('w');
  */
  $hours = 10;
  $weekday = 7;

  $repeat = 5;

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

  if(isset($user1[0][0])){
     $arr[$key]['user']  = $user1[0][0];
     $arr[$key]['idAds'] = $value[0];
     $arr[$key]['hours'] = $value[1];
     $arr[$key]['days']  = $value[2];

     $username = $mysql->Select('SELECT username FROM table_User WHERE id = '.$user1[0][0]);
     $arr[$key]['username'] =  $username[0][0];
  }

}

foreach ($arr as $key => $value) {
	//echo $value['idAds'].'<br>';

	$public_bazarpnz = $mysql->Select('SELECT idAds FROM table_public_bazarpnz WHERE idAds = '.$value['idAds'].' and datePublic < (NOW()- interval 1 day)');

	if(isset($public_bazarpnz[0][0])){
	   $var[$key]['idAds'] = $public_bazarpnz[0][0];
	   $var[$key]['user'] = $value['user'];
	}
	
}


$b = 0;

foreach ($var as $key => $value) {
	$am[$b]['idAds'] = $value['idAds'];
	$am[$b]['user'] = $value['user'];
	$b++;
}

echo count($am);
print_r($am);

if(count($am) > 0){
    
    (count($am) <= $repeat) ? $c = count($am) : $c = $repeat;

    for($i = 1; $i <= $c; $i++){
        $index = rand(1,count($am));
        if(!in_array($index, $mass)){
            $mass[] = $index;
        }else{
            $i = $i - 1;
        }

    }
}


/*
foreach ($mass as $key => $value) {

          $ch = curl_init('http://vz67014.eurodir.ru/publish/index.php?parametrs='.$am[$value]['user'].':'.$am[$value]['idAds']);
          curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");
          curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_VERBOSE, 1);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

          $result2 = curl_exec($ch);

          echo iconv('windows-1251','utf-8',$result2);
}
/*
 (count($arr) <= $repeat) ? $c = count($arr) : $c = $repeat;

    for($i = 1; $i <= $c; $i++){
        $index = rand(1,count($arr));
        if(!in_array($index, $mass)){
            $mass[] = $index;
        }else{
            $i = $i - 1;
        }

    }



print_r($mass);

//echo count($arr);
?>