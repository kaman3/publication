<? 
  if(!$_GET['r']): 
  header('HTTP/1.1 404 Not Found');     
  die();
  endif;
  ?>
<? if ($_SERVER["HTTP_REFERER"] == '' AND $_SERVER["HTTP_USER_AGENT"] == '') {die('Bad bot');}?>
<? if(!Yii::app()->user->isGuest): ?>
    <script language = 'javascript'>document.location.href='/index.php?r=publication'</script>
<? endif; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="ru" />
    
    <?
    // по умолчанию Seo
    $this->pageTitle = 'Публикация объявлений';
    $this->keywords = 'Публикация объявлений';
    $this->description = 'Публикация объявлений';


    ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="title" content="<?php echo CHtml::encode($this->pageTitle); ?>" />
    <meta name="page-topic" content="<?php echo CHtml::encode($this->pageTitle); ?>" />
    <meta name="description" content="<?php echo CHtml::encode($this->description); ?>"/>
    <meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>" />
    <meta name="mrc__share_title" content="<?php echo CHtml::encode($this->pageTitle); ?>">
    <meta name="mrc__share_description" content="<?php echo CHtml::encode($this->description); ?>">
    <meta property="og:url" content="http://<?=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>">
    <meta property="og:title" content="<?php echo CHtml::encode($this->pageTitle); ?>">
    <meta property="og:description" content="<?php echo CHtml::encode($this->description); ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="http://<?=$_SERVER['SERVER_NAME'];?>/images/logo_original.png">
    <meta property="og:site_name" content="<?php echo CHtml::encode($this->pageTitle); ?>"/>
    <meta name='yandex-verification' content='4970f937c81d40a2'/>
    <link rel="apple-touch-icon" href="http://<?=$_SERVER['SERVER_NAME'];?>/images/logo_original.png">
    <meta name="robots" content="all"/>
    <meta name="audience" content="all"/>
    <meta name="distribution" content="Global"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">
        function imgLoaded(img){
            var imgWrapper = img.parentNode;
            imgWrapper.className += imgWrapper.className ? ' loaded' : 'loaded';
        };
    </script>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon"/>
    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection"/>
    <!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/realty/generalPage.css"/>

    <!-- шрифт -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'/>

</head>

