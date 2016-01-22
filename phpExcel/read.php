<?
include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/config.php');     // настройки базы данных
require_once $_SERVER['DOCUMENT_ROOT'].'/phpExcel/PHPExcel.php'; // Подключаем библиотеку PHPExcel

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

// определяем город
 function data_city_region($object){
      global $mysql;
      $data = array_shift($mysql->Select('SELECT name FROM table_city_region WHERE id = '.trim($object)));
 return $data[0];
 }
 // определяем район
 function data_city_district($object){
      global $mysql;
      $data = array_shift($mysql->Select('SELECT name FROM table_city_districts WHERE id = '.trim($object)));
 return $data[0];
 }
 // определяем микрорайон
 function data_city_microdistrict($object){
      global $mysql;
      $data = array_shift($mysql->Select('SELECT name FROM table_city_districts WHERE id = '.trim($object)));
 return $data[0];
 }
 // определяем тип сделки
 function transaction($object){
      global $mysql;
      $data = array_shift($mysql->Select('SELECT name FROM table_type_transaction WHERE id = '.trim($object)));
 return $data[0];
 }
 // определяем тип дома
 function type_house($object){
      global $mysql;
      $data = array_shift($mysql->Select('SELECT name FROM table_house_types WHERE id = '.trim($object)));
 return $data[0];
 }
 // агенство или нет
  function agent($object){
           ($object == 1) ? $data = 'частное' : $data = 'агенство';
  return $data;
  }

// комментарии
function comments($idAds,$user){

    global $mysql;
    $data = '';
    $comments = $mysql->Select('SELECT text FROM table_comments WHERE idAds = '.$idAds.' AND userId = '.$user);
    if(count($comments)){
        foreach($comments as $key => $value){
          $key = $key + 1;
          $data .= '('.$key.' комментарий ) > '.$value[0].'  ';
        }
    }
    return $data;
}

  $phpexcel = new PHPExcel(); // Создаём объект PHPExcel
  /* Каждый раз делаем активной 1-ю страницу и получаем её, потом записываем в неё данные */
  $page = $phpexcel->setActiveSheetIndex(0); // Делаем активной первую страницу и получаем её


