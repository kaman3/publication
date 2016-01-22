<?php
/* @var $this PublicationController */
/* @var $data publication */
/*
$contactCountAds = Yii::app()->app->countUserAds();


foreach($contactCountAds['contactCount'] as $key => $value){
    echo $value['name'];
    echo $value['count'];
}
*/
foreach($data as $key => $value) :
// цена
($value['price']) ? $price = number_format($value['price'],0,'',' ').' руб.' : $price = '';

$imgPath = $_SERVER['DOCUMENT_ROOT'].'/publish/images/user'.$value['userId'].'/'.$value['id'].'/';

$images = Yii::app()->app->get_files($imgPath);
$ImagesGeneral = Yii::app()->app->sFileMove($images);


if(isset($ImagesGeneral[0])){
   $img = '/publish/images/user'.$value['userId'].'/'.$value['id'].'/'.$ImagesGeneral[0];
}else{
   $img = '/images/no_foto.gif';
}

if($value['publich'] == 1){
   $show = '/images/eyeShow.png';
   $textHelp = 'Отменить публикацию';
}else{
   $show = '/images/eye.png';
   $textHelp = 'Публиковать';
}

    // базар
    $statusBazar = Yii::app()->app->statusBazar($value['id']);

    if($statusBazar['deliteLink']){
       $urlB = $statusBazar['deliteLink'];
       $imgB = "/publish/resources/images/bazar.png";
       $textIconAds_B = 'Опубликованно '.Yii::app()->app->formatDate($statusBazar['datePublic']);
       $textIconAds_informer = Yii::app()->app->formatDate($statusBazar['datePublic']);
    }else{
       $urlB = '';
       $imgB = "/publish/resources/images/bazarNo.png";
       $textIconAds_B = 'Объявление еще не опубликовано';
       $textIconAds_informer = "Не опубликовано";
    }

    // авито
    if(Yii::app()->app->statusAvito($value['id'])){
        $urlA = Yii::app()->app->statusAvito($value['id']);
        $imgA = "/publish/resources/images/av.png";
        $textIconAds_A = 'Ваше объявление опубликованно';
    }else{
        $urlA = '';
        $imgA = "/publish/resources/images/avNo.png";
        $textIconAds_A = 'Объявление еще не опубликовано';
    }

    ($_GET['page']) ? $page = '&page='.$_GET['page'] : $page = '&page=1';
    $url = Yii::app()->createUrl('publication/update&id='.$value['id'].$page);
    //$url = '';

    // правильный урл для активных и скрытых элементов
    if($count_active and $count_hide){
        $activ_param = Yii::app()->request->getParam('active',0);
    }else if($count_active == 0){
        $activ_param = 2;
    }else if($count_hide == 0){
        $activ_param = 0;
    }

    $user = str_replace('+','',Yii::app()->user->name);

    $timePub = Yii::app()->app->selectedTime($value['id']);

?>

<div class = 'boxPublic_View'>
   <div class = 'bp_vTable'>
      <div class = 'bp_vTd checkbox'>
          <input type = 'checkbox' class="example_check" name = 'cbname3[]' value="<?=$value['id'];?>" userId = "<?=Yii::app()->user->id;?>" userName = '<?=$user;?>'>
      </div>
      <div class = 'bp_vTd imgPublic'>
           <div class = 'hiddenImgPublic'>
               <a href = '<?=$url;?>'><img src = '<?=$img;?>' width="140px"></a>
           </div>
      </div>
      <div class = 'bp_vTd titlePublic'>
          <a href = '<?=$url;?>'><?=mb_substr($value['title'],0,38,'utf-8').'...';?>
          <div class = 'newPprice'><?=$price;?></div>
          </a>
          <div class = 'timerPublicNew'>
              Таймер <img src = '/images/clock.png' width="18px">
              <div class = 'hideTimerItem'>
                  <div class = ''>
                      <? foreach($timePub as $t) :?>
                          <div class = 'timeItem-p'><?=$t;?></div>
                      <? endforeach; ?>
                  </div>
              </div>
          </div>
          <div class = 'informPublic'>
              <?=$textIconAds_informer;?>
          </div>
      </div>

      <div class = 'bp_vTd statusPublic'>

           <div class = 'publicBazarPnz'>
               <a href = '<?=$urlB;?>' target = '_blank'>
                   <span class="hint  hint--top  hint--info" data-hint="<?=$textIconAds_B;?>"><img src = '<?=$imgB;?>'></span>
               </a>
           </div>
      </div>
      <div class = 'bp_vTd optionPublic'>
              <span class="hint  hint--top  hint--info" data-hint="<?=$textHelp;?>">

                  <a href = '/index.php?r=publication/public&id=<?=$value['id'];?>&show=<?=$value['publich'];?>&active=<?=$activ_param;?>&page=<?=Yii::app()->request->getParam('page',1);?>'><img src = '<?=$show;?>' ></a>
              </span>
      </div>
      <div class = 'bp_vTd optionPublic' id = 'delItem' item = '<?=$value['id'];?>' redirect = '<?=Yii::app()->request->getParam('page',1);?>' active = '<?=$activ_param;?>'>

          <span class="hint  hint--top  hint--info" data-hint="Удалить">
              <img src = '/images/basket.png' width="30px">
          </span>

      </div>

   </div>
</div>

<?endforeach;?>

