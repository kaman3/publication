<?php
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/phpQuery.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/antigate.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/rucaptcha.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/application.php');

ini_set("display_errors",1);
error_reporting(E_ALL);
ini_set('max_execution_time', 1200);
echo ini_get('max_execution_time'); // 100
set_time_limit(1200);

//echo '<link rel="stylesheet" type="text/css" href="/publish/resources/css/style.css">';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// код публикатора
/**
 * @property mixed captcha_file_name
 */
class public_bazarpnz extends app{

    function __construct(){
        $connection = new Connection();
        $this->mysql = $connection->config();
        $this->part_cookie = dirname(__FILE__).'/tmp/cookie/';
    }

    // создаем или загружаем профиль пользователя
    public function create_and_load_user($contact_id){

        $data_update = array();

        $get_userls = $this->get_userls($contact_id);
        // если пользователь уже существует используем его
        if(!empty($get_userls)){
            $data_update['contact_id'] = $get_userls[0][1];
            $data_update['userls']     = $get_userls[0][2];
            $data_update['PHPSESSID']  = $get_userls[0][3];
            $data_update['ip']         = $get_userls[0][4];
            $data_update['browser']    = $get_userls[0][5];
        }else{
        // иначе создаем нового
            $link = 'http://bazarpnz.ru/';
            
            $cookie_path = dirname(__FILE__).'/tmp/cookie/'.$contact_id.'.txt';
            //if(file_exists($cookie_path)) unlink($cookie_path);
            // проверяем существует ли файл
            if (file_exists($cookie_path)) {
                echo "Файл существует";
            } else {
                echo "Файл не существует";
            }
            if(!$contact_id){ die('Ошибка контакта не существует');}
            // получаем браузер и ип для каждого пользователя индивидуально
            $browser_and_ip = array();
            $browser_and_ip = $this->rand_browser_and_ip($contact_id);

            print_r($browser_and_ip);
            print_r($data_update);
            echo '<br>';
            echo 'Браузер данные';

            // получаем заголов сервера (header)
            $fOut = fopen(dirname(__FILE__).'/tmp/headers/'.$contact_id.'.txt', "w" );

            $ch = curl_init(trim($link));

            curl_setopt($ch, CURLOPT_USERAGENT, $browser_and_ip['browser']);
            //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
            //curl_setopt($ch, CURLOPT_PROXY, $browser_and_ip['ip']);
            //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
            curl_setopt($ch, CURLOPT_PROXY, $browser_and_ip['ip']);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/");
            curl_setopt($ch, CURLOPT_POST, 1);                         
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_STDERR, $fOut);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
            //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_path); 
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path); 

            $result = curl_exec($ch);

            curl_close($ch);

            $file_data = "";

            $fd = fopen(dirname(__FILE__).'/tmp/headers/'.$contact_id.'.txt', "r");

            if (!$fd)   {
               echo "Error! Could not open the file.";
               die;
            }
            while  (! feof($fd))   {
               $file_data .= fgets($fd,  5000);
            }
            fclose ($fd);  
            // phpsid
            preg_match('#PHPSESSID=(.*);#',$file_data,$matches);
            $PHPSESSID = $matches[1];
            // user
            preg_match('#user="(.*)"#',$file_data,$matches1);
            $user = $matches1[1];

            if(!$user){
               preg_match('#user=(.*)#',$file_data,$matches1);
               $user = $matches1[1]; 
            }

