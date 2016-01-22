<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php');

ini_set('display_errors', 1);

// соединяемся с баззой данных
$connection = new Connection();
$mysql = $connection->config();

$d = $mysql->Select("SELECT id, idCat FROM table_object WHERE dateTime > (NOW() - interval 1 day)");

          foreach ($d as $key => $value){
              $setup[$key] = $value[0];
          }


print_r($d);



    $fileName = $_SERVER['DOCUMENT_ROOT'].'/test/proxi/sitemap.xml';


    $data = "<?xml version='1.0' encoding='UTF-8'?>\n";

    $data .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";
    $data .= "<url>\n";
      $data .= "<loc>http://rlpnz.ru/</loc>\n";
      $data .= "<lastmod>".date('Y-m-d')."</lastmod>\n";
      $data .= "<changefreq>hourly</changefreq>\n";
      $data .= "<priority>1.0</priority>\n";
   $data .= "</url>\n";


   
   $data .= "</urlset>\n";


    $fp = fopen($fileName,'w');
    fwrite($fp, $data);
    fclose($fp);


?>