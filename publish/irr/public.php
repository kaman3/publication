<?
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/phpQuery.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/antigate.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/rucaptcha.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/application.php');

ini_set("display_errors",1);
error_reporting(E_ALL);
set_time_limit(0);

class public_irr extends app{

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
          //'address_region' => 'russia/penzenskaya-obl/',
          'region' => 'russia/penzenskaya-obl/penza-gorod/',
          'address_city' => 'russia/penzenskaya-obl/penza-gorod/',
          'category' => '',

        );

        $curl = curl_init();

        $url = 'http://penza.irr.ru/advertSubmission/step1/';

        $parse_url = parse_url($url);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt($curl, CURLOPT_USERAGENT, $this->random_user_agent());
        // подключаем прокси
        curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($curl, CURLOPT_PROXY, $this->random_proxy());
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);

        //curl_setopt($curl, CURLOPT_COOKIESESSION, true);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write

        //curl_setopt($curl, CURLOPT_POSTFIELDS, $login_data);
        curl_setopt($curl, CURLOPT_REFERER, 'http://irr.ru/');

        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER,  array('Host: '.$parse_url['host']));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

        $result = curl_exec($curl);

        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Получаем HTTP-код

        ($http_code == 200) ? $login = 1 : $login = 0;

        print_r($result);
        curl_close($curl);

    }


    public function main(){

        $this->authorize();


        $curl = curl_init();

        $url = 'http://irr.ru/account/items';

        $parse_url = parse_url($url);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->random_user_agent());
        // подключаем прокси
        curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($curl, CURLOPT_PROXY, $this->random_proxy());
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);

        curl_setopt($curl, CURLOPT_COOKIESESSION, true);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_path); // file to read
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookie_path); // file to write

        //curl_setopt($curl, CURLOPT_POSTFIELDS, $login_data);
        curl_setopt($curl, CURLOPT_REFERER, 'http://irr.ru/');

        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER,  array('Host: '.$parse_url['host']));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

        $result = curl_exec($curl);

        print_r($result);


    }

}
?>