            if($user and $PHPSESSID){

                $data_update['contact_id'] = $contact_id;
                $data_update['userls']     = $user;
                $data_update['PHPSESSID']  = $PHPSESSID;
                $data_update['ip']         = $browser_and_ip['ip'];
                $data_update['browser']    = $browser_and_ip['browser'];

                print_r($data_update);
                $this->mysql->Insert('table_userls', $data_update);

            }
    }

     return $data_update;
    }
   

    // проверяем ответ сервера
    public function connect($proxi,$id = 1,$action = 1){

            $ch = curl_init();

            
            curl_setopt($ch, CURLOPT_URL, 'http://bazarpnz.ru/');
            curl_setopt($ch, CURLOPT_REFERER, '');
            //curl_setopt($ch, CURLOPT_USERAGENT, $this->random_user_agent());
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; nb-no) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5');
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
            //curl_setopt($ch, CURLOPT_PROXY, $proxi);
            curl_setopt($ch, CURLOPT_PROXY, '185.101.68.57:1080');
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
            curl_setopt($ch, CURLOPT_TIMEOUT, 160);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 160);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_path);
            //curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_path); // изменил
            
            

            $result = curl_exec($ch);

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код

            curl_close($ch);

            if($action == 2 and $http_code == 200){
                $this->getMessage('serega569256@bk.ru','Прокси - '.$proxi.' код ошибки - '.$http_code.' удалено - '.$id);
                if($id == 1){
                   $this->getMessage('serega569256@bk.ru',$result);
                }
            }else if($action == 1){
                $this->getMessage('serega569256@bk.ru','Прокси - '.$proxi.' код ошибки - '.$http_code.' id - '.$id);
            }


        return $http_code;
    }

    // проверяем точно ли удаленно объявление
    public function control_del_ads($link_ads, $id, $data_user = array()){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $data_user['browser']);
        
        curl_setopt($ch, CURLOPT_URL, trim($link_ads));
        //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        //curl_setopt($ch, CURLOPT_PROXY, $data_user['ip']);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY, $data_user['ip']);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_REFERER, $this->random_refer());
        curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 160);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 160);

        $result = curl_exec($ch);
         

        curl_close($ch);

        $document = phpQuery::newDocumentHTML($result);
        $check_href = $document->find('.text a')->attr('href');  // ссылка
        $check_text = $document->find('.text p')->text();

        $this->getMessage('serega569256@bk.ru','Удалено и проверено - '.$id.' = '.$link_ads);

        /*
        if(strlen($check_href) == 18 and strlen($check_text) == 114){
           $this->getMessage('serega569256@bk.ru','Удалено и проверено - '.$id.' = '.$link_ads);
        }else{
           $this->getMessage('serega569256@bk.ru','Нет не удалено - '.$id.' = '.$link_ads);
           die('Объявление не удалось удалить');
        }
        */
    }

    // удаляем уже размещенные объявления
    public function deleteAds($link,$link_ads,$id,$data_user = array()){

        $adv_id = explode('=', $link);

        $postVars = array(
            'delete' => mb_convert_encoding('Удалить объявление!', "windows-1251", "utf-8"),
            'delete' => mb_convert_encoding('Не хочу, удалить объявление', "windows-1251", "utf-8"),   
            'adv_id' => trim($adv_id[1]),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, trim($link));
        //curl_setopt($ch, CURLOPT_USERAGENT, $this->random_user_agent());
        curl_setopt($ch, CURLOPT_USERAGENT, $data_user['browser']);
        //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        //curl_setopt($ch, CURLOPT_PROXY, $proxi);
        //curl_setopt($ch, CURLOPT_PROXY, $data_user['ip']);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY, $data_user['ip']);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_REFERER, $this->random_refer());
        curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);           // Передаем POST-параметры
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 160);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 160);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->part_cookie.$data_user['contact_id'].'.txt'); // file to read
        //curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write



        $result = curl_exec($ch);

        //echo $result;

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код

        if($http_code == 200) {
            $idAds = $id;  // id  объявления
            $this->deleteDb($idAds);      // записываем данные в базу данных

            //sleep(5);
       
            $document = phpQuery::newDocumentHTML($result);
            $check = $document->find('#mess_info')->text(); // name input для пля код, сюда в дальнейшем вставляем капчу   


            if(strlen($check) == 54){
               $this->getMessage('serega569256@bk.ru','Удалено - '.$id.' = '.$link);
               // проверяем точно ли удаленно объявление, если нет то останавливаем публикацию этого объявления 
               $this->control_del_ads($link_ads,$id);
            }else{
               $this->getMessage('aligoweb@ya.ru','неудолось удалить объявление - '.$id.' = '.$link);
               // оправляем смс  sms.ru
               $body=file_get_contents("http://sms.ru/sms/send?api_id=be6a15b0-7cf4-0074-d5cb-2e7b88c14a99&to=79374376600&text=не_удаляются._объявления");
               // выключаем публикацию до устранения ошибки
               $dataUpdate['count'] = 20;
               $this->mysql->Update('table_option_not_publish',$dataUpdate, "id = 1");
            }
        }else{
            //sleep(20);
            $this->deleteAds($link,$id); // если не получили доступ к странице заходим еще на один круг
        }
        curl_close($ch);
    }



    public function get_session($var){

        $dataCookie = array();

        preg_match('#PHPSESSID=(.*);#',$var,$matches);

        $dataCookie['session'] = str_replace("&rn=' + Math.random()",'',$matches[1]);
        if($dataCookie['session']){
            return $dataCookie;
        }else{

            $c = 0;
            $proxi = '';
            do{
                $c++;
                $proxi = $this->random_proxy();//sleep(2);

                if($proxi){
                    $connect = $this->connect($proxi);
                }
            }while($connect != 200 and $c <= 20);
            $this->get_captha($proxi);
        }

    }

    public function get_captha($data_user = array()){

        $data = array();

        $rcn = md5(rand(1,10000).time());
        $this->captcha_file_name = dirname(__FILE__).'/tmp/captcha/captcha_'.$rcn.'.jpg';// новое имя файла

        $ch = curl_init('http://bazarpnz.ru/add.php?main');
        curl_setopt($ch, CURLOPT_USERAGENT, $data_user['browser']);
        //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        //curl_setopt($ch, CURLOPT_PROXY, $data_user['ip']);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY, $data_user['ip']);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 160);
        curl_setopt($ch, CURLOPT_TIMEOUT, 160);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 'http://bazarpnz.ru/add.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->part_cookie.$data_user['contact_id'].'.txt'); // file to read


        curl_setopt($ch, CURLOPT_VERBOSE, 1);


        $result = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код

        if($http_code == 0 or $http_code == 302){
           $this->getMessage('serega569256@bk.ru','Нет доступа - '.$proxi.' код - '.$http_code);
        }



        $document = phpQuery::newDocumentHTML($result);
        $input = $document->find('#step6_go table tr td label')->attr('for'); // name input для пля код, сюда в дальнейшем вставляем капчу
        $key =   $document->find('[name=key]')->attr('value');                // ссылка на картинку капчи
        $session = $document->find('#step6_go table tr td small a')->attr('onclick');
        //$users = $document->find('#user_ls')->attr('value');
        // берем сессию

        //$dataCook = $this->get_session($session);
        //$this->startTimeout(5);

        curl_setopt($ch, CURLOPT_URL,"http://bazarpnz.ru/code.php?PHPSESSID=".$data_user['PHPSESSID']."&rn=0.5580270048230886"); // задаем адрес обработчика формы
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->part_cookie.$data_user['contact_id'].'.txt'); // file to read
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 160);
        

        $img = curl_exec($ch); // Скачиваем картинку

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код

        if($http_code == 200) {
            $fp = fopen($this->captcha_file_name,'w');
            fwrite($fp, $img);
            fclose($fp);
             
            // rucaptha
            $code = recognize($this->captcha_file_name,"f5a8a7302e5950256950277b4f6b580c",true, "rucaptcha.com");

            // если не получилось распознать капчу в сервисе rucapcha, распознаем antigate
            if(!$code){
                $this->getMessage('serega569256@bk.ru','Не удалось распознать капчу');
                $antigate_api_key = 'e8c4778028b59dc51924cf1edb1f6cc1';
                $code = recognize($this->captcha_file_name,$antigate_api_key,true,"antigate.com",10,120,0,0,1,4,6,0);
            }

        }

        /** @var $code TYPE_NAME */
        /** @var $dataCook TYPE_NAME */

        $data['code']  = $code;
        $data['input'] = $input;
        $data['key']   = $key;
      

        curl_close($ch);

        return $data;
    }

    public function post($postVars = array(),$data_user = array()){

        $data = array();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://bazarpnz.ru/add.php?main");
        curl_setopt($ch, CURLOPT_USERAGENT, $data_user['browser']);
        //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        //curl_setopt($ch, CURLOPT_PROXY, $data_user['ip']);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY, $data_user['ip']);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
        curl_setopt($ch, CURLOPT_TIMEOUT, 160);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 160);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");
        curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);           // Передаем POST-параметры
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->part_cookie.$data_user['contact_id'].'.txt'); // file to read
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        $result2 = curl_exec($ch);

        echo iconv('windows-1251','utf-8',$result2);

        $document = phpQuery::newDocumentHTML($result2);
        $edit_link = $document->find('#mess_info big a')->attr('href');
        $object_link =  $document->find('#mess_info a')->attr('href');

        curl_close($ch); // Закрываем сессию

        // данный которые уже заданны
        $data['idAds']      = $postVars['id'];
        $data['userId']     = $postVars['userId'];
        $data['datePublic'] = date('Y-m-d H:i:s');

        if(strlen($edit_link) > 2){

            echo '<a href = "'.$edit_link.'" target = "blank">ссылка на редактирование</a><br>';
            echo '<a href = "'.$object_link.'" target = "blank">ссылка на объявление</a><br>';
            echo 'длинна строки - '.strlen($edit_link).'<br>';
            echo '<hr>';
            // если объявление размещенно
            // подготавливаем данные для записи в базу
            $data['public']     = 1;
            $data['deliteLink'] = $edit_link;
            $data['link']       = $object_link;

        }else{
            // если произошла ошибка
            $data['public']     = 0;
            $data['deliteLink'] = '';
            $data['link']       = '';
        }

        return $data;

    }

    
    // публикуем объявления
    public function main($adsMass = array(),$randIp){

        $data = array();
        $adsArray = array();
        // перезаписываемм массив
        $adsArray = $adsMass;


        for($i = 0; $i < count($adsArray); $i++){
            // получаем аккаунт пользователя
            $data_user = $this->create_and_load_user($adsArray[$i]['contact_id']);

            // удаляем объявление
            if($adsArray[$i]['link_del']){
               $this->deleteAds($adsArray[$i]['link_del'],$adsArray[$i]['link_ads'], $adsArray[$i]['id'],$data_user);  
            }
            

            $r = 0;

            do{
                $r++;
                // если мы зашли на второй круг, проверяем удалилось ли объявление
                /*
                if($r == 2){
                   $this->control_del_ads($adsArray[$i]['link_ads'], $adsArray[$i]['id'],$data_user);
                }
                */

                     
                    $data = $this->get_captha($data_user);

                    
                    $adsArray[$i]['key'] = $data['key'];        
                    $adsArray[$i][$data['input']] = $data['code'];
                    //$adsArray[$i]['phpsid'] = $data_user['PHPSESSID'];
                    $adsArray[$i]['userls'] = $data_user['userls'];
                    

                    // загружаем картинки
                    $imgTmpDir = $_SERVER['DOCUMENT_ROOT'].'/publish/images/user'.$adsArray[$i]['userId'].'/'.$adsArray[$i]['id'].'/';
                    $UploadFile = $this->get_files($imgTmpDir);
                       
                    if(count($UploadFile) > 0){
                        $uploadedImages = $this->sFileMove($UploadFile);
                        
                        // добавляем картинки в POST
                       for($ig = 0; $ig < count($uploadedImages); $ig++){
                          $img = '';
                          if(isset($uploadedImages[$ig])){
                               $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $uploadedImages[$ig]);
                               if($ext=='jpg')$ext = 'jpeg';
                               $img = '@'.$imgTmpDir.$uploadedImages[$ig].";type=image/$ext";
                          }
                           $adsArray[$i]['userfile['.$ig.']'] = $img;
                       }
                    }

                    sleep(30);

                    $pError = $this->post($adsArray[$i],$data_user);

                    //echo 'Число повториний '.$r.'<br>';
                    // echo 'Публикация объявления - '.$pError['error'];
                    //if(file_exists($this->cookie_path)) unlink($this->cookie_path);
    
                  
            
            }while($pError['public'] == false and $r < 2);
           
            // записываем в базу (если удача)
            if($pError['public'] == true and $r <= 2){
                /*
                if($adsArray[$i]['link_del']){
                    $this->deleteAds($adsArray[$i]['link_del'],$adsArray[$i]['id']);
                }
                */
                    // если все закончилось удачей, то удаляем секретный ключ
                    if($adsArray[$i]['paid_code_id']){
                      $delbuyid = $adsArray[$i]['paid_code_id'];
                    }else{
                      $delbuyid  = 0;
                    }

                $this->saveDbGood($pError,$delbuyid);
                $this->getMessage('serega569256@bk.ru','<b>Опубликованно</b> - '.$data_user['ip'].' -- '.$adsArray[$i]['id']);
                // получаем количество и вычитаем 1
                $this->residueAds($adsArray[$i]['userId']);
                unset($adsArray);
                // если не получилось опубликовать
            }else if($pError['public'] == false and $r == 2){
                
                $notPublished = array();
                
                $notPublished['idAds'] = $adsArray[$i]['id'];
                $notPublished['userid'] = $adsArray[$i]['userId'];

                $this->saveDbFail($notPublished);

                $this->getMessage('serega569256@bk.ru','Неудолось опубликовать - '.$adsArray[$i]['id']);
                unset($adsArray);
            }

                  
        }

    }

    // сохранияем данные если удача
    public function saveDbGood($data = array(),$delbuyId = 0){
        $check = $this->mysql->Select('SELECT * FROM  table_public_bazarpnz WHERE idAds = '.$data['idAds'].'');
        if(count($check) > 0){
            $this->mysql->Update('table_public_bazarpnz',$data, "idAds = ".$data['idAds']);
        }else{
            $this->mysql->Insert('table_public_bazarpnz', $data);
        }

        // удаляем ключ платного доступа т.к. он уже использован и больше не нужен
        if($delbuyId > 0){
           $this->mysql->Delete('table_codes_of_public', "id = ".$delbuyId);
        }



    }
    public function saveDbFail($data = array()){
        // записываем неудачи в базу
        $this->mysql->Insert('table_not_published', $data);
        /*
        $check = $this->mysql->Select('SELECT id FROM  table_public_bazarpnz WHERE idAds = '.$data['idAds'].'');
        $id = $check[0][0];
        if(!$id){
            $this->mysql->Insert('table_public_bazarpnz', $data);
        }
        */

    }
    // удаляем данные
    public function deleteDb($id){
        $this->mysql->Delete('table_public_bazarpnz', "idAds = $id");
    }
    // выводим узер userls
    public function get_userls($contact_id){
       $check = $this->mysql->Select('SELECT * FROM  table_userls WHERE contact_id = '.$contact_id.'');
       return $check;
    }
    // если еще нет userls добавляем в базу
    public function insert_userls($contact_id, $userls){
        $data['contact_id'] = $contact_id;
        $data['userls'] = $userls;
        $this->mysql->Insert('table_userls', $data);
    }
    // рандомный выбор браузера
    public function rand_browser_and_ip($contact_id){

       $max_id_browser = $this->mysql->Select('SELECT id FROM table_user_browser WHERE contact_id = 0');
       $max_id_ip = $this->mysql->Select('SELECT id FROM table_user_ip WHERE contact_id = 0 and ban = 0');

        foreach ($max_id_ip as $key => $value) {
           $max_id[] =  $value[0];
        }

        //print_r($max_id);
       //$max_id_browser = $this->mysql->Select('SELECT MAX(id) FROM table_user_browser WHERE contact_id = 0');
       //$max_id_ip = $this->mysql->Select('SELECT MAX(id) FROM table_user_ip WHERE contact_id = 0');

       
       $random_id_browser = mt_rand(1, $max_id_browser[0][0]);
       $random_id_ip = $max_id[rand(0,(count($max_id)-1))];

       $data_browser = $this->mysql->Select('SELECT browser FROM  table_user_browser WHERE id = '.$random_id_browser.' ORDER BY id LIMIT 1'); 
       $data_ip = $this->mysql->Select('SELECT ip FROM  table_user_ip WHERE id = '.$random_id_ip.' ORDER BY id LIMIT 1'); 

       $update['contact_id'] = trim($contact_id); // общий update для двух запросов

       // забиваем браузер за пользователем (номером телефона пользователя)
       $this->mysql->Update('table_user_browser',$update, "id = ".$random_id_browser);
       // ip
       $this->mysql->Update('table_user_ip',$update, "id = ".$random_id_ip);

       $res = array();
       $res['browser'] = $data_browser[0][0];
       $res['ip']      = $data_ip[0][0];
       
       return $res;
    }


}

/////////////////////////////////////////////////  класс закрыт //////////////////////////////////////////////////////
?>