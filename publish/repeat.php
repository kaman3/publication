<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');

ini_set('display_errors', 1);

// соединяемся с баззой данных
$connection = new Connection();
$mysql = $connection->config();

// число повторений, (набираем набор из 5 елементов)
$repeat = 5;

$array = $mysql->Select("SELECT idAds, userId FROM table_public_bazarpnz WHERE public = 0 ORDER BY datePublic ASC");

// проверяем какие существуют и стоят на публикации
$b = 0;

foreach ($array as $key => $value){

    $real = $mysql->Select("SELECT id FROM table_publication_object WHERE id = ".$value[0]." and publich = 1");

    if($real[0][0]){
        $b++;
        $setup['random_item'][$b]['id'] = $real[0][0];
        $setup['random_item'][$b]['user'] = $value[1];
    }

}


if(count($setup['random_item']) > 0){

    $mass = array();

    (count($setup['random_item']) <= $repeat) ? $c = count($setup['random_item']) : $c = $repeat;


    for($i = 1; $i <= $c; $i++){
        $index = rand(1,count($setup['random_item']));
        if(!in_array($index, $mass)){
            $mass[] = $index;
        }else{
            $i = $i - 1;
        }

    }


    foreach ($mass as $key => $value) {

         //file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/publish/index.php?parametrs='.$setup['random_item'][$value]['user'].':'.$setup['random_item'][$value]['id']);
          $ch = curl_init('http://http://publishads.ru/publish/index.php?parametrs='.$setup['random_item'][$value]['user'].':'.$setup['random_item'][$value]['id']);
          curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");
          curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_VERBOSE, 1);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

          $result2 = curl_exec($ch);

          echo iconv('windows-1251','utf-8',$result2);

    }

    echo count($setup['random_item']);

}else{
    die('Нет необубликованных объявлений');
}