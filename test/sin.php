<?
header('Content-type: text/html; charset=utf-8');
mb_internal_encoding('utf-8');

include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/phpQuery.php');

$cookie_path = dirname(__FILE__).'/coc.txt';

        $postVars = array(
                   'S1'=> mb_convert_encoding('Застройщик продает квартиру в центре города в ЖК «на Кузнецкой» (ул. Кузнецкая, район автовокзала).

Кирпичный дом, подземная парковка, отличный вид на Суру, в шаговой доступности 3 детских сада, 2 школы, гимназия № 6, поликлиника, продуктовый рынок.

Оформление ипотеки от Сбербанка России у нас в офисе.

Сдача дома: 2 квартал 2016 года. Цена действительна на данном этапе строительства.

Также в наличии имеются 1, 2 и 3 комнатные квартиры, коммерческая недвижимость под магазин и офисы:', "windows-1251", "utf-8"),
                   'q'=> '1',
                   'C1' => '',
                   'B1'=> mb_convert_encoding('Отправить (Ctrl + Enter)', "windows-1251", "utf-8"),


               );


        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'http://online-sinonim.ru/');
        //curl_setopt($curl, CURLOPT_HEADER, 1);
        
        // подключаем прокси
        //curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1); 
        //curl_setopt($curl, CURLOPT_PROXY, $this->random_proxy());
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);

        curl_setopt($curl, CURLOPT_USERAGENT,  "Opera/9.80 (X11; Linux i686; U; fr) Presto/2.7.62 Version/11.01");

        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_path); // file to read
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_path); // file to write
        curl_setopt($curl, CURLOPT_REFERER, 'http://online-sinonim.ru/');
        curl_setopt($curl, CURLOPT_POST, 1);  
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postVars)); 

        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        //curl_setopt($curl, CURLINFO_HEADER_OUT, 1);

        $result = curl_exec($curl);

        $string = strpos($result, 'bgcolor="#FDFDFD"');

        //echo $string;

        $res = substr($result, $string,-100);

        //print_r($res);
        $t =  iconv('windows-1251','utf-8',$res);

        //$result1 = mb_convert_encoding($result, "windows-1251", "utf-8");
        
        //$res = substr($result, 1,300);

        //echo $res;

        //echo iconv('windows-1251','utf-8',$result);

        $documents = phpQuery::newDocumentHTML($t);

        $input = $documents->find('div',0)->text();

        //$pattern = array('&amp','#65533');

       // echo str_replace($pattern, '', trim($input));

        echo strip_tags($input);

        //echo iconv('windows-1251','utf-8',$input);


        //$r = pq($input)->find('td div')->text();

        //echo mb_convert_encoding($input, "windows-1251","utf-8");


?>