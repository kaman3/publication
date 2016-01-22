<?


include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/phpQuery.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish_test/include/antigate.php');

function startTimeout($seconds = 1) {
        if($seconds==0) return;
        $start_time = time();
        while(true) if ((time() - $start_time) >= $seconds) return false;
}

function geturl($url) 
{    
        // инициализация сеанса 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        //curl_setopt($ch, CURLOPT_REFERER, 'http://bazarpnz.ru/add.php');
        curl_setopt($ch, CURLOPT_COOKIESESSION, true); 
        curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/test/cookie.txt'); // file to write
        //curl_setopt($ch, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/test/cookie.txt');
        curl_setopt($ch, CURLOPT_HEADER, 1); 
        curl_setopt($ch, CURLOPT_NOBODY, 1); 
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        curl_setopt($ch, CURLOPT_PROXY, 'ru1.proxik.net:80');
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'ru41103:Gjo3LAAaf4');
        $res = curl_exec($ch); 
        //curl_close($ch); 
        curl_close($ch);
    return $res; 
} 


$header = geturl('http://bazarpnz.ru/add.php?main');
preg_match('|PHPSESSID=(.*);|U', $header, $out); 
$session = $out[1];
echo $header;
preg_match('|user=(.*);|U', $header, $out2);

$user = $out2[1];

function get_img($session = '',$captcha_file_name = '',$header,$user){

	  $url = 'http://bazarpnz.ru/code.php?PHPSESSID='.$session;
	  //$url = 'http://bazarpnz.ru/code.php';

	 //$url = 'http://bazarpnz.ru/code.php?PHPSESSID=59e0160ac1588270ea0ad4a0b832dd08';

	 $curl = curl_init(); 
	 curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_REFERER, 'http://bazarpnz.ru/add.php');
     curl_setopt($curl, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/test/cookie.txt'); // file to write
     curl_setopt($curl, CURLOPT_HEADER, 0);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1);
     curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);
     curl_setopt($curl, CURLOPT_AUTOREFERER, true);
     curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
     curl_setopt($curl, CURLOPT_MAXREDIRS, 20);
     curl_setopt($curl, CURLOPT_HTTPGET, true);
     curl_setopt($curl, CURLOPT_ENCODING,"gzip, deflate");
     //curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
     curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)");
     //curl_setopt($curl, CURLOPT_COOKIE, 'PHPSESSID='.$session);
     //curl_setopt($curl, CURLOPT_HTTPHEADER,array('PHPSESSID='.$session, 'PNZ=1','user='.$user));

     //curl_setopt($curl, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/test/cookie.txt');    
     curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
     curl_setopt($curl, CURLOPT_PROXY, 'ru1.proxik.net:80');
     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
     curl_setopt($curl, CURLOPT_PROXYUSERPWD, 'ru41103:Gjo3LAAaf4');

     $resultEnd = curl_exec($curl);
     $error = curl_error($curl).'('.curl_errno($curl).')';
     echo $error;
     curl_close($curl);

     $fp = fopen($captcha_file_name,'w');
        fwrite($fp, $resultEnd);
        fclose($fp);
}

$rcn = md5(rand(1,10000).time());
$captcha_file_name = dirname(__FILE__).'/captcha_'.$rcn.'.jpg';// новое имя файла

get_img($session,$captcha_file_name,$user);


function post($session = '',$postVars = array(),$user){

	 $curl = curl_init(); 
	 curl_setopt($curl, CURLOPT_URL, 'http://bazarpnz.ru/add.php?main');
     curl_setopt($curl, CURLOPT_REFERER, 'http://bazarpnz.ru/add.php');
     curl_setopt($curl, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/test/cookie.txt');
     curl_setopt($curl, CURLOPT_HEADER, 0);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1);
     curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);
     curl_setopt($curl, CURLOPT_AUTOREFERER, true);
     curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
     curl_setopt($curl, CURLOPT_POST, 1);
     //curl_setopt($curl, CURLOPT_COOKIESESSION, true);
     //curl_setopt($curl, CURLOPT_HTTPHEADER,array('PHPSESSID='.$session, 'PNZ=1','user='.$user));
     curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postVars));
     curl_setopt($curl, CURLOPT_MAXREDIRS, 20); 
     curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)");
     //curl_setopt($curl, CURLOPT_COOKIE, 'PHPSESSID='.$session);
     //curl_setopt($curl, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/test/cookie.txt'); // file to write
     //curl_setopt($curl, CURLOPT_HTTPHEADER, array('PHPSESSID='.$session, 'PNZ=1','user='.$user));
     curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
     //curl_setopt($curl, CURLOPT_VERBOSE, 1);
     curl_setopt($curl, CURLOPT_PROXY, 'ru1.proxik.net:80');
     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
     curl_setopt($curl, CURLOPT_PROXYUSERPWD, 'ru41103:Gjo3LAAaf4');

     $result2 = iconv('CP1251', 'UTF-8', curl_exec($curl));
     curl_close($curl);

     echo $result2;
     $error = curl_error($curl).'('.curl_errno($curl).')';
     echo $error;
}

    $antigate_api_key = 'e8c4778028b59dc51924cf1edb1f6cc1';

    $code = recognize($captcha_file_name,$antigate_api_key,true,"antigate.com",5,120,0,0,1,4,6,0);

    echo $code;

    $postVars = array(
        'addtype'=>'main',
        'name'=>iconv("utf-8", "windows-1251", ''),
        'phone'=>$_POST['phone'],
        'email'=>$_POST['email'],
        'icq'=>'',
        'skype'=>'',
        'title'=>iconv("utf-8", "windows-1251", $_POST['title']),
        'text'=>iconv("utf-8", "windows-1251", $_POST['text']),
        'price'=>$_POST['price'],
        'curr'=>1,
        'rub'=>247,
        'rub_select'=>$_POST['rub'],
        'rn'=>0,
        'rooms'=>$_POST['rooms'],
        'typ'=>$_POST['type'],
        'period'=>$_POST['period'],
        'code'=>trim($code),
        'rights'=>1,
        'userls'=>$user,
        'subm'=>iconv("utf-8", "windows-1251", 'Отправить'),
        'key'=>''
    );

post($session,$postVars);









?>