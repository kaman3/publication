<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/phpQuery.php');

class bobr{
     

      public function random_proxy() {
        $proxy_array = array(

              '213.219.244.148:7951',
              '213.219.244.149:7951',
              '213.219.244.150:7951',
              '213.219.244.151:7951',
              '213.219.244.152:7951',
              '213.219.244.153:7951',
              '213.219.244.154:7951',
              '213.219.244.155:7951',
              '213.219.244.176:7951',
              '213.219.244.159:7951',
              '213.219.244.160:7951',
              '213.219.244.161:7951',
              '213.219.244.162:7951',
              '213.219.244.163:7951',
              '213.219.244.164:7951',
              '213.219.244.165:7951',
              '213.219.244.166:7951',
              '213.219.244.167:7951',
              '213.219.244.168:7951',
              '213.219.244.169:7951',
              '213.219.244.170:7951',
              '213.219.244.171:7951',
              '213.219.244.172:7951',
              '213.219.244.173:7951',
              '213.219.244.174:7951',
              '213.219.244.175:7951',
              '213.248.62.176:7951',
              '213.248.62.177:7951',
              '213.248.62.178:7951',
              '213.248.62.179:7951',
              '213.248.62.180:7951',
              '213.248.62.181:7951',
              '213.248.62.182:7951',
              '213.248.62.183:7951',
              '213.248.62.184:7951',
              '213.248.62.185:7951',
              '213.248.62.186:7951',
              '213.248.62.187:7951',
              '213.248.62.188:7951',
              '213.248.62.189:7951',
              '213.248.62.190:7951',
              '213.248.62.191:7951',
              '213.248.62.192:7951',
              '213.248.62.193:7951',
              '213.248.62.194:7951',
              '213.248.62.195:7951',
              '213.248.62.196:7951',
              '213.248.62.197:7951',
              '213.248.62.198:7951',
              '213.248.62.199:7951',
              '213.248.62.200:7951',
              '213.248.62.201:7951',
              '213.248.62.202:7951',
              '213.248.62.203:7951',
              '213.248.62.204:7951',
              '109.120.128.178:7951',
              '109.120.128.179:7951',
              '109.120.128.180:7951',
              '109.120.128.181:7951',
              '109.120.128.182:7951',
              '109.120.128.183:7951',
              '109.120.128.184:7951',
              '109.120.128.185:7951',
              '109.120.128.186:7951',
              '109.120.128.187:7951',
              '109.120.128.188:7951',
              '109.120.128.189:7951',
              '109.120.128.190:7951',
              '77.221.152.210:7951',
              '77.221.152.211:7951',
              '77.221.152.212:7951',
              '77.221.152.213:7951',
              '77.221.152.214:7951',
              '77.221.152.215:7951',
              '77.221.152.216:7951',
              '77.221.152.217:7951',
              '77.221.152.218:7951',
              '77.221.152.219:7951',
              '77.221.152.220:7951',
              '77.221.152.221:7951',
              '77.221.152.222:7951',
              '92.243.65.210:7951',
              '92.243.65.211:7951',
              '92.243.65.212:7951',
              '92.243.65.213:7951',
              '92.243.65.214:7951',
              '92.243.65.215:7951',
              '92.243.65.216:7951',
              '92.243.65.217:7951',
              '92.243.65.218:7951',
              '92.243.65.219:7951',
              '92.243.65.219:7951',
              '92.243.65.221:7951',
              '92.243.65.222:7951',

        );
        return $proxy_array[rand(0,(count($proxy_array)-1))];
    }