if(trim($_GET['act']) == 1){
   $user = trim($_GET['user']);
   $cat = trim($_GET['cat']);
   $seller = trim($_GET['seller']);

   $notenook = $mysql->Select("SELECT idAds FROM table_notebook WHERE userId = ".$user." and `idCat` = ".$cat);

    foreach ($notenook as $key => $value) {
        $n[$key] = mb_strtolower($value[0]);
    }
   $c = implode(",",$n);
   $exel = $mysql->Select('SELECT * FROM table_object WHERE id IN ('.$c.')');


}else{

   $start = trim($_GET['arr']);
   $start = substr($start,0,-1);


   $exel = $mysql->Select('SELECT * FROM table_object WHERE id IN ('.$start.')');
}

   // стили для заголовков
   $arHeadStyle = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '0d760d'),
        'size'  => 10,
        'name'  => 'Verdana'
    ));

       for($i = 0; $i <= 1; $i++){
              // применяем стили
              $page->getStyle('A'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('B'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('C'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('D'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('E'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('F'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('G'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('H'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('I'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('J'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('K'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('L'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('M'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('N'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('O'.$i)->applyFromArray($arHeadStyle);
              $page->getStyle('P'.$i)->applyFromArray($arHeadStyle);

              if($seller == 1){
                 $page->getStyle('Q'.$i)->applyFromArray($arHeadStyle);
                 $page->getStyle('R'.$i)->applyFromArray($arHeadStyle);
              }
              
              // пишем заголовки
	       	  $page->setCellValue("A".$i, "город");                // город
	          $page->setCellValue("B".$i, "район");                // район
	          $page->setCellValue("C".$i, "микрорайон");           // микрорайон
	          $page->setCellValue("D".$i, "заголовок");            // заголовок
	          $page->setCellValue("E".$i, "улица");                // улица
    		  $page->setCellValue("F".$i, "описание");             // описание
    		  $page->setCellValue("G".$i, "тип сделки");           // тип сделки
    		  $page->setCellValue("H".$i, "площадь жилая");        // площадь жилая
    		  $page->setCellValue("I".$i, "площадь общая");        // площадь общая
    		  $page->setCellValue("J".$i, "этаж");                 // этаж
    		  $page->setCellValue("K".$i, "этажность");            // этажность
    		  $page->setCellValue("L".$i, "тип дома");             // тип дома
    		  $page->setCellValue("M".$i, "количество комнат");    // количество комнат
              $page->setCellValue("N".$i, "цена");
   			  $page->setCellValue("O".$i, "имя продовца");         // имя продовца
	          $page->setCellValue("P".$i, "агент или нет");        // агент или нет
              if($seller == 1){
                 $page->setCellValue("Q".$i, "телефон");              // телефон
                 $page->setCellValue("R".$i, "Комментарий");
              }

       }
       
       foreach ($exel as $key => $value) {
          // начинаем со второй строки
          $key = $key + 2;

          $page->setCellValue("A".$key, data_city_region($value[5]));          // город
          $page->setCellValue("B".$key, data_city_district($value[6]));        // район
          $page->setCellValue("C".$key, data_city_microdistrict($value[7]));   // микрорайон
          $page->setCellValue("D".$key, $value[8]);                            // заголовок
          $page->setCellValue("E".$key, $value[9]);                            // улица
          $page->setCellValue("F".$key, $value[10]);                           // описание
    	  $page->setCellValue("G".$key, transaction($value[11]));              // тип сделки
    	  $page->setCellValue("H".$key, $value[12]);                           // площадь жилая
    	  $page->setCellValue("I".$key, $value[13]);                           // площадь общая
    	  $page->setCellValue("J".$key, $value[15]);                           // этаж
    	  $page->setCellValue("K".$key, $value[16]);                           // этажность
    	  $page->setCellValue("L".$key, type_house($value[17]));               // тип дома
    	  $page->setCellValue("M".$key, $value[18]);                           // количество комнат
          $page->setCellValue("N".$key, $value[25]);
    	  $page->setCellValue("O".$key, $value[20]);                           // имя продовца
          $page->setCellValue("P".$key, agent($value[21]));                    // агент или нет
          if($seller == 1){
               $page->setCellValue("Q".$key, $value[19]);                           // телефон
               $page->setCellValue("R".$key, comments($value[0],$user));
          }

       }


          $page->setTitle("Example"); // Заголовок делаем "Example"
		  // Начинаем готовиться к записи информации в xlsx-файл
		  $objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
		  ///Записываем в файл
		  $nameFile = "example_".rand(5, 1500).".xlsx";
		  $objWriter->save($nameFile);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

          // опраавляем прайс объектов на почту
		  $filename = $_SERVER['DOCUMENT_ROOT'].'/phpExcel/'.$nameFile;                                        //Имя файла для прикрепления
		  $to = trim($_GET['email']);                                                                          //Кому
		  //$from = "admin@rlpnz.ru";                                                                            //От кого
		  $subject = "Ваш список объектов";                                                                    //Тема
		  $message = "Список объектов находиться в прикрепленом к письму файле";                               //Текст письма
		  $boundary = "---";                                                                                   //Разделитель
		  // Заголовки
		  $headers = "From: =?utf-8?b?" . base64_encode('Недвижимость Пензы') . "?= <admin@rlpnz.ru.ru>\r\n";
		  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
		  $body = "--$boundary\n";
		  // Присоединяем текстовое сообщение
		  $body .= "Content-type: text/html; charset='utf-8'\n";
		  $body .= "Content-Transfer-Encoding: quoted-printablenn";
		  $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
		  $body .= $message."\n";
		  $body .= "--$boundary\n";
		  $file = fopen($filename, "r"); //Открываем файл
		  $text = fread($file, filesize($filename)); //Считываем весь файл
		  fclose($file); //Закрываем файл
		  // Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма
		  $body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode($filename)."?=\n"; 
		  $body .= "Content-Transfer-Encoding: base64\n";
		  $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
		  $body .= chunk_split(base64_encode($text))."\n";
		  $body .= "--".$boundary ."--\n";
		  mail($to, $subject, $body, $headers); //Отправляем письмо

		  // теперь удаляем файл списка
		  unlink($_SERVER['DOCUMENT_ROOT'].'/phpExcel/'.$nameFile);

?>