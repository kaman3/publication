
<script>
    $(document).ready(function(){
        // делаем плавныйм появление блока с картинками
        setTimeout($('.nBoxImages').css({'display':'block'}), 1500)
    });
</script>
<!-- fliexslider -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/fotorama/fotorama.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/scripts/fotorama/fotorama.css" />
<?php $this->widget('application.components.search'); ?>
<?
  $difference = time()-strtotime($model->dateTime);
  header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', time()-$difference+10800));
?>
<div class = 'breadcrumbsRealty'>
	<ul>
	   <? if(isset($_GET['cat'])) :?>
		   <li><a href = '/'>Главная</a></li>
	       <? echo Yii::app()->app->breadcrumbs(trim($_GET['cat'])); ?>
       <? endif;?>
    </ul>
</div>


<? if($model->description) : ?>
    <? $lot_text = "Лот № ".$model->id; ?>
    <? ($model->transaction) ? $tran_text =  mb_strtolower(Yii::app()->app->getTransaction($model->transaction),'utf-8') : $tran_text = ''; ?>
    <? ($model->district) ? $distr_text = mb_strtolower(Yii::app()->app->getDistricts(trim($model->district)),'utf-8')." район, " : $distr_text = ''; ?>
    <? ($model->microdistrict) ? $micdistr_text = "микрорайон ".mb_strtolower(Yii::app()->app->getMicrodistrict($model->microdistrict),'utf-8').", " : $micdistr_text = ''; ?>
    <? //($model->idCat) ? $cat_text = mb_strtolower(Yii::app()->app->getH1($model->idCat),'utf-8') : $cat_text = ''; ?>
    <? ($model->street) ? $street_text = " ул.".$model->street : $street_text = ''; ?>
    <? ($model->NameDealer) ? $nameDealer_text = "продавец ".$model->NameDealer : $nameDealer_text = ''; ?>
    <?
    // правильное написание категории
    if($model->idCat){
        if($model->idCat == 2 and $model->transaction){
            $cat_text = "комнату на общей кухне";
        }else if($model->idCat == 7 and $model->transaction){
            $cat_text = "квартиру вторичное жилье";
        }elseif($model->idCat == 8 and $model->transaction){
            $cat_text = "квартиру в новостройке";
        }else if($model->idCat == 9){
            if($model->transaction){
                $cat_text = "квартиру на длительный срок";
            }else{
                $cat_text = "аренда квартир на длительный срок";
            }
        }else if($model->idCat == 10){
            $cat_text = "квартиру на сутки";
        }else if($model->idCat == 11){
            $cat_text = "дом";
        }else if($model->idCat == 12){
            if($model->transaction){
                $cat_text = "дачу";
            }else{
                $cat_text = "дачи";
            }
        }else if($model->idCat == 13 and $model->transaction){
            $cat_text = "коттедж";
        }else if($model->idCat == 14 and $model->transaction){
            $cat_text = "таунхаус";
        }else if($model->idCat == 23 and $model->transaction){
            $cat_text = "гараж";
        }else{
            $cat_text = mb_strtolower(Yii::app()->app->getH1($model->idCat),'utf-8');
        }
    }else{
        $cat_text = "Недвижимость";
    }
    // количество комнат
    if(count($model->countRooms) == 1  and $model->idCat == 7 and $model->idCat == 8 and $model->idCat == 9 and $model->idCat == 10){
        if($model->countRooms == 1){
            $countRooms = 'однокомнатную';
        }elseif($model->countRooms == 2){
            $countRooms = 'двухкомнатную';
        }elseif($model->countRooms == 3){
            $countRooms = 'трехкомнатную ';
        }elseif($model->countRooms == 4){
            $countRooms = 'четырехкомнатную';
        }
    }
    // площадь
    if($model->totalArea){
       $area = ", площадь ".$model->totalArea."м²";
    }
    // этаж
    if($model->floor){
       $floor = ", этаж ".$model->floor;
    }
    // тип дома
    if($model->typeHouse){
       $typeHouse = mb_strtolower(", дом ".trim(Yii::app()->app->getTypeHouse($model->typeHouse)),'utf-8');
    }

    $dscrp = $lot_text.", ".$tran_text." ".$countRooms." ".$cat_text." ".$area." ".$floor." ".$typeHouse." ".$distr_text." ".$micdistr_text." ".$street_text." ".trim($nameDealer_text).". ";
    $mapdscr = $distr_text." ".$micdistr_text." ".$street_text." ".trim($nameDealer_text).". ";
    ?>
