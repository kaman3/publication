<?

/*
$k_y  = 0;     //отступ сверху
$k_y2 = 8;     //отступ снизу
$w    = 12;    //Ширина цифр
$h    = 18;    // высота цифр
$m_err= 245;    //Допустипое отклонение
*/
$k_y  = 0;     //отступ сверху
$k_y2 = 8;     //отступ снизу
$w    = 12;    //Ширина цифр
$h    = 18;    // высота цифр
$m_err= 50;    //Допустипое отклонение
//$c = require(dirname(__FILE__) .'/numbers.php');
//$c = array();

for($b = 0; $b <=9; $b++){
  
  $elem = 'http://rlpnz.ru/test/img/'.$b.'_tmp.jpg';


  $ch = curl_init(trim($elem));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
  curl_setopt($ch, CURLOPT_VERBOSE, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);


  $result2 = curl_exec($ch);

  $im2 = @imagecreatefromstring($result2);
  if ($im2 === false) {
      throw new Exception ('Image is corrupted');
  }
  
  $r = array();
 
  list($img_width, $img_height) = getimagesize($elem);
  for ($x=0; $x < $img_width; $x++) {
      for($y=0;$y<$img_height;$y++) { 
         for($x=$i;$x<$w+$i;$x++) {
              $color_index = imagecolorat($im2,$x,$y);
              $r[]    = imagecolorsforindex($im2, $color_index);
         }
                 
     }
     
  }
  $c[$b] = $r; 

}

//file_put_contents(dirname(__FILE__) .'/array.txt',serialize($d));

$file_pointer = $_SERVER['DOCUMENT_ROOT']."/test/array.txt";
if (!$file_handle = fopen($file_pointer, 'wb')) exit;
flock($file_handle, LOCK_EX);
if (fwrite($file_handle, serialize($c)) === false) exit;
flock($file_handle, LOCK_UN);
fclose($file_handle);


if ( !$file_handle = fopen($file_pointer, 'rb') ) exit;
$d = unserialize( fread($file_handle, filesize($file_pointer)) );
fclose($file_handle);


//$c = array_reverse($c);
//print_r($c[0]);
//echo count($c);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

  $original = 'http://rlpnz.ru/test/44.jpg';


  $ch = curl_init(trim($original));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);               // Результат нам нужно вернуть в переменную, а не на экран
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);               // Переходить по редиректам
  curl_setopt($ch, CURLOPT_VERBOSE, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

  $result = curl_exec($ch);

  $im = @imagecreatefromstring($result);
  if ($im === false) {
      throw new Exception ('Image is corrupted');
  } else {
  

  list($width, $height) = getimagesize($original);
  //echo $width.' '.$height;
  $c2 = array();
  for ($i=0; $i < $width-$w; $i++) {
      for($y=0;$y<$height-$k_y-$k_y2;$y++) {
          for($x=$i;$x<$w+$i;$x++) {
              $color_index2 = imagecolorat($im,$x,$y+$k_y);
              $c2[$i][]    = imagecolorsforindex($im, $color_index2);
          }
      }
  }

  //print_r($c2[5]);

  //echo $c2[0][0]['red'];//echo $c2[0][0]['red'];
  //print_r($c2[0]);

  //print_r($c2[9]);
    //echo count($c2).'<br>';
    $phone = array();
   
    $errors = array();
    foreach ($c2 as $key => $value) {
        $errors[$key] = 0;

        foreach ($d as $key2 => $value2) {

            $err = 0;
            for ($i=0; $i < count($value2); $i++) {
                $var = $value[$i];
                $var2 = $value2[$i];
                if(abs($var['red']-$var2['red'])>$m_err) {
                   $err++;
                }
            }
            $errors[$key] +=$err;
            if($err < 5) $phone[] = $key2;
        }
    }
    //print_r($phone);

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

    print_r($itemphone);

}





?>