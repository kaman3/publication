<?
        $data = array();

        $ch = curl_init("http://bazarpnz.ru/");

        curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (X11; Linux i686; U; fr) Presto/2.7.62 Version/11.01");
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($ch, CURLOPT_PROXY, '188.230.82.101:8080');
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //($ch, CURLOPT_PROXYUSERPWD, $this->login_proxy.':'.$this->password_proxy);

        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");
        curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);           // Передаем POST-параметры
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
        //curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_path);  // file to read
        //curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_path);   // file to write
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

        $result2 = curl_exec($ch);

        print_r($result2 );
?>