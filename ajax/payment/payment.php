<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/MySQLClass.php'); // класс для работы с базой данных
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/config.php');     // настройки базы данных

// подключаемся к базе данных
$connection = new Connection();
$mysql = $connection->config();

$mrh_pass1 = "89048512165S";

// чтение параметров
// read parameters
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$shp_item = $_REQUEST["Shp_item"];
$crc = $_REQUEST["SignatureValue"];
$res = $_REQUEST["Shp_res"];
$type = $_REQUEST["Shp_type"];

$crc = strtoupper($crc);

$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item:Shp_res=$res:Shp_type=$type"));

// проверка корректности подписи
// check signature
/*
if ($my_crc != $crc)
{
  echo "bad sign\n";
  exit();
}
*/

echo "Операция прошла успешно\n";

 $period = trim($res);      // количество оплаченый дней
 $user = trim($shp_item);   // id пользователя
 $type = trim($type);       // тип оплаты (за какую услугу платим)

 if($type == 1){

     $residArr = $mysql->Select("SELECT countPay, residPublic, username FROM table_User WHERE id = ".$user);

     $countPay = $residArr[0][0];
     $residue  = $residArr[0][1];
     $username = $residArr[0][2];

     $pattern = array('+','(',')','-',' ');
     $username = str_replace($pattern,'',$username);

     $invite = $mysql->Select("SELECT * FROM table_invite WHERE phone_to = ".$username." and active = 0");

     if($invite[0][2] and strlen($invite[0][2] > 9)){
         // начисляе бонусы
         if($out_summ == 1000){
            $bonus = 400;
         }elseif($out_summ == 600){
            $bonus = 200;
         }elseif($out_summ == 250){
            $bonus = 80;
         }elseif($out_summ == 100){
            $bonus = 20;
         }elseif($out_summ == 5000){
            $bonus = 100;
         }
         // начислили
         $dActive['active'] = 1;
         $mysql->Update('table_invite', $dActive, 'username = '.$invite[0][2]);
         // смотрим  скольо у него публикаций
         $invitePublic = $mysql->Select("SELECT countPay, residPublic FROM table_User WHERE username = ".$invite[0][2]);

         $countPayInvite = abs($invitePublic[0][0]);
         $residueInvite  = abs($invitePublic[0][1]);

         if($residueInvite != 0){
             $summInv = abs($bonus) + abs($residueInvite);
             $dInvite['countPay']      =  $summInv;
             $dInvite['residPublic']   =  $summInv;

         }else{
             $summInv = abs($bonus);
             $dInvite['countPay']      =  $summInv;
             $dInvite['residPublic']   =  $summInv;
         }

         $end = $mysql->Update('table_User', $dInvite, 'username = '.$invite[0][2]);
         // закончили начислять бонусы

     }

     if($residue != 0){
         $t = abs($period) + abs($residue);
         $dataUpdate['countPay']      =  $t;
         $dataUpdate['residPublic']   =  $t;

     }else{
         $t = abs($period);
         $dataUpdate['countPay']      =  $t;
         $dataUpdate['residPublic']   =  $t;
     }

     // отчет об оплате
     $dataInsert['payDate'] = date('Y-m-d H:i:s');
     $dataInsert['userId']  = $user;
     $dataInsert['summa']   = $out_summ;

     $end = $mysql->Update('table_User', $dataUpdate, 'id = '.$user);
     $mysql->Insert('table_pay_public', $dataInsert);

     if($end == true){
         header('location: /index.php?r=realtyObject/PaymentEnd&payment=1');
     }

 }else if($type == 2){

     $data = $mysql->Select('SELECT datePayment FROM table_User WHERE id = '.$user);
     $timeAction =  $data[0][0]; // период до которого оплаченно

     // если период оплаты закончился
     if($timeAction < date('Y-m-d H:i:s')){
        echo 1;
 	   if(isset($period)){
 	      $datePayment = date('Y-m-d H:i:s',strtotime("+".$period." day"));
       }
     }else{
 	   //echo 2;
 	    if(isset($period)){
 	      $date_plus = strtotime("+ ".$period." day", strtotime($timeAction));
 	      $datePayment = date('Y-m-d H:i:s', $date_plus);
        }
     }
       $dataUpdate['datePayment'] = $datePayment;
       // записываем в историю
       $dataInsert['userId']     =  $user;
       $dataInsert['createDate'] =  date('Y-m-d H:i:s');
       $dataInsert['payDate']    =  $datePayment;
       $dataInsert['summa']      =  trim($out_summ);

       $end = $mysql->Update('table_User', $dataUpdate, 'id = '.$user);
              $mysql->Insert('table_UserPay', $dataInsert);

       if($end == true){
       	  header('location: /index.php?r=realtyObject/PaymentEnd&payment=1');
       }

 }

?>