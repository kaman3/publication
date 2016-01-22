<?
// 2.
// Оплата заданной суммы с выбором валюты на сайте ROBOKASSA
// Payment of the set sum with a choice of currency on site ROBOKASSA

// регистрационная информация (логин, пароль #1)
// registration info (login, password #1)
$mrh_login = "dimapaublic58";
$mrh_pass1 = "89048512165S";

// номер заказа
// number of order
$inv_id = 0;

// описание заказа
// order description
$inv_desc = "ROBOKASSA Advanced User Guide";

// сумма заказа
// sum of order
$out_summ = trim($_POST['summa']);

// тип товара
// code of goods
$shp_item = trim($_POST['user']);

// предлагаемая валюта платежа
// default payment e-currency
$in_curr = "";

// язык
// language
$culture = "ru";

$mass = trim($_POST['paymentPeriod']);
$type = trim($_POST['type']);

// формирование подписи
// generate signature
$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item:Shp_res=$mass:Shp_type=$type");
?>
<html>
<body>
	<link rel="stylesheet" type="text/css" href="/ajax/payment/css/style.css" />
  <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
<head>
	<title>Оплата</title>
</head>	
<div class = 'conteinerPay'>
    <div class = 'paymentWindow'>
    	<div class = 'paymentWindowText'>
          <? if($type == 1) : ?>
              <p>Вы хотите оплатить публикацию <?=$mass?> объявлений.</p>
              <p>Необходимо оплатить <?=$out_summ;?> руб.</p>
          <? else :?>
             <p>Вы хотите оплатить доступ к сайту на срок <?=$mass?> дней.</p>
             <p>Необходимо оплатить <?=$out_summ;?> руб.</p>
          <? endif; ?>
	    </div>
      <form action = 'https://auth.robokassa.ru/Merchant/Index.aspx' method = "get" >
      <input type = hidden name = "MrchLogin" value = "<?=$mrh_login;?>">
      <input type = hidden name = "OutSum" value = "<?=$out_summ;?>">
      <input type = hidden name = "InvId" value = "<?=$inv_id;?>">
      <input type = hidden name = "Desc" value = "<?=$inv_desc;?>">
      <input type = hidden name = "SignatureValue" value="<?=$crc;?>">
      <input type = hidden name = "Shp_item" value="<?=$shp_item;?>">
      <input type = hidden name = "IncCurrLabel" value="<?=$in_curr;?>">
      <input type = hidden name = "Culture" value = "<?=$culture;?>">
      <input type = hidden name = "Shp_res" value = "<?=$mass;?>">
      <input type = hidden name = "Shp_type" value = "<?=$type;?>">
      <input type = submit value='Продолжить'>
      </form>
    </div>
</div>
</body>
</html>
