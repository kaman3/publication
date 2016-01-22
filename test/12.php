<?
        
       // $s = fopen($fname=$_SERVER['DOCUMENT_ROOT'].'/test/proxi/proxi.txt', "rt");
        //$namefamili = explode("\n",fread($listfile,filesize($fname))); 
        //echo count($namefamili);
       /*
            function random_proxy($proxy_array = array()) {
        
               return $proxy_array[rand(0,(count($proxy_array)-1))];
            }


            $ch = curl_init(trim('http://rlpnz.ru/test/proxi/proxi.txt'));

            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");              
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

            $result = curl_exec($ch);

            $proxi = explode("\n", $result);


            
                $testProxi = curl_init(trim('http://bazarpnz.ru/add.php?main'));
                //curl_setopt($testProxi, CURLOPT_HTTPPROXYTUNNEL, 1);
                //curl_setopt($testProxi, CURLOPT_PROXY, trim(random_proxy($proxi)));
                curl_setopt($testProxi, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
                curl_setopt($testProxi, CURLOPT_PROXY, '46.232.207.166:1080');
                curl_setopt($testProxi, CURLOPT_HEADER, 0);
                curl_setopt($testProxi, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)');
                curl_setopt($testProxi, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");              
                curl_setopt($testProxi, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
                curl_setopt($testProxi, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
                curl_setopt($testProxi, CURLOPT_VERBOSE, 1);
                curl_setopt($testProxi, CURLOPT_CONNECTTIMEOUT, 0);
                curl_setopt($testProxi, CURLOPT_COOKIEFILE, dirname(__FILE__).'1.txt');  // file to read
                curl_setopt($testProxi, CURLOPT_COOKIEJAR, dirname(__FILE__).'/1.txt');   // file to write

                
                $test = curl_exec($testProxi);

                $http_code = curl_getinfo($testProxi, CURLINFO_HTTP_CODE); // Получаем HTTP-код

                //echo iconv('windows-1251','utf-8',$test);
                echo $http_code;
            

           


       function random_proxy() {
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
 */


        
        $ch = curl_init("http://bazarpnz.ru/add.php?main");

        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)');
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        //curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY, '212.33.246.38:3128');
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'user:121212');
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");
        curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);           // Передаем POST-параметры
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/img/cookie/.txt');  // file to read
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/img/cookie/.txt');   // file to write
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

        $result2 = curl_exec($ch);

        echo iconv('windows-1251','utf-8',$result2);  
        
?>