<? endif; ?>
<?($model->price) ? $price = number_format($model->price,0,'',' ').' руб.' : $price = 'Цена не указана';?>
<!-- seo -->
<?
$this->pageTitle   = $model->title." - недвижимость в Пензе, квартиры Пенза, продажа, покупка, аренда без посредников в Пензе";
$this->description = mb_substr($model->description,0,150,'utf-8');
$this->title =   $model->title;
$this->keywords = $dscrp.' купить, продать, сдать, снять, квартиру, дом, коммерческую недвижимость, пенза, аренда, краткосрочная';
?>
<?// $this->pageTitle = $model->title.' - продажа, покупка, аренда без посредников в Пензе'; ?>
<?// $this->description = substr($model->description,0,300);?>
<?// $this->keywords = 'купить, продать, сдать, снять, квартиру, дом, коммерческую недвижимость, пенза, аренда, краткосрочная';?>
<!-- seo end -->
<div class = 'showSearscBlock' data = '1'></div>
<h1 class = 'headerObject'><?php echo $model->title; ?></h1>

<div class = 'boxItem'>
<div class = 'nboxH2'>
    <? if($price) : ?>
    <div class = 'nHprice'><?=$price;?></div>
    <? endif; ?>
    <div class = 'labelDescription'><p><?=$dscrp;?></p></div>
