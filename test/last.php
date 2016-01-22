<?php
/*
error_reporting(E_ALL);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://2ip.ru/");
curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:9050');
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
$result = curl_exec($ch);
//curl_close($ch);
echo $result;



function get($url,$proxy) { 
        $ch = curl_init();   
        curl_setopt($ch, CURLOPT_URL,$url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208'); 
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXY, "$proxy"); 
        $ss=curl_exec($ch); 
        curl_close($ch); 
        return $ss; 
} 



      $prox = '127.0.0.1:9050';
      $a=get('http://2ip.ru/',$prox); 
      echo $a;

*/
 $cookie_path = dirname(__FILE__).'/1.txt';


 function tor_new_identity($tor_ip='127.0.0.1', $control_port='9051', $auth_code=''){
    $fp = fsockopen($tor_ip, $control_port, $errno, $errstr, 30);
    if (!$fp) return false; // не можем законнектицца на порт управления
 
    fputs($fp, "AUTHENTICATE $auth_code\r\n");
    $response = fread($fp, 1024);
    list($code, $text) = explode(' ', $response, 2);
    if ($code != '250') return false; 
 
    // шлём запрос на смену звена
    fputs($fp, "signal NEWNYM\r\n");
    $response = fread($fp, 1024);
    list($code, $text) = explode(' ', $response, 2);
    if ($code != '250') return false;
 
    fclose($fp);
    return true;
}


if (tor_new_identity('127.0.0.01', '9051')) {
  //error_reporting(E_ALL);/ad
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://bazarpnz.ru/add.php?avto");
  //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
  curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:9050');
  curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
  curl_setopt($ch, CURLOPT_COOKIESESSION, true);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_path);  // file to read
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path);   // file to write
  curl_setopt($ch, CURLOPT_VERBOSE, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:2.0b9pre) Gecko/20110105 Firefox/4.0b9pre');
  curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php");
  curl_setopt($ch, CURLOPT_FAILONERROR, 1); 


  
  $result = curl_exec($ch);
  curl_close($ch);
  echo iconv('windows-1251','utf-8',$result);

}
?>