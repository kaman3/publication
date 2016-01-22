<?
function get_phone(){
	    $phohes_array = array();
        /*
        $itemphone = '';

        $id = $data['adsenses_id'];

        $key = $document->find('#allphones')->attr('value');

        $phones = $this->decode($key);

        $imgdoc = phpQuery::newDocumentHTML($phones);

        $phones = $imgdoc->find('img');
        $phohes_array = array();
        foreach ($phones as $key => $value) {
            $phohes_array[] = pq($value)->attr('src');
        }
        */
        $phohes_array[] = 'http://rlpnz.ru/test/34.jpg';
        $itemphone = array();

        if(!empty($phohes_array)) {
            $c = require(dirname(__FILE__) .'/numbers.php');

           // print_r($c);

            $k_y  = 3;     //отступ сверху
            $k_y2 = 2;     //отступ снизу
            $w    = 7;    //Ширина цифр
            $h    = 10;    // высота цифр
            $m_err= 50;    //Допустипое отклонение

            foreach ($phohes_array as $key => $value) {

                $ch = curl_init(trim($value));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

                $result = curl_exec($ch);



                $im = @imagecreatefromstring($result);
                if ($im === false) {
                    throw new Exception ('Image is corrupted');
                }
                else {
                    list($img_width, $img_height) = getimagesize($value);
                    //echo $img_width.' '.$img_height;
                    $c2 = array();
                    for ($i=0; $i < $img_width-$w; $i++) {
                        for($y=0;$y<$img_height-$k_y-$k_y2;$y++) {
                            for($x=$i;$x<$w+$i;$x++) {
                              $color_index = imagecolorat($im,$x,$y+$k_y);
                              $c2[$i][]    = imagecolorsforindex($im, $color_index);
                            }
                        }
                    }
                    $phone = array();
                    $errors = array();
                    foreach ($c2 as $key => $value) {
                        $errors[$key] = 0;
                        foreach ($c as $key2 => $value2) {

                            $err = 0;
                            for ($i=0; $i < count($value2); $i++) {
                                $var = $value[$i];
                                $var2 = $value2[$i];
                                if(abs($var['red']-$var2['red'])>$m_err) {
                                   $err++;
                                   ///echo abs($var['red']-$var2['red']).'<br>';
                                }
                            }
                            $errors[$key] +=$err;
                            if($err < 5) $phone[] = $key2;
                        }
                    }

                    if(!empty($phone)) {
                        $phone = implode('', $phone);

                        if(strlen($phone) > 11 && strlen($phone)%2==0) {
                            $phone1 = substr($phone, 0,strlen($phone)/2);
                            $phone2 = substr($phone, strlen($phone)/2);
                            $itemphone[] = $phone1;
                            $itemphone[] = $phone2;
                        }else {
                            $itemphone[] = $phone;
                        }
                    }

                    imagedestroy($im);


                }
            }
        }

       // return ((empty($itemphone))?false:$itemphone[0]);
    }

    echo get_phone();
?>