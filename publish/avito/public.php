<?
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');

ini_set("display_errors",1);
error_reporting(E_ALL);
set_time_limit(0);

include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/phpQuery.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/antigate.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/rucaptcha.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/application.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');

class public_avito extends app{

    private $login;
    private $password;

    function __construct($login,$password){
       $nameCookie = rand(10000,20000);
	   $this->login = $login;
	   $this->password = $password;
       $this->cookie_path = dirname(__FILE__).'/tmp/cookie/'.$nameCookie.'.txt';
       $connection = new Connection();
       $this->mysql = $connection->config();
    }
    
    
	// авторизация
	public function authorize(){

		$login_data = Array(
            'login' => $this->login,
            'password' => $this->password,
            'next' => '/profile',

        );

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://m.avito.ru/profile/login');
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->random_user_agent());
        // подключаем прокси
        curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1); 
        curl_setopt($curl, CURLOPT_PROXY, $this->random_proxy());
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
        
        curl_setopt($curl, CURLOPT_COOKIESESSION, true);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read 
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($login_data));
        curl_setopt($curl, CURLOPT_REFERER, 'https://m.avito.ru/');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Host: m.avito.ru'));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

        $result = curl_exec($curl);

        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Получаем HTTP-код

        if($http_code == 200){
            $login = 1;
        }else{
            $login = 0;
        }

        curl_close($curl);

        //echo $login.'=================Login';

    return $login;
	}

    public function deleteAds($dataAds){

        for($i = 0; $i < count($dataAds); $i++){

            $this->authorize();

            $ch = curl_init(trim($dataAds[$i]['deliteLink']));

            //echo trim($dataAds[$i]['deliteLink']);

            curl_setopt($ch, CURLOPT_USERAGENT, $this->random_user_agent());
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
            curl_setopt($ch, CURLOPT_PROXY, $this->random_proxy());
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_FAILONERROR, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);

            curl_exec($ch);

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код

            if($http_code == 200) {
                $idAds = $dataAds[$i]['id'];  // id  объявления
                $this->deleteDb($idAds);      // записываем данные в базу данных
                $this->startTimeout(5);
            }
            curl_close($ch);
        }
    }

    public function get_capcha(){

        //$this->authorize();

        $data = array();

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://m.avito.ru/add');
        curl_setopt($curl, CURLOPT_HEADER, 1);
        
        // подключаем прокси
        curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1); 
        curl_setopt($curl, CURLOPT_PROXY, $this->random_proxy());
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);

        curl_setopt($curl, CURLOPT_USERAGENT,  $this->random_user_agent());

        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write
        curl_setopt($curl, CURLOPT_REFERER, 'https://m.avito.ru');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLINFO_HEADER_OUT, 1);

        $result = curl_exec($curl);

        $document = phpQuery::newDocumentHTML($result);
        $captcha_src = $document->find('.captcha-image img')->attr('src'); // ссылка на картинку капчи

        // получаем token
        $data['name_token'] = $document->find('.control-self-hidden:eq(2)')->attr('name');
        $data['value_token'] = $document->find('.control-self-hidden:eq(2)')->attr('value');

        curl_close($curl);

        $ch = curl_init();

        $rcn = rand(1,1000);
        $captcha_file_name = dirname(__FILE__).'/tmp/captha/captcha_'.$rcn.'.jpg';// новое имя файла

        curl_setopt($ch, CURLOPT_URL,'https://m.avito.ru'.$captcha_src);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->random_user_agent());

        // подключаем прокси
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($ch, CURLOPT_PROXY, $this->random_proxy());
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FAILONERROR, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE,false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write   
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $img = curl_exec($ch);

        sleep(5);// ждем пока получим страницу полностью

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код
        
        ($http_code == 200) ? $accessImg = true : $accessImg = false;

        // если получаем доступ к картинке, то сохраняем ее
        if($accessImg == true){
            $fp = fopen($captcha_file_name,'w');
            fwrite($fp, $img);
            fclose($fp); 

            //$antigate_api_key = 'e8c4778028b59dc51924cf1edb1f6cc1';
            //$code = recognize($captcha_file_name,$antigate_api_key,true,"antigate.com",5,120,0,0,0,0,0,1);
            $data['code'] = recognize($captcha_file_name,"f5a8a7302e5950256950277b4f6b580c",true, "rucaptcha.com");

            if(!$data['code']){
                $this->getMessage('aligoweb@ya.ru','Не удалось распознать капчу');
            }
            //$data['code'] = 0;

        }
        if(file_exists($captcha_file_name)) unlink($captcha_file_name);

            curl_close($ch);
        //echo $code.'============================== капча';

    return $data;

    }

    public function uploadImages($userId,$idImage){

        $imgTmpDir = $_SERVER['DOCUMENT_ROOT'].'/publish/images/user'.$userId.'/'.$idImage.'/';

        $uploadedImages = $this->get_files($imgTmpDir);


        for($i=0;$i<count($uploadedImages);$i++){
            $img = '';
            if(isset($uploadedImages[$i])){

                $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $uploadedImages[$i]);
                if($ext=='jpg')$ext = 'jpeg';
                $img = '@'.$imgTmpDir.$uploadedImages[$i].";type=image/$ext";
                $postVars = array('image'=>$img);

                $curl = curl_init('https://m.avito.ru/add/image');

                //curl_setopt($curl, CURLOPT_URL, 'https://m.avito.ru/add/image');
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postVars);
                curl_setopt($curl, CURLOPT_USERAGENT, $this->random_user_agent());
                // подключаем прокси
                curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1);
                curl_setopt($curl, CURLOPT_PROXY, $this->random_proxy());
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);

                curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read
                curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write
                curl_setopt($curl, CURLOPT_REFERER, 'https://m.avito.ru/');
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_ENCODING,"gzip, deflate");

                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
                //curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
                curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl, CURLOPT_TIMEOUT, 120);
                //curl_setopt($curl, CURLOPT_UPLOAD, 1);

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                $result = curl_exec($curl);

                preg_match("/\"id\":([0-9]+)/", $result, $matches);

                if(count($matches)==2)$uiarr[] = $matches[1];
                //echo "--------------".$result."-------------------";
                $this->startTimeout(2); // делаем паузу
                curl_close($curl);

            }
        }

        return $uiarr;

    }


    public function ads_post($post = array()){

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://m.avito.ru/add');
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->random_user_agent());
        // подключаем прокси
        curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1); 
        curl_setopt($curl, CURLOPT_PROXY, $this->random_proxy());
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read 
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write
        curl_setopt($curl, CURLOPT_REFERER, 'https://m.avito.ru/add');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_ENCODING,"gzip, deflate");

        $res = curl_exec($curl);

        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Получаем HTTP-код

        if($http_code == 200) {

            $document = phpQuery::newDocumentHTML($res);
            $errorDocument = $document->find('.message-error')->text(); // ссылка на картинку капчи
              if($this->find_in_str($errorDocument,'подтверждения')){
                 $error = 0;
              }else{
                 $error = 1;
              }
            //echo "--Ошибка--".$error.'--Ошибка-<br>';

        }else{
            $error = 0;
        }
        curl_close($curl);
    return $error;     
    }

    public function postEnd($post = array()){

        $returnArray = array();  // в этом массиве вернем итоговые данные
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://m.avito.ru/add/service');
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->random_user_agent());
        // подключаем прокси
        curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1); 
        curl_setopt($curl, CURLOPT_PROXY, $this->random_proxy());
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read 
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write
        curl_setopt($curl, CURLOPT_REFERER, 'https://m.avito.ru/add');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $res = curl_exec($curl);
        //echo $res;

        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Получаем HTTP-код
        //echo 'html header'.$http_code.'<br>';

        if($http_code == 200){
            $document = phpQuery::newDocumentHTML($res);
            $linkAds = $document->find('a.link')->attr('href');
        }

        // данный которые уже заданны
        $returnArray['idAds']      = $post['idAds'];
        $returnArray['userId']     = $post['userId'];
        $returnArray['datePublic'] = date('Y-m-d H:i:s');

        //echo 'id объявления'.$post['idAds'].'<br>';
        //echo 'id юзера'.$post['userId'].'<br>';


        if(strlen($linkAds) > 2){
            // забераем id объявления
            $linkId = preg_replace("/[^0-9]/", '', $linkAds);
            // формируем ссылки на объявление
            $deliteLink = $linkId;

            $returnArray['public']      = 1;
            $returnArray['link']        = 'https://www.avito.ru/'.$linkId;
            $returnArray['deliteLink']  = 'https://www.avito.ru/profile/items/old?item_id[]='.$deliteLink.'&remove';
        }else{
            $returnArray['public'] = 0;
            $returnArray['link']   = '';
            $returnArray['deliteLink']    = '';
        }
        curl_close($curl);
    return $returnArray;
    }


    // инициализация приложения 
    public function main($adsArray = array()){
       // данные для подтверждения бесплатного размещения
       $BaseData = array();
       $login   = 0;
       $code    = 0;
       $stepOne = 0;
       $stepTwo = 0;

       //print_r($adsArray);

       for($i = 0; $i < count($adsArray); $i++){

           $r = 0;  // инициализация счетчика
           do{
               $postVars2 = array(
                   'service'=>0,
                   'idAds'=>$adsArray[$i]['id'],
                   'userId'=>$adsArray[$i]['userId'],
               );
               
               $r++;
               //echo "Количество повторений ".$r."<br>";

               $login = $this->authorize();

               $capchaData = $this->get_capcha();

               if(isset($capchaData['code'])){

                   $error = 1;

                   $adsArray[$i]['captcha'] = $capchaData['code'];
                   $adsArray[$i][$capchaData['name_token']] = $capchaData['value_token'];
                   //$adsArray[$i]['description'] = $this->sinonimazer($adsArray[$i]['description']);

                   // если фотки были выбраны и загрузиоись, добавляем их к нашему массиву данных
                   // если выбран параметр куплю фотки не нужны

                   if($adsArray[$i]['noImages'] != 1){

                      $images = $this->uploadImages($adsArray[$i]['userId'],$adsArray[$i]['id']);

                      if(!empty($images)){
                         foreach ($images as $key => $value) {
                           $adsArray[$i]['images['.$key.']'] = $value;
                         }
                      }
                   }

                   $stepOne = $this->ads_post($adsArray[$i]); // 1 шаг

                   if(isset($stepOne)){
                      $stepTwo = $this->postEnd($postVars2);  // 2 шаг
                      // Удаляем наши куки
                      if(file_exists($this->cookie_path)) unlink($this->cookie_path);
                      // если публикация прошла успешно, формируем массив данных для записи в базу
                      if($stepTwo['public'] == true){

                          $BaseData['status'] = 1;                // статус размещенного объявления
                          $BaseData['linkId'] = $stepTwo['link']; // id опубликованного объявления
                      }
                   }

               }else{
                   $error = 0;
               }
               //echo 'Контрольный вывод<br>';
               //echo '$code '.$error.'<br>';
               //echo '$stepOne '.$stepOne.'<br>';
               //echo '$stepTwo '.$stepTwo['public'].'<br>';
              // echo '$login '.$login.'<br>';
               //$this->startTimeout(20);
               sleep(30);

           }while($stepTwo['public'] == false AND $r < 1); // здесь мы сообщаем скрипту что попыток размещения одного объявления не должно превышать 10

                 // записываем в базу (если удача)
                 if($stepTwo['public'] == true and $r <= 1){
                    $this->saveDb($stepTwo);
                    // меняем описание, включаем синонимайзер
                    $desc['id'] = $adsArray[$i]['id'];
                    $desc['description'] = $this->sinonimazer($adsArray[$i]['description']);
                    $this->updateDes($desc);

                     //print_r($desc);
                 // если не получилось опубликовать
                 }else if($stepTwo['public'] == false and $r == 1){
                    $this->saveDb($stepTwo);
                 }
          // print_r($stepTwo);

       }
    }

    // сохранияем данные
    public function saveDb($data = array()){

        $check = $this->mysql->Select('SELECT * FROM  table_public_avito WHERE idAds = '.$data['idAds'].'');
        if(count($check) > 0){
            $this->mysql->Update('table_public_avito',$data, "idAds = ".$data['idAds']);
        }else{
            $this->mysql->Insert('table_public_avito', $data);
        }

    }
    // удаляем данные
    public function deleteDb($id){
        $this->mysql->Delete('table_public_avito', "idAds = $id");
    }
    // обновляем описание
    public function updateDes($data = array()){
        $this->mysql->Update('table_publication_object',$data, "id = ".$data['id']);
    }


}

?>