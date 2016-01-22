<?php

header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/phpQuery.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/antigate.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/rucaptcha.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/application.php');

ini_set("display_errors",1);
error_reporting(E_ALL);
set_time_limit(0);

echo '<link rel="stylesheet" type="text/css" href="/publish/resources/css/style.css">';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// код публикатора
/**
 * @property mixed captcha_file_name
 */
class public_bazarpnz extends app{

    function __construct(){
        $nameCookie = rand(10000,20000);
        $this->cookie_path = dirname(__FILE__).'/tmp/cookie/'.$nameCookie.'.txt';
        $connection = new Connection();
        $this->mysql = $connection->config();
    }

    // удаляем уже размещенные объявления
    public function deleteAds($link,$id){

        //for($i = 0; $i < count($dataAds); $i++){

            $postVars = array(
                'delete' => mb_convert_encoding('Удалить объявление!', "windows-1251", "utf-8"),
            );

            $ch = curl_init(trim($link));

            curl_setopt($ch, CURLOPT_USERAGENT, $this->random_user_agent());
            //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
            //curl_setopt($ch, CURLOPT_PROXY, $this->random_proxy());
            //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:9050');
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");
            curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);           // Передаем POST-параметры
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

            $result = curl_exec($ch);

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код

            if($http_code == 200) {
                $idAds = $id;  // id  объявления
                $this->deleteDb($idAds);      // записываем данные в базу данных
                $this->startTimeout(5);
            }
    }
    //}


    public function get_session($var){

        $dataCookie = array();

        preg_match('#PHPSESSID=(.*);#',$var,$matches);

        $dataCookie['session'] = str_replace("&rn=' + Math.random()",'',$matches[1]);
        if($dataCookie['session']){
           return $dataCookie;
        }else{
           $this->get_captha();
        }

    }

    public function get_captha($proxi = 'ru1.proxik.net:80'){

        $data = array();

        $rcn = md5(rand(1,10000).time());
        $this->captcha_file_name = dirname(__FILE__).'/tmp/captcha/captcha_'.$rcn.'.jpg';// новое имя файла

        $ch = curl_init('http://bazarpnz.ru/add.php?main');
        curl_setopt($ch, CURLOPT_USERAGENT, $this->random_user_agent());

        //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        //curl_setopt($ch, CURLOPT_PROXY, $proxi);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:9050');
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 'http://bazarpnz.ru/add.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write


        $result = curl_exec($ch);

        $document = phpQuery::newDocumentHTML($result);
        $input = $document->find('#step6_go table tr td label')->attr('for'); // name input для пля код, сюда в дальнейшем вставляем капчу
        $key =   $document->find('[name=key]')->attr('value');                // ссылка на картинку капчи
        $session = $document->find('#step6_go table tr td small a')->attr('onclick');
        // берем сессию

        $dataCook = $this->get_session($session);
        //$this->startTimeout(5);

        curl_setopt($ch, CURLOPT_URL,"http://bazarpnz.ru/code.php?PHPSESSID=".$dataCook['session']."&rn=0.02694353787228465"); // задаем адрес обработчика формы
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        $img = curl_exec($ch); // Скачиваем картинку

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код

        if($http_code == 200) {
            $fp = fopen($this->captcha_file_name,'w');
            fwrite($fp, $img);
            fclose($fp);
            /*
           $antigate_api_key = 'e8c4778028b59dc51924cf1edb1f6cc1';
           $code = recognize($this->captcha_file_name,$antigate_api_key,true,"antigate.com",10,120,0,0,1,4,6,0);
           */

           // rucaptha
           $code = recognize($this->captcha_file_name,"f5a8a7302e5950256950277b4f6b580c",true, "rucaptcha.com");

           if(!$code){
               $this->getMessage('aligoweb@ya.ru','Не удалось распознать капчу');
           }

        }

        // удаляем капчу
        if(file_exists($this->captcha_file_name)) unlink($this->captcha_file_name);

        /** @var $code TYPE_NAME */
        /** @var $dataCook TYPE_NAME */

        $data['code']  = $code;
        $data['input'] = $input;
        $data['key']   = $key;

        //echo $data['input'].'<hr>';

        curl_close($ch);

        return $data;
    }

    public function post($postVars = array(),$proxi = 'ru1.proxik.net:80'){

        $data = array();

        $ch = curl_init("http://bazarpnz.ru/add.php?main");

        curl_setopt($ch, CURLOPT_USERAGENT, $this->random_user_agent());
        //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        //curl_setopt($ch, CURLOPT_PROXY, $proxi);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:9050');
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");
        curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);           // Передаем POST-параметры
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_path);  // file to read
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_path);   // file to write
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

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
    public function main($adsArray = array()){

        $data = array();

        for($i = 0; $i < count($adsArray); $i++){

            $r = 0;

            do{
                $r++;

                $this->get_proxi();

                $data = $this->get_captha($proxi);

                $adsArray[$i]['key'] = $data['key'];
                //$adsArray[$i]['userls'] = $data['user'];
                $adsArray[$i][$data['input']] = $data['code'];

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

                $this->startTimeout(rand(50,60));

                $pError = $this->post($adsArray[$i],$proxi);

                echo 'Число повториний '.$r.'<br>';
                echo 'Публикация объявления - '.$pError['error'];
                if(file_exists($this->cookie_path)) unlink($this->cookie_path);

            }while($pError['public'] == false and $r < 3);
                 // записываем в базу (если удача)
                 if($pError['public'] == true and $r <= 3){
                    if($adsArray[$i]['link_del']){
                       $this->deleteAds($adsArray[$i]['link_del'],$adsArray[$i]['id']);
                    }
                    $this->saveDbGood($pError);
                    $this->getMessage('aligoweb@ya.ru','Опубликованно - '.$adsArray[$i]['id']);
                    // получаем количество и вычитаем 1
                    $this->residueAds($adsArray[$i]['userId']);
                    // если не получилось опубликовать
                 }else if($pError['public'] == false and $r == 3){
                    $this->saveDbFail($pError);
                    $this->getMessage('aligoweb@ya.ru','Неудолось опубликовать - '.$adsArray[$i]['id']);
                 }
        }

    }

    // сохранияем данные если удача
    public function saveDbGood($data = array()){
        $check = $this->mysql->Select('SELECT * FROM  table_public_bazarpnz WHERE idAds = '.$data['idAds'].'');
             if(count($check) > 0){
                $this->mysql->Update('table_public_bazarpnz',$data, "idAds = ".$data['idAds']);
             }else{
                $this->mysql->Insert('table_public_bazarpnz', $data);
             }

    }
    public function saveDbFail($data = array()){
        $check = $this->mysql->Select('SELECT id FROM  table_public_bazarpnz WHERE idAds = '.$data['idAds'].'');
        $id = $check[0][0];
        if(!$id){
            $this->mysql->Insert('table_public_bazarpnz', $data);
        }

    }
    // удаляем данные
    public function deleteDb($id){
        $this->mysql->Delete('table_public_bazarpnz', "idAds = $id");
    }

}

/////////////////////////////////////////////////  класс закрыт //////////////////////////////////////////////////////