<body>
  <div class = 'conteinerBg'>
       <div class = 'menuBox'>
            <div class = 'menuBg'>
                 <div class = 'logoBg'><a href = '/'></a></div>
                 <div class = 'menuWork'>
                    <? if(Yii::app()->user->isGuest) :?>
                     <style>
                         .menuWork ul li:first-child{
                             background: #206e8e;
                         }
                         .menuWork ul li:nth-child(1) > a{
                             color: #fff;
                         }
                     </style>
                     <? endif; ?>
                    <?php $this->widget('zii.widgets.CMenu',array(
                        'items'=>array(
                            array('label'=>'О нас', 'url'=>array('/guest/'),'linkOptions'=>array('title'=>'О нас')),
                            //array('label'=>'Помощь','url'=>array(''),'linkOptions'=>array('title'=>'Помощь'),'visible'=>Yii::app()->user->isGuest),
                            array('label'=>'Тарифы', 'url'=>array('/publication/rates'),'linkOptions'=>array('title'=>'Тарифы')),
                        ),
                    )); ?>
                 </div>
                 <div class = 'menuAvtorization'>
                      <ul class = 'lastBg'>
                          <li><a href = '/index.php?r=site/login'>Войти</a></li>
                          <li><a href = '/index.php?r=User/default/registration'>Регистрация</a></li>
                      </ul>
                 </div>
            </div>

       </div>
       <div class = 'sliderBg'>
           <a href = '/index.php?r=publication/test'><div class = 'sliderBoxBg'><img src = '/images/slider.png' onload="imgLoaded(this)" alt = ''/></div></a>
       </div>
       <div class = 'promoBoxBg'>

           <div class = 'promoBox'>
                <h2>Как это работает</h2>
                <div class = 'workBoxs'>
                     <div class = 'workBoxsImg'><img src = '/images/wall_1.png' width="200px"></div>
                     <div class = 'workBoxsText'>
                         Создаете объявление
                         <div class = 'discBt'>
                             Добавляйте неограниченное количество объявлений.
                         </div>
                     </div>
                </div>
                <div class = 'workBoxs'>
                   <div class = 'workBoxsText'>Задайте интервалы для публикации
                       <div class = 'discBt'>
                           Вы можете задать до 6-ти временных интервалов на каждый день недели для каждого объявления индивидуально.
                       </div>
                   </div>
                   <div class = 'workBoxsImg' style = 'top:-40px'><img src = '/images/wall_2.png' width="400px"></div>
                </div>
                <div class = 'workBoxs'>
                   <div class = 'workBoxsImg' style = 'top:-20px'><img src = '/images/wall_3.png' width="300px"></div>
                   <div class = 'workBoxsText' style = 'text-align: left'>И ваше объявление будет на высоте
                        <div class = 'discBt'>
                            Всего за 250 рублей в месяц, мы будем каждый час публиковать ваше объявление,
                            при этом, не нарушая ни каких правил ресурсов, на которых размещаются объявления. После публикации нового объявления старое удаляется это помогает избежать дублей.
                        </div>
                   </div>

                </div>
           </div>
       </div>
       <div class = 'descBgBox'>
            <div class = 'descBg'>
                 <h2>ОСНОВНЫЕ ПРЕИМУЩЕСТВА</h2>
                 <div class = 'tableDescBox'>
                     <div class = 'itemTableDesc'>
                          <div class = 'imgItem'>
                               <img src = '/images/item1.png'>
                          </div>
                          <div class = 'itemHeader'>Аудитория</div>
                          <div class = 'itemDesc'>
                              100% охват
                              30 млн. человек/месяц
                          </div>
                     </div>
                     <div class = 'itemTableDesc'>
                         <div class = 'imgItem'>
                             <img src = '/images/item2.png'>
                         </div>
                         <div class = 'itemHeader'>Скорость</div>
                         <div class = 'itemDesc'>
                             Размещение объявления
                             за 5 минут
                         </div>
                     </div>
                     <div class = 'itemTableDesc'>
                         <div class = 'imgItem'>
                             <img src = '/images/item3.png'>
                         </div>
                         <div class = 'itemHeader'>Выгода</div>
                         <div class = 'itemDesc'>
                             Ускоренный выход
                             на самую выгодную сделку
                         </div>
                     </div>
                 </div>
            </div>
       </div>
       <div class = 'promoBoxBg'>
           <div class = 'promoBox'>
               <h2>НАШ СЕРВИС ПОДХОДИТ</h2>
               <img src = '/images/promo.png'>
           </div>
       </div>
      <div class = 'descBgBox'>
          <div class = 'ratesBox'>

              <div class = 'headerBoxrates'>Наши тарифы</div>

              <div class = 'boxSail'>
                  <div class = 'sailHeader baz'>Попробуй</div>
                  <div class = 'sailImg'>
                      <img src = '/images/test.png' width="">
                  </div>
                  <div class = 'sailPrice'>
                      <div class = 'saleAdsCount'>20 шт.</div>
                      <div class = 'saleAdsPrice'>Бесплатно</div>
                  </div>
              </div>

              <div class = 'boxSail'>
                  <div class = 'sailHeader plan'>Старт</div>
                  <div class = 'sailImg'>
                      <img src = '/images/start.png' width="">
                  </div>
                  <div class = 'sailPrice'>
                      <div class = 'saleAdsCount'>50 шт.</div>
                      <div class = 'saleAdsPrice'>100 руб.</div>
                  </div>
              </div>

              <div></div>

              <div class = 'boxSail'>
                  <div class = 'sailHeader baz'>Базовый</div>
                  <div class = 'sailImg'>
                      <img src = '/images/ball.png' width="">
                  </div>
                  <div class = 'sailPrice'>
                      <div class = 'saleAdsCount'>200 шт.</div>
                      <div class = 'saleAdsPrice'>250 руб.</div>
                  </div>
              </div>
              <div class = 'boxSail'>
                  <div class = 'sailHeader plan'>Оптимальный</div>
                  <div class = 'sailImg'>
                      <img src = '/images/plan.png' width="">
                  </div>
                  <div class = 'sailPrice'>
                      <div class = 'saleAdsCount'>500 шт.</div>
                      <div class = 'saleAdsPrice'>600 руб.</div>
                  </div>
              </div>
              <div class = 'boxSail'>
                  <div class = 'sailHeader raket'>Максимальный</div>
                  <div class = 'sailImg'>
                      <img src = '/images/raket.png' width="">
                  </div>
                  <div class = 'sailPrice'>
                      <div class = 'saleAdsCount'>1000 шт.</div>
                      <div class = 'saleAdsPrice'>1000 руб.</div>
                  </div>
              </div>
              <div class = 'boxSail'>
                  <div class = 'sailHeader vip'>VIP</div>
                  <div class = 'sailImg'>
                      <img src = '/images/vip.png' width="">
                  </div>
                  <div class = 'sailPrice'>
                      <div class = 'saleAdsCount'>6000 шт.</div>
                      <div class = 'saleAdsPrice'>5000 руб.</div>
                  </div>
              </div>

          </div>
      </div>
       <div class = 'descBgBox'>
          <div class = 'descBg'>
               <h3>Зарегистрируйтесь и вам будет доступно:</h3>
               <div class = 'descText'>
                   <ul>
                       <li>нелимитированное кол-во объявлений</li>
                       <li>возможность редактировать объявления с мгновенным обновлением информации на всех сайтах сети</li>
                       <li>возможность удалить/отключить объявления</li>
                   </ul>
               </div>
               <div class = 'descText'>
                   <ul>
                       <li>назначение расписания обновления на сайтах</li>
                       <li>статистика просмотров объявлений в целом и по сайтам в отдельности</li>
                       <li>проверочные ссылки</li>
                   </ul>
               </div>
          </div>
          <div class = 'regBg'><a href = '/index.php?r=publication'>Добавить объявление</a></div>
       </div>
       <div class = 'footerBg'>
            <div class = 'footerBox'>
                © "publishAds.ru" Все права защищены.
            </div>
       </div>
  </div>
</body>
</html>

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