    public function login(){

       $url = 'http://bobrdobr.ru/login/';

       $login_data = array(
            'username' => '62kaman',
            'password' => '454545',    
            'next'=>'http://bobrdobr.ru/add/',
            'submit'=>mb_convert_encoding('Войти', "windows-1251", "utf-8")
            //mb_convert_encoding('логин', "windows-1251", "utf-8")=>'action',
        );

       $ch = curl_init();

       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_HEADER,1);
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
       curl_setopt($ch, CURLOPT_FAILONERROR, 1);
       curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
       curl_setopt($ch, CURLOPT_PROXY, $this->random_proxy());
       curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'rp3050219:p0vjYkhhUC');
       //curl_setopt($ch, CURLOPT_COOKIESESSION, true);
       curl_setopt($ch, CURLOPT_POST, 1); 
       curl_setopt($ch, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/test/cookie.txt');  // file to read
       curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/test/cookie.txt');   // file to write
       curl_setopt($ch, CURLOPT_VERBOSE, 1);
       curl_setopt($ch, CURLOPT_REFERER, 'http://bobrdobr.ru/add/');
       curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($login_data));
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
       //curl_setopt($ch, CURLOPT_HTTPGET, true);
       curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)');
       //curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
       //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
       //curl_setopt($ch, CURLOPT_PROXY, $this->random_proxy());
       //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


       $result2 = curl_exec($ch);

       $document = phpQuery::newDocument($result2);

       $add_heads = $document->find('[name=killspammers]')->attr('value');

       print_r($result2);


       return $add_heads;


   }


       //print_r($result2);

   public function postZak($code){

        $meta_data = array(
            'url' => 'http://rlpnz.ru/nedvizhimost_v_penze/realtyObject.html',
            'name' => 'Недвижимость в пензе',    
            'tags'=>'недвижимость',
            //'private'=>'',
            'next'=>'http://bobrdobr.ru/people/62kaman/',
            //'killspammers'=>trim($code),
            'submit'=>mb_convert_encoding('Сохранить', "windows-1251", "utf-8")
            //mb_convert_encoding('логин', "windows-1251", "utf-8")=>'action',
        );

       $chi = curl_init();

       curl_setopt($chi, CURLOPT_URL, 'http://bobrdobr.ru/add/');
       curl_setopt($chi, CURLOPT_HEADER,1);
       curl_setopt($chi, CURLOPT_FOLLOWLOCATION,1);
       curl_setopt($chi, CURLOPT_FAILONERROR, 1);
       curl_setopt($chi, CURLOPT_HTTPPROXYTUNNEL, 1);
       curl_setopt($chi, CURLOPT_PROXY, $this->random_proxy());
       curl_setopt($chi, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       curl_setopt($chi, CURLOPT_PROXYUSERPWD, 'rp3050219:p0vjYkhhUC');
       //curl_setopt($ch, CURLOPT_COOKIESESSION, true);
       curl_setopt($chi, CURLOPT_POST, 1); 
       curl_setopt($chi, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/test/cookie.txt');  // file to read
       curl_setopt($chi, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/test/cookie.txt');   // file to write
       curl_setopt($chi, CURLOPT_VERBOSE, 1);
       curl_setopt($chi, CURLOPT_REFERER, 'http://bobrdobr.ru/');
       curl_setopt($chi, CURLOPT_POSTFIELDS, http_build_query($meta_data));
       curl_setopt($chi, CURLOPT_CONNECTTIMEOUT, 30);
       //curl_setopt($ch, CURLOPT_HTTPGET, true);
       curl_setopt($chi, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)');
       //curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
       //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
       //curl_setopt($ch, CURLOPT_PROXY, $this->random_proxy());
       //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
       curl_setopt($chi, CURLOPT_RETURNTRANSFER, 1);

       $result3 = curl_exec($chi);

       print_r($result3);

       //$document = phpQuery::newDocument($result3);

       //$add_heads = $document->find('[name=killspammers]')->attr('value');

      

   }



   public function publ(){
      $code = $this->login();
      echo $code.'----Djn---';
      $this->postZak($code);

   }


}


$app = new bobr;

echo $app->publ();

       //curl_setopt($ch, CURLOPT_URL, 'http://bobrdobr.ru/add/');



?>