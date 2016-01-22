<?php /* @var $this Controller */ ?>
<? if ($_SERVER["HTTP_REFERER"] == '' AND $_SERVER["HTTP_USER_AGENT"] == '') {die('Bad bot');}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="ru" />
    <link rel="alternate" type="application/rss+xml" title="Недвижимость в Пензе" href="/rss.xml">

    <?
    $this->pageTitle = 'Публикация объявлений';
    $this->keywords = 'Публикация объявлений';
    $this->description = 'Публикация объявлений';
    ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="title" content="<?php echo CHtml::encode($this->title); ?>">
    <meta name="page-topic" content="<?php echo CHtml::encode($this->title); ?>" />
    <meta name="description" content="<?php echo CHtml::encode($this->description); ?>"/>
    <meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>" />
    <meta name="mrc__share_title" content="<?php echo CHtml::encode($this->title); ?>">
    <meta name="mrc__share_description" content="<?php echo CHtml::encode($this->description); ?>">
    <meta property="og:url" content="http://<?=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>">
    <meta property="og:title" content="<?php echo CHtml::encode($this->title); ?>">
    <meta property="og:description" content="<?php echo CHtml::encode($this->description); ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="http://<?=$_SERVER['SERVER_NAME'];?>/images/logo_original.png">
    <meta property="og:site_name" content="Недвижимость Пензы"/>
    <meta name='yandex-verification' content='4970f937c81d40a2'/>
    <link rel="apple-touch-icon" href="http://<?=$_SERVER['SERVER_NAME'];?>/images/logo_original.png">
    <meta name="robots" content="all"/>
    <meta name="audience" content="all"/>
    <meta name="distribution" content="Global"/>
    


    <? Yii::app()->clientScript->registerCoreScript('jquery');?>
    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon"/>
    <!-- blueprint CSS framework -->
    <!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection"/><![endif]-->


    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/realty/hint.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/realty/realty.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/realty/publisher.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/realty/generalPage.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/scripts/reveal/css/reveal.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/scripts/fancybox/css/jquery.fancybox-1.3.4.css"/>


    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/scripts/codebase/themes/message_default.css"/>
    <!-- jCookie -->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/cookie/jquery.cookie.js"></script>

    <meta name="verify-reformal" content="e8b10d1ec98974c83b80a894"/>
</head>

<body>

<div class = 'load'>
    <div id="load-img">
        <img src = '/publish/resources/images/110.gif' width="80px" alt = ''/>
    </div>
</div>
<!-- кнопка вверх -->
<p id="back-top">
    <a href="#top"><span></span>Вверх</a>
</p>
<div class = 'menuBox'>
    <div class = 'menuBg'>
        <? (Yii::app()->user->isGuest) ? $gPage = '/' : $gPage = '/index.php?r=publication/index'; ?>
        <div class = 'logoBg'><a href = '<?=$gPage;?>'></a></div>
        <div class = 'menuWork'>
            <?php $this->widget('zii.widgets.CMenu',array(
                'items'=>array(
                    array('label'=>'О нас', 'url'=>array('/guest/'),'linkOptions'=>array('title'=>'О нас'),'visible'=>Yii::app()->user->isGuest),
                    //array('label'=>'Публикация','url'=>array('publication/index'),'linkOptions'=>array('title'=>'Публикация'),'visible'=>!Yii::app()->user->isGuest),
                    //array('label'=>'Помощь','url'=>array(''),'linkOptions'=>array('title'=>'Помощь')),
                    array('label'=>'Тарифы', 'url'=>array('publication/rates'),'linkOptions'=>array('title'=>'Тарифы')),
                    array('label'=>'Менеджер','linkOptions'=>array('title'=>'Менеджер'), 'url'=>array('/publication/manager'), 'visible' => Yii::app()->user->name =="+79631099211"),

                ),
            )); ?>
        </div>
        <div class = 'menuAvtorization'>
            <?
            if(!Yii::app()->user->isGuest) :


                $urlExit = Yii::app()->createUrl('/site/logout');
                $aTextExit = 'Выйти';

                $urlOffice = Yii::app()->createUrl('/realtyObject/option');
                $aTextOffice = 'Личный кабинет';
                ?>
                <ul class = 'lastBg'>
                    <li><a href = '<?=$urlOffice;?>'><?=$aTextOffice;?></a></li>
                    <li><a href = '<?=$urlExit;?>'><?=$aTextExit;?></a></li>
                </ul>

            <? else: ?>
                <?
                $urlExit = Yii::app()->createUrl('/site/login');
                $aTextExit = 'Войти';

                $urlReg = Yii::app()->createUrl('/User/default/registration');
                $aTextReg = 'Регистрация';
                ?>
                <ul class = 'lastBg'>

                    <li><a href = '<?=$urlExit;?>'><?=$aTextExit;?></a></li>
                    <li><a href = '<?=$urlReg;?>'><?=$aTextReg;?></a></li>

                </ul>
            <? endif;?>
        </div>
    </div>

</div>
<? if( (Yii::app()->app->find_in_str($_GET['r'],'publication') and strlen(trim($_GET['r'])) == 11) or (Yii::app()->app->find_in_str($_GET['r'],'realtyObject') and strlen(trim($_GET['r'])) == 12)):?>
    <div class = 'payAccessPublicBox'>
        <div class="payAccessPublic">
            <?$countBuyCode=Yii::app()->app->payAccessKey();?>
            <? if($countBuyCode['nonePublic'] != 1) : ?>
                <? if($countBuyCode['countBuyCode'] == 1) : ?>
                    <div class = 'message mp pay'>Внимание! У вас остался 1 ключ для публикации объявлений в категорию Аренда. Можете <a href = '/realtyObject/codesofpublic'>пополнить счет...</a></div>
                <? elseif($countBuyCode['countBuyCode'] == 0) : ?>
                    <div class = 'message mp pay'>Объявления относящиеся к категории Аренда не публикуются, у вас закончились ключи платного доступа. Пожалуйста <a href = '/realtyObject/codesofpublic'>пополните счет...</a></div>
                <? elseif($countBuyCode['countBuyCode'] < 4) : ?>
                    <div class = 'message mp pay'>У вас осталось <?=$countBuyCode;?> платных ключей для публикации объявлений в категорию Аренда. Можете <a href = '/realtyObject/codesofpublic'>пополнить счет...</a></div>
                <? endif;?>
            <? endif;?>
        </div>
    </div>
<? endif;?>
<div class="container" id="page">

    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
    <?php endif?>

    <?php echo $content; ?>

    <div class="clear"></div>

    <div id="footer">

    </div><!-- footer -->

</div><!-- page -->

</body>
</html>
<!-- Онлайн консультант -->
<script type='text/javascript'>
    (function(){ var widget_id = '3ROknGDHt2';
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>

<script type="text/javascript" src="//api-maps.yandex.ru/2.0/?load=package.standard,package.geoObjects,package.editor&lang=ru-RU" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/fancybox/js/jquery.easing-1.3.pack.js" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/fancybox/js/jquery.fancybox-1.3.4.js" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/fancybox/js/jquery.mousewheel-3.0.4.pack.js" ></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/number_format/accounting.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/codebase/message.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/reveal/js/jquery.reveal.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/application.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/app_publication.js"></script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter31721246 = new Ya.Metrika({
                    id:31721246,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/31721246" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->







