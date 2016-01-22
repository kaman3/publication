<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/jCarouselLite/jcarousellite_1.0.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/scripts/jCarouselLite/jCarouselLite.css" />

<!--<div class = 'banner'>
            <a href = '/index.php?r=realtyObject/invite'>
                <img src = '/images/invite.jpg'>
            </a>
</div>-->


<div class = 'newCollLeft'>
    <?php $this->widget('menuOffice'); ?>
</div>

<div class = 'newCollRight'>
    <div class = 'boxMenuTopPublic'>
        <div class = 'countAdsPublicBg'>
            <? if(!Yii::app()->user->isGuest and Yii::app()->app->find_in_str($_GET['r'],'publication')) : ?>
                <div class = 'paidTo'><? echo Yii::app()->app->dateEndPay();?></div>
            <? endif;?>
        </div>
        <!-- фильтр -->
        <?php $this->widget('application.components.filterPublic'); ?>
        <div class = 'message mp'>
         <b style = 'color:red'>ВНИМАНИЕ!!!</b> Рекомендуем вам ознакомиться с правилами публикации объявлений <a href = '/index.php?r=realtyObject/recommendations'>здесь</a><br><br>
         Если ваши объявления удаляются с сайта базарпнз, обратитесь к администратору нашего сайта,
          это можно сделать воспользовавшись чатом с лева (Большая синяя кнопка) или написать на почту publishads@yandex.ru.
        </div>
    
    <!--
    <div class = 'message mp'>
        Публикация объявлений остановлена! Проводятся технические работы.
    </div>
    -->

        <?php $userCheck = Yii::app()->app->cCheck(Yii::app()->user->id);?>
        <?php if(!$userCheck) : ?>
            <div class = 'message mp'>
                Хотите что бы ваши объявления постоянно находились на высоких позиция на самых популярных площадках недвижимости нашего региона.<br>
                Тогда добавляйте объявления.<br>
                Выставляйте таймер на нужное вам время и наслаждайтесь  результатом.<br>
                Учитесь правильно тратить свое время и деньги!<br>
            </div>
            <div class = 'message mp'>
                Для начала работы вам необходимо добавить <a href = '/index.php?r=publication/contact'>контактные данные</a>.<br>
                В данный момент доступна публикация объявлений на bazarpnz.ru в дальнейшем список будет расширяться!<br>
            </div>
        <?php endif; ?>


        <? ($_GET['active']) ? $active = 'active' : $active = ''; ?>

        <? if(Yii::app()->app->endCountAds() == 1) : ?>
            <div class = 'endCountAds'>
                В данный момент Ваши объявления не публикуются! Пожалуйста <a href = '/index.php?r=realtyObject/OfficePayment'>пополните счет!</a>
            </div>
            <script>$('.butns1 a').attr('href','#')</script>
        <? endif;?>
        <!--
        <div class = 'message mp'>
            В данный момент редактирование объявлений не доступно. Ведутся технические работы.
        </div>
        -->

        <div class = 'box-status-active'>
            <? if($count_active) : ?>
                <div class = 'pSt <?=$aDivActiv_1;?>'><a href = '<?=Yii::app()->createUrl('publication/index');?>'>Активные</a></div>
            <? endif;?>
            <? if($count_hide) : ?>
                <div class = 'pSt <?=$aDivActiv_2;?>'><a href = '<?=Yii::app()->createUrl('publication/index&active=2');?>'>Скрытые</a></div>
            <? endif;?>
        </div>
        <!-- выделить все елементы -->
        <div class = 'p-select-all'>
            <div class = 'p-select-all-td_1'>
                <input type="checkbox" name="cbname3[]" value="0"  id="example_maincb">
            </div>
            <!--<div class = 'p-select-all-td_2'>Выделить все</div>-->
        </div>

        <div class = 'pCheckTable'>

            <div class = 'header-setup'>Управление выделеными элементами:</div>
            <!--
        <div class = 'p-select-timer'>
            <div class = 'tdPct ptd_1'>Таймер</div>
            <div class = 'tdPct ptd_2'>
                <select id = 'cronCheck'>
                    <? //foreach($cron as $key => $value) : ?>
                       <option  value = '<?//=$key;?>'><?//=$value[1];?></option>
                    <? //endforeach;?>
                </select>
            </div>
            <div class = 'tdPct ptd_3'>
                 <div class = 'buttonPubCheck'>Изменить</div>
            </div>
        </div>
        -->
            <div class = 'p-select-timer'>
                <a href="#" data-reveal-id="myModal_time">Время публикации</a>
            </div>

            <div class = 'deleteChangeBox'>
                <div class = 'buttonDelChange'>Удалить выбранные</div>
            </div>

            <div class = 'showAllBox'>
                <div class = 'sab_td1'>Публиковать:</div>
                <div class = 'sab_td2'>
                    <div class = 'sab_button' id = '1'>Да</div>
                    <div class = 'sab_button' id = '0'>Нет</div>
                </div>
            </div>
        </div>

    </div>
    <?php $this->renderPartial('_view',array(
        'data'=>$dataProvider,'count_active'=>$count_active,'count_hide' => $count_hide,
    ));?>

    <div class = 'boxPaginator'>
        <?php $this->widget('CLinkPager', array('pages' => $pages)) ?>
    </div>
