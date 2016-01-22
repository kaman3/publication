<div class = 'fixedPMtnu'>
        <div class = 'boxMPL'>
            <ul>
                <li><a href = '/index.php?r=publication/index'>Мои объявления</a></li>
                <li><a href = '/index.php?r=publication/contact'>Мои контакты</a></li>
                <li><a href = '/index.php?r=publication/contact'>Список агентов</a></li>
            </ul>
        </div>
        <div class = 'boxMPL'>
            <ul>
                <li><a href = '/index.php?r=realtyObject/option'>Мой аккаунт</a></li>
                <li><a href = '/index.php?r=realtyObject/OfficePayment'>Оплата услуг</a></li>
                <li><a href = '/index.php?r=realtyObject/invite'><span style = 'color:red'>Акция!!!</span> Пригласи друга</a></li>
                <li><a href = '/index.php?r=realtyObject/codesofpublic'>Коды платных рубрик</a></li>
                <li><a href = '/index.php?r=realtyObject/recommendations'><span style = 'color:red'>Важно!!! Наши рекомендации</span></a></li>

                
            </ul>
        </div>
    <?php $userCheck = Yii::app()->app->cCheck(Yii::app()->user->id);?>
    <?php if($userCheck) : ?>
        <!-- количество объявлений у каждого контакта -->
        <? $contactCountAds = Yii::app()->app->countUserAds();?>
        <div class = 'boxCountContactAds'>
            <div class = 'HeaderCountContactAds'>Количество объявлений:</div>
            <ul>
                <? foreach($contactCountAds['contactCount'] as $key => $value) : ?>

                    <?
                       if(strlen($value['name']) > 24){
                          $name = mb_substr($value['name'],0,24,'utf-8').'...';
                       }else{
                          $name =  $value['name'];
                       }
                    ?>

                    <li><?=$name;?><span> (<?=$value['count'];?>)</span></li>

                <? endforeach; ?>
            </ul>
        </div>
    <? endif; ?>
</div>




