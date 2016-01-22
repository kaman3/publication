<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . '';
?>


<div class = 'gConteiner'>

    <div class = 'gMap'>
        <img src = '/images/general_page/map.png' onload="imgLoaded(this)">
        <div class = 'gRegButton'>
            <a href = '/index.php?r=User/default/registration'>Зарегистрироваться</a>
        </div>

        <div class = 'gRegSale'>
            Это бесплатно и не займет много времени!
        </div>

        <div class = 'gEnter_login'>
            <a href = '/index.php?r=site/login'>Войти на сайт</a>
        </div>

        <div class = 'gCount-object'>
            В базе <span><?=$count_ads;?></span> объектов
            <div class = 'gRedLine'></div>
        </div>

        <div class = 'gRieltorBox'>
            <div class = 'gRielHeader'>Риэлторам</div>
            <div class = 'gRielText'>
                Экономия времени и денег - не нужно обзванивать все объявления постоянно натыкаясь на агентства (95% по нашей статистике), мы это сделали за Вас!
            </div>
        </div>

        <div class = 'gSobBox'>
            <div class = 'gSobHeader'>Собственникам</div>
            <div class = 'gSobText'>
                Достаточно один раз занести свое предложение и управлять им из личного кабинета. Размещение и обновление объявлений бесплатно! Вас легко найти, ведь вы не теряетесь среди предложений агентств.            </div>
        </div>

    </div>
</div>
<!--<div class = 'glineBox_top'></div>-->
<div class = 'liner_top'></div>
<div class = 'glbox'>
    <div class = 'glbox_coll_1'>
        <div class = 'gLogHeader'>Вам больше не нужно:</div>
        <ul>
            <li>Тратить время на прозвон объявлений</li>
            <li>Регистрироваться на рекламных площадках</li>
            <li>Просматривать фото квартир, которые уже давно сданы</li>
            <li>Уточнять всю информацию во время переговоров</li>
            <li>Запоминать лишние имена и телефоны</li>
        </ul>

    </div>

    <div class = 'glbox_coll_2'>
        <div class = 'gLogHeader'>О нас</div>
        <div class = 'gFormDescription'>
            <p>Недвижимость Пензы представляет уникальный для Пензы сервис позволяющий купить или арендовать квартиру, комнату или дом без посредников напрямую от собственника.</p>
            <p> Каждый день мы просматриваем несколько тысяч объявлений, отсеиваем предложения от агентств, находим собственников, прозваниваем собственную базу и размещаем предложения на портале.</p>
            <p>Многие варианты из нашей базы отсутствуют в СМИ и сайтах по недвижимости.</p>
            <p>Мы постоянно работаем над актуальностью своей базы.</p>
        </div>
        </div>
    </div>
<!--<div class = 'glineBox_bottom'></div>-->
<div class = 'liner'></div>
<div class = 'gSbHeader'>Наши преимущества</div>
<!--
<div class = 'gServiseBox'>
     <div class = 'gSb_cool' style="text-align: center">
         <img src = '/images/general_page/1.jpg' width="420px">
     </div>
     <div class = 'gSb_cool'>
         <div class = 'gLogHeader'>Автоматическая публикация объявлений</div>
         <div class = 'gSbDescription'>
              <p>Теперь вам не нужно платить за подъем объявлений и тратить время на их обновления!</p>
              <p>Добавляете объявление 1 раз и оно появляется на всех популярных сайтах нашего региона по заданному вами расписанию, хоть каждые 3 часа! </p>
         </div>
     </div>
</div>
-->
<div class = 'gServiseBox'>
    <div class = 'gSb_cool'>
        <div class = 'gLogHeader'>Самая большая база объектов</div>
        <div class = 'gSbDescription'>
            <p>В базе собраны объекты от агентств и собственников, вы вправе сами выбрать что вам интересно.</p>
            <p>У нас нет дублей! Вы ни когда не найдете 2-х одинаковых объявлений.</p>
        </div>
    </div>
    <div class = 'gSb_cool' style="text-align: center;">
        
        <img src = '/images/general_page/3.jpg' width="450px">
    </div>
</div>
<div class = 'liner'></div>
<div class = 'gServiseBox'>
    <div class = 'gSb_cool' style="text-align: left; width: 300px; opacity: 0.7;">
        <img src = '/images/general_page/2.jpg' width="230px">
    </div>
    <div class = 'gSb_cool' style ="width: 690px;">
        <div class = 'gLogHeader'>Удобная система поиска</div>
        <div class = 'gSbDescription'>
            <p>Больше нет необходимости капаться в тысячах ненужных вам объявлений!<br> Наша поисковая система поможет вам найти интересующие вас объекты за несколько секунд!</p>
            <p></p>
        </div>
    </div>
</div>
<div class = 'liner'></div>
<div class = 'gServiseBox'>
    <div class = 'gSb_cool' style ="width: 690px;">
        <div class = 'gLogHeader'>Экономим ваше время</div>
        <div class = 'gSbDescription'>
            <p>Не тратьте свое время на просмотр десятков сайтов в поисках того что вам нужно!<br> Мы уже сделали это за вас и собрали все в одном месте.</p>
        </div>

    </div>
    <div class = 'gSb_cool' style="text-align: center; width: 300px; opacity: 0.8;">
        <img src = '/images/general_page/4.jpg' width="300px">
    </div>
</div>
<div class = 'liner'></div>
<div class = 'gServiseBox'>
    <div class = 'gSb_cool' style="text-align: left; width: 300px; opacity: 0.8;">
        <img src = '/images/general_page/5.jpg' width="200px">
    </div>
    <div class = 'gSb_cool' style ="vertical-align: middle;  width: 690px;">
        <div class = 'gLogHeader'>Не стоим на месте</div>
        <div class = 'gSbDescription'>
            <p>Мы постоянно находимся в поисках лучших решений, ищем новые источники информации.<br>
            Наша команда стремиться предоставить наиболее полную и качественную картину рынка недвижимости Пензы и Пензенской области.</p>
            <p>Вы всегда можете нам <a href = "/index.php?r=realtyObject/tips">помочь</a>, будем рады вашим советам и замечаниям!</p>
        </div>
    </div>
</div>
<div class = 'liner_top'></div>
<div class = 'gServiseBox'>
    <div class = 'gSb_cool' style ="vertical-align: middle; width: 500px;">

        <div class = 'gLogHeader' style = 'color: #ff2e05;'>Вы еще не снами! Присоединяйтесь!</div>
        <div class = 'gSbDescription'>
            <p>Почувствуй все преимущества нашей системы!</p>
            <div class = 'gRegButton_bottom'>
                <a href = '/index.php?r=User/default/registration'>Зарегистрироваться</a>
            </div>
            <br>
            <p>Это бесплатно и не займет много времени!</p>
        </div>
    </div>
    <div class = 'gSb_cool' style="text-align: left; width: 390px; opacity: 0.8;">
        <img src = '/images/general_page/6.jpg' width="390px">
    </div>
</div>
<div class = 'gFooter'>
    © 2015 &#171;Недвижимость Пензы&#187;. Все права защищены.
</div>