</div>


<div id="myModal_time" class="reveal-myModal-time-index">
    <div class = 'c-list-index'>
         <div class = 'list-atb'></div>
         <div class = 'new-time-index'>
              <a href="#" id = 'clickTimeIndex'>Добавить еще таймер</a>
         </div>
         <div class = 'pb-box'>
            <div class = 'pb-line-box'>
                <a id = 'clickSaveAll' href = '#'>Пременить</a>
            </div>
            <div class = 'pb-line-box'>
                <a id = 'clickTimeClose' href = '#'>Отмена</a>
            </div>
         </div>
    </div>
    <div class = 'time-change-index'>
    <div class = 'cTime'>
        <div class = 'cTimeHeader'>Выберите дни для публикации:</div>
        <div class = 'boxCheckDay'>
            <ul>
                <li item = 1>Пн</li>
                <li item = 2>Вт</li>
                <li item = 3>Ср</li>
                <li item = 4>Чт</li>
                <li item = 5>Пт</li>
                <li item = 6 class = 'output'>Сб</li>
                <li item = 7 class = 'output'>Вс</li>
            </ul>
        </div>
        <div class = 'cTimeHeader'>Установите нужное вам время:</div>
        <div class  = 'cHoursBox'>
            <div class = 'cHb_td1'>В интервале</div>
            <div class = 'cHb_td3'><img src="/publish/resources/images/bud.png" width="15px"></div>
            <div class = 'cHb_td2'>
                <div class="Vwidget">
                    <a href="#" class="up"></a>
                    <div class="VjCarouselLite">
                        <ul>
                            <? foreach($timeInterval as $key => $value) :?>
                                <li item = '<?=$key;?>'>
                                    <div>
                                        <?=$value;?>
                                    </div>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                    <div class = 'cur'>
                        <a href="#" class="down"></a>
                    </div>
                    <div id = 'default_time' style = 'display:none;'>14</div>
                </div>
            </div>
        </div>
        <div class = 'pb-box'>
             <div class = 'pb-line-box'>
                  <a id = 'clickTimeSave' href = '#'>ОК</a>
             </div>
             <div class = 'pb-line-box'>
                  <a id = 'clickTimeClose' href = '#'>Отмена</a>
             </div>
        </div>


    </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.VjCarouselLite').css({"opacity":"0"})
    });
    $(function() {
        $(".Vwidget  .VjCarouselLite").jCarouselLite({
            btnNext: ".Vwidget .down",
            btnPrev: ".Vwidget .up",
            mouseWheel: true,
            vertical: true,
            visible: 1,
            auto: false,
            speed: 500,
            circular: true

        });
    });
</script>