</div>
<div class = 'boxInfo'>

    <div class="nBoxImages">
        <?
        $path_pars = Yii::app()->app->get_path_pars_img($model->idPars);
        $imgPath = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/'.trim($path_pars).'/'.$model->idAds.'/';
        $images = Yii::app()->app->get_files($imgPath);

        $img = '/pars/tmp/images/'.trim($path_pars).'/'.$model->idAds.'/';

        ?>
        <? if(count($images) > 0) :?>
        <div class="fotorama" data-nav="thumbs" height="400" data-maxHeight="400"  data-width="650" data-autoplay="true" data-fullscreenIcon="true" data-thumbbordercolor="#ff0000" data-background="#FFFFFF">
                <? for($i = 0; $i < count($images); $i++) : ?>
                   <a href="<?=$img.$images[$i]; ?>"><img src="<?=$img.$images[$i]; ?>" /></a>
                <? endfor;?>
        </div>
        <? endif; ?>
    </div>

    <? if($model->description) : ?>
        <h3 class = 'h3Class'>Описание объекта</h3>
        <div class = 'labelDscrBottom'><p><?=str_replace(array("\n","\r","\xC2\xA0"), ' ', $model->description);?></p></div>
    <? endif; ?>
    <!-- описание -->
    <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
    <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="small" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yashareTheme="counter"></div>
    <br>
    <!-- выводим id парсера -->
        <!-- выводим город -->
        <h4 class = 'h4Class'>Информация о предложении</h4>
        <? if($model->city) : ?>
	       <div class = 'labelBox'>
	           <div class = 'labelText'>Город</div>
	           <div class = 'labelInfo'><a href = '/?r=realtyObject&cat=<?=$_GET['cat'];?>&city=<?=$model->city;?>&transaction=<?=$model->transaction;?>' title = '<?=trim(Yii::app()->app->getCity($model->city)); ?>'><?=trim(Yii::app()->app->getCity($model->city)); ?></a></div>
	       </div>
        <? endif; ?>
        <? if($model->city == 2): ?>
        <!-- выводим район города -->
              <? if($model->district) : ?>
	          <div class = 'labelBox'>
	              <div class = 'labelText'>Район города</div>
	              <div class = 'labelInfo'><a href = '/?r=realtyObject&cat=<?=$_GET['cat'];?>&districts=<?=$model->district;?>&transaction=<?=$model->transaction;?>' title = '<?=Yii::app()->app->getDistricts($model->district);?>'><?=trim(Yii::app()->app->getDistricts($model->district)); ?></a></div>
	          </div>
              <? endif; ?>
              <!-- микрорайон -->
              <? if($model->microdistrict) : ?>
              <? ($model->countRooms) ? $mcr = '&CountRooms%5B%5D='.$model->countRooms : $mcr = ''; ?>
	          <div class = 'labelBox'>
	              <div class = 'labelText'>Микрорайон</div>
	              <div class = 'labelInfo'><a href = '/?r=realtyObject&cat=<?=$_GET['cat'];?>&microdistricts%5B%5D=<?=$model->microdistrict;?>&transaction=<?=$model->transaction;?><?=$mcr;?>' title = '<?=Yii::app()->app->getTransaction($model->transaction);?> <?=Yii::app()->app->getH1($_GET['cat']);?> <?=Yii::app()->app->getMicrodistrict($model->microdistrict);?>'><?=trim(Yii::app()->app->getMicrodistrict($model->microdistrict)); ?></a></div>
	          </div>
           <? endif; ?>
        <? endif;?>
        <!-- Тип сделки -->
        <? if($model->transaction) : ?>
	       <div class = 'labelBox'>
	           <div class = 'labelText'>Тип сделки</div>
	           <div class = 'labelInfo'><a href = '/?r=realtyObject&transaction=<?=$model->transaction;?>' title = 'тип сделки'><?=trim(Yii::app()->app->getTransaction($model->transaction)); ?></a></div>
	       </div>
        <? endif; ?>
         <!-- тип дома -->
        <? if($model->typeHouse) : ?>
	       <div class = 'labelBox'>
	           <div class = 'labelText'>Тип дома</div>
	           <div class = 'labelInfo'><?=trim(Yii::app()->app->getTypeHouse($model->typeHouse)); ?></div>
	       </div>
        <? endif; ?>
        <!-- улица -->
        <? if($model->street) : ?>
	       <div class = 'labelBox'>
	           <div class = 'labelText'>Улица</div>
	           <div class = 'labelInfo'><?=trim($model->street); ?></div>
	       </div>
        <? endif; ?>
        <!-- выводим имя  -->
        <? if($model->NameDealer) : ?>
	        <div class = 'labelBox'>
	            <div class = 'labelText'>Имя продавца</div>
	            <div class = 'labelInfo'><?=trim($model->NameDealer); ?></div>
	        </div>
        <? endif; ?>
        <!-- количество комнат -->
        <? if($model->countRooms) : ?>
	       <div class = 'labelBox'>
	            <div class = 'labelText'>Количество комнат</div>
	            <div class = 'labelInfo'><a href = '/?r=realtyObject&cat=<?=$_GET['cat'];?>&transaction=<?=$model->transaction;?>&CountRooms%5B%5D=<?=$model->countRooms;?>' title = 'количество комнат'><?=trim($model->countRooms); ?></a></div>
	       </div>
        <? endif; ?>

        <? if($model->agent) : ?>
            <? ($model->agent == 1) ? $agent = 'нет' : $agent = 'да';?>
            <div class = 'labelBox'>
                <div class = 'labelText'>Агентство</div>
                <div class = 'labelInfo' id = 'agent' data = '<?=$model->agent;?>' data-id = '<?=$model->id;?>'><?=$agent; ?></div>
            </div>
        <? endif; ?>
        <!-- выводим номер телефона -->
        <? //if($model->phone) : ?>
           <div class = 'labelBox'>
                <div class = 'labelText'>Телефон</div>
                 <? //if(!Yii::app()->user->isGuest) : ?>
	               <div class = 'labelInfo pLabelPhobe' id = 'phoneButton'><?=Yii::app()->app->format_phone($model->phone); ?></div>
                 <? //else : ?>
               <!--
                 <div class = 'labelInfo' id = 'phoneButton'>
                      Не доступен
                      <span class="hint  hint--top  hint--info" data-hint="Вам необходимо зарегистрироваться">
                         <img src = '/images/question.png' width="20px">
                      </span>
                      <a href = '#'>подробнее...</a>
                 </div>
                 -->
                 <? //endif;?>
           </div>
        <? //endif; ?>

        <!-- этаж -->
        <? if($model->floor) : ?>
	       <div class = 'labelBox'>
	            <div class = 'labelText'>Этаж</div>
	            <div class = 'labelInfo'><a href = '/?r=realtyObject&floor_start=<?=$model->floor;?>&floor_end=<?=$model->floor;?>' title = 'Этаж'><?=trim($model->floor); ?></a></div>
	       </div>
        <? endif; ?>
        <!-- этажность -->
        <? if($model->floors) : ?>
	       <div class = 'labelBox'>
	            <div class = 'labelText'>Этажность</div>
	            <div class = 'labelInfo'><?=trim($model->floors); ?></div>
	       </div>
        <? endif; ?>
        <!-- общая площщадь -->
        <? if($model->totalArea) : ?>
	       <div class = 'labelBox'>
	            <div class = 'labelText'>Общая площадь</div>
	            <div class = 'labelInfo'><a href = '/?r=realtyObject&area_start=<?=$model->totalArea;?>&area_end=<?=$model->totalArea;?>' title = 'площадь'><?=trim($model->totalArea); ?></a></div>
	       </div>
        <? endif; ?>
        <!-- жилая площвдь -->
        <? if($model->area) : ?>
	       <div class = 'labelBox'>
	            <div class = 'labelText'>Жилая площадь</div>
	            <div class = 'labelInfo'><?=trim($model->area); ?></div>
	       </div>
        <? endif; ?>
        <!-- площадь участка -->
        <? if($model->plotArea) : ?>
	       <div class = 'labelBox'>
	            <div class = 'labelText'>Площадь участка</div>
	            <div class = 'labelInfo'><?=trim($model->plotArea); ?></div>
	       </div>
        <? endif; ?>
        <!-- срок сдачи объекта -->
        <? if($model->deadline) : ?>
	       <div class = 'labelBox'>
	            <div class = 'labelText'>Срок сдачи обекта</div>
	            <div class = 'labelInfo'><?=trim($model->deadline); ?></div>
	       </div>
        <? endif; ?>
        <!-- цена -->
        <? if($model->price) : ?>
	       <div class = 'labelBox'>
	            <div class = 'labelText' style = 'vertical-align: top;'>Цена</div>
	            <div class = 'labelInfo'>
                    <div class = 'rLabelPrice'><?=$price; ?></div>
                    <div class = 'otherCurBox'>
                         <div class = 'usdCur'><span>USD</span> <?=number_format($model->price/57,0,'',' '); ?></div>
                         <div class = 'eurCur'><span>EUR</span> <?=number_format($model->price/63,0,'',' '); ?></div>
                    </div>
                </div>
	       </div>
        <? endif; ?>

	    <!-- кнопка агент или нет -->
        <? if(!Yii::app()->user->isGuest) : ?>
	    <div class = 'labelBox' style = 'border:none; background: #fff'>
	         <div class = 'labelText'></div>
	         <div class = 'labelInfo'><div class = 'buttonAgent'>Это агент</div></div>
	    </div>
        <? endif; ?>


        <?
         (!Yii::app()->user->isGuest) ? $reg = 1 : $reg = 0;
         $notebook = Yii::app()->app->showNotebookCat();

            $check_n_b = Yii::app()->app->checkElemNotebook();
            $a = array();
            for($i = 0; $i < count($check_n_b); $i++){
                $a['idAds'][] = $check_n_b[$i]['idAds'];
            }

            if(count($a['idAds']) > 0){
            {
                if(in_array($_GET['id'],$a['idAds'])){
                    $check_img_n_b = "display:none";
                    $add = 1;
                }else{
                    $check_img_n_b = "display:block";
                    $add = 0;
                }
            }
            }else{
              $check_img_n_b = "display:block";
              $add = 0;
            }


        ?>

           <div class = 'BoxAddNotebook'>
               <div class = 'addNotebook' reg = '<?=$reg;?>' item = '<?=$model->id; ?>' add = '<?=$add;?>' location = '1'>Добавить в блокнот</div>
               <? //if(!Yii::app()->user->isGuest and $model->sold == 0) : ?>
                  <!--<div class = 'addSold' id = '<?=$model->id;?>'>Отметить как проданный</div>-->
               <? //endif; ?>
               <? if(Yii::app()->user->name == '79631099211') : ?>
               <div class = 'delAdsAdmin' id = '<?=$model->id;?>'>Удалить</div>
               <? endif; ?>
           </div>

           <div class = 'dateAdsPublic'>
               Дата размещения объявления: <span style = 'text-transform: lowercase;'><?php echo Yii::app()->app->formatDate($model->dateTime);?></span>
           </div>
           <?if($model->city == 2 and $model->street):?>
           <script src="https://api-maps.yandex.ru/1.1/index.xml" type="text/javascript"></script>

           <?$cord = explode(',',$model->coordinaty);?>
             <script type="text/javascript">
                   // Создает обработчик события window.onLoad
                   YMaps.jQuery(function () {
                   // Создает экземпляр карты и привязывает его к созданному контейнеру
                   var map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);

                   // Устанавливает начальные параметры отображения карты: центр карты и коэффициент масштабирования
                   map.setCenter(new YMaps.GeoPoint(<?=$cord[1];?>,<?=$cord[0];?>), 15);
                       var zoom = new YMaps.Zoom({
                           customTips: [
                               { index: 1, value: "Мелко" },
                               { index: 9, value: "Средне" },
                               { index: 16, value: "Крупно" }
                           ]
                       });

                       map.addControl(zoom);
                   var placemark = new YMaps.Placemark(new YMaps.GeoPoint(<?=$cord[1];?>,<?=$cord[0];?>), {style: "default#redSmallPoint", hasBalloon : false});
                   //var placemark = new YMaps.Placemark(point, { hasBalloon : false });
                   // Добавляет метку на карту
                   map.addOverlay(placemark);

             })
             </script>
           <h5 class = 'h5Class'>Расположение</h5>
           <div class = 'cMapDscr'><p><?=Yii::app()->app->mb_ucfirst($mapdscr);?></p></div>
           <div class = 'cMapPoint'>
               <div id="YMapsID" style="width: 650px; height: 300px;"></div>
           </div>
           <? endif; ?>

           <? if($_GET['comments'] == 1 ) : ?>

           <? if(count($comments) > 0) : ?>
           <div class = 'BoxWriteComments'>
                <div class = 'headerBwc'>Комментарии</div>
                <? foreach($comments as $key => $value) : ?>
                           <? if($value['userId'] == Yii::app()->user->id) : ?>
                              <div class = 'bodyBwc'>
                                  <?=$value['text'];?>
                                  <div class = 'delComNote' id = '<?=$value['id'];?>'>Удалить</div>
                              </div>
                           <? endif; ?>
                <? endforeach; ?>

           </div>
           <? endif; ?>

           <div class = 'BoxAddComents'>
                <div class = 'addComentsButton'>Добавить комментарий</div>
                <div class = 'boxComments'>
                     <div class = 'CText'>
                          <textarea rows="10" cols="66" name="text" id = "CText"></textarea>
                     </div>
                     <div class = 'CtButton'>
                          <div class = 'ctb' id="<?=$model->id; ?>">Добавить</div>
                     </div>
                </div>
           </div>
           <? endif; ?>
           <?php $this->widget('application.components.interestingObject'); ?>

           <?php $this->widget('application.components.SellerObjects',array('phone'=>$model->phone,'NameDealer'=>$model->NameDealer)); ?>
    </div>
    <div class = 'boxImages'>
         <div class = 'conDescription'>
              <? if($model->NameDealer) : ?>
              <div class = 'conNameDealer'>Продавец:
              <h6><?=trim($model->NameDealer); ?></h6>
              </div>
              <? endif; ?>
              <div class = 'conNumPhone'>
                  <?=Yii::app()->app->format_phone($model->phone); ?>
              </div>
             <? if($model->agent == 2) : ?>
                 <div class = 'conAgentPhone'>Агентство</div>
             <? endif;?>
              <div class = 'conplease'>
                  <p>Пожалуйста, скажите, что Вы нашли это объявление на Rlpnz.ru</p>
              </div>
             <? if( Yii::app()->app->countOffers($model->phone,$model->id) == 1) : ?>
             <div class = 'labelBox' style = 'border:none; background: #fff'>
                 <div class = 'aoffers'><a href = '/index.php?r=realtyObject/Offers&phone=<?=trim($model->phone);?>' title = 'Другие предложения, недвижимость в Пензе'>Другие предложения этого продавца</a></div>
             </div>
             <? endif; ?>
             <? if($model->street) : ?>
                 <div class = 'appClose'><a  href = '/?r=realtyObject&street=<?=$model->street;?>'>Найти квартиру неподалеку</a></div>
             <? endif;?>
             <div class = 'addNotebook' reg = '<?=$reg;?>' item = '<?=$model->id; ?>' add = '<?=$add;?>' location = '1'>Добавить в блокнот</div>
             <div class = 'formissue'>
                  <h6>Задать вопрос</h6>
                  <form id="getMail" data-url = '/?r=realtyObject/getMail'>
                      <input type = 'text' name = 'name' placeholder="Ваше имя">
                      <input type = 'text' name = 'email' placeholder="Ваш email">
                      <input type = 'text' name = 'phone' placeholder="Ваш телефон">
                      <textarea id = 'textDescr'  name = 'description' placeholder="Вы можете узнать все что вас интересует отправив вопрос продавцу"></textarea>
                      <input type = 'submit'  value = 'Отправить'>
                  </form>
             </div>
             <div class = 'blockRuless'>
                  <div class = 'itembr'>
                      <a href='javascript:window.print(); void 0;' title = 'Напечатать страницу'><img src = '/images/print_panel.png' width="20px" alt = 'Печать'>Напечатать страницу</a>
                  </div>
                 <div class = 'itembr'>
                     <a href="#" data-reveal-id="myModal_sendfriend"><img src = '/images/mailIcon.png' width="20px">Отправить другу</a>
                 </div>
             </div>
             <div class = ''>
                 <?php $this->widget('application.components.lastNewsInformer'); ?>
             </div>
             <div style = 'margin-top: 5px;'>
                 <a href = '/statyi/avtomaticheskaya_publikaciya_obyyavleniy_-50.html'><img src = '/images/banners/banner_240.png'></a>
             </div>
         </div>
    </div>

</div>
<div id="myModal_sendfriend" class="reveal-myModal-sendfriend">
    <div class = 'formissue'>
        <form id = 'sendfriend'>
            <p>Введиде почту вашего друга и мы отправим ему ссылку на это объявление.</p>
            <input type = 'text' name = 'main_email' placeholder="Введите свой email">
            <input type = 'text' name = 'friend_email' placeholder="Email вашего друга">
            <input type = 'submit'  value = 'Отправить'>
        </form>
    </div>
</div>







