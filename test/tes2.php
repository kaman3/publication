<?
          $ch = curl_init('http://vz67014.eurodir.ru/publish/index.php?parametrs=112:746');
          curl_setopt($ch, CURLOPT_REFERER, "http://bazarpnz.ru/add.php?main");
          curl_setopt($ch, CURLOPT_POST, 1);                         // Указываем, что нам нужно отправить POST-запрос
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_VERBOSE, 1);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

          $result2 = curl_exec($ch);

          echo iconv('windows-1251','utf-8',$result2);
?>