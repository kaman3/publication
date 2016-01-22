<div class = 'message mp adsEnd'>
     <div class = 'header_ads_end'>Ваше объявление: <?=mb_substr(trim($_GET['title']),0,100,'utf-8'); ?></div>
     <div>
         <b>отправлено администраторам и будет опубликовано после его проверки, это может занять некоторое время.</b>
     </div>
     <div class="">Ссылка на ваше объявление:
         <a href = 'http://<?=$_SERVER['HTTP_HOST']?>/index.php?r=realtyObject/view&cat=<?=$_GET['cat'];?>&id=<?=$_GET['id']?>'>
             http://<?=$_SERVER['HTTP_HOST']?>/index.php?r=realtyObject/view&cat=<?=$_GET['cat'];?>&id=<?=$_GET['id']?>
         </a></div>
</div>

<div class = 'message mp adsEnd'>
    <div class = 'header_ads_end_h1'>Внимание!</div>
    <div class = 'header_ads_end'>Обязательно сохраните ссылку для управления вашим объявлением</div>
    <div><a href = 'http://<?=$_SERVER['HTTP_HOST']?>/index.php?r=realtyObject/update&id=<?=$_GET['id']?>&manager=<?=$_GET['manager']?>'>
            http://<?=$_SERVER['HTTP_HOST']?>/index.php?r=realtyObject/update&id=<?=$_GET['id']?>&manager=<?=$_GET['manager']?>
    </a></div>
    <div class = ''>С помощью управляющей ссылки вы сможете редактировать свое объявление</div>
</div>


