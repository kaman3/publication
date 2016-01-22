<div class = 'line_bar_top'></div>

    <?
    foreach($dataProvider as $key => $value){
        if($value['NameDealer']){
           $NameDealer = $value['NameDealer'];
           break;
        }
    }

    ?>

<div class = 'NameDealerOffers'>
    <? if($NameDealer) : ?>
        <div class = 'ndoHeader'>Продавец</div>
        <div class = 'ndoname'><?=$NameDealer;?></div>
    <? endif; ?>
    <div class = 'ndophone'>Номер телефона:  <span><?=Yii::app()->app->format_phone($dataProvider[0]['phone']); ?></span></div>
    <div class = 'ndocount'>Объектов: <span><?=$count;?></span></div>
</div>

<?php
foreach($dataProvider as $value):

    ($value['price']) ? $price = number_format($value['price'],0,'',' ').' руб.' : $price = '';

    $path_pars = Yii::app()->app->get_path_pars_img($value['idPars']);

    //$imgPath = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/'.trim($path_pars).'/'.trim($value['idAds']).'/';
    $imgPath = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/'.trim($path_pars).'/'.trim($value['idAds']).'/small/';
    $countPath = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/'.trim($path_pars).'/'.trim($value['idAds']).'/';

    $images = Yii::app()->app->get_files($imgPath);

    // количество фото
    $countImg = count(Yii::app()->app->get_files($countPath));

    if(isset($images[0])){
        $img = '/pars/tmp/images/'.trim($path_pars).'/'.$value['idAds'].'/small/'.$images[0];
    }else{
        $img = '/pars/tmp/images/no_foto.gif';
    }
    /*
    // проверяем авторизован ли юзер
    if(!Yii::app()->user->isGuest){
    // проверка тестового периода
       if(Yii::app()->app->testPeriod() == 1) {
          $url = Yii::app()->createUrl('realtyObject/view&cat='.$value['idCat'].'&id='.$value['id']);
       }else{
          $url = '';
       }
    }else{
          $url = Yii::app()->createUrl('realtyObject/view&cat='.$value['idCat'].'&id='.$value['id']);
    }
    */
    //$url = Yii::app()->createUrl('realtyObject/view&title='.Yii::app()->app->translit($value['title']).'&cat='.$value['idCat'].'&id='.$value['id']);
    $url = strtolower('/'.Yii::app()->app->getCityPach($value['city']).'/'.Yii::app()->app->translit($value['title'].'_ob_'.$value['idCat'].'_'.$value['id']).'.html');

    // echo Yii::app()->app->getCityPach($value['city']);

    if($value['idCat'] == 9){
        $rent = 'в месяц';
    }else if($value['idCat'] == 10){
        $rent = 'за сутки';
    }else{
        $rent = '';
    }

    // расположение объекта
    $city =  Yii::app()->app->getCity($value['district']);
    $district = Yii::app()->app->getDistricts($value['district']);
    $microdistrict = Yii::app()->app->getMicrodistrict($value['microdistrict']);

    // формируем записи в блокнот для зарегистрированных и для обычных пользователей
    (!Yii::app()->user->isGuest) ? $reg = 1 : $reg = 0;
    // отмечаем элементы добавленные в блокнот
    if(count($check_n_b['idAds']) > 0){
        {
            if(in_array($value['id'],$check_n_b['idAds'])){
                $check_img_n_b = "/images/noteadd.png";
                $add = 1;
            }else{
                $check_img_n_b = "/images/notebook2.png";
                $add = 0;
            }
        }
    }else{
        $check_img_n_b = "/images/notebook2.png";
        $add = 0;
    }

    if($add == 0){
        $textAddNottebook = 'Добавить в блокнот';
    }else{
        $textAddNottebook = 'Для повторного добавления откройте объявление';
    }
    ?>


    <? ($value['transaction']) ? $tran_text =  mb_strtolower(Yii::app()->app->getTransaction($value['transaction']),'utf-8') : $tran_text = ''; ?>
    <? ($value['district']) ? $distr_text = ", ".mb_strtolower(Yii::app()->app->getDistricts(trim($value['district'])),'utf-8')." район  " : $distr_text = ''; ?>
    <? ($value['microdistrict']) ? $micdistr_text = ", микрорайон ".mb_strtolower(Yii::app()->app->getMicrodistrict($value['microdistrict']),'utf-8') : $micdistr_text = ''; ?>
    <? //($model->idCat) ? $cat_text = mb_strtolower(Yii::app()->app->getH1($model->idCat),'utf-8') : $cat_text = ''; ?>
    <? ($value['street']) ? $street_text = " ул.".$value['street'] : $street_text = ''; ?>
    <? ($value['NameDealer']) ? $nameDealer_text = ", продавец ".$value['NameDealer'] : $nameDealer_text = ''; ?>
    <?
    // правильное написание категории

    if($value['idCat']){
        if($value['idCat'] == 2 and $value['transaction']){
            $cat_text = "комнату на общей кухне";
        }else if($value['idCat'] == 7 and $value['transaction']){
            $cat_text = "квартиру вторичное жилье";
        }elseif($value['idCat'] == 8 and $value['transaction']){
            $cat_text = "квартиру в новостройке";
        }else if($value['idCat'] == 9){
            if($value['transaction']){
                $cat_text = "квартиру на длительный срок";
            }else{
                $cat_text = "аренда квартир на длительный срок";
            }
        }else if($value['idCat'] == 10){
            $cat_text = "квартиру на сутки";
        }else if($value['idCat'] == 11){
            $cat_text = "дом";
        }else if($value['idCat'] == 12){
            if($value['transaction']){
                $cat_text = "дачу";
            }else{
                $cat_text = "дачи";
            }
        }else if($value['idCat'] == 13 and $value['transaction']){
            $cat_text = "коттедж";
        }else if($value['idCat'] == 14 and $value['transaction']){
            $cat_text = "таунхаус";
        }else if($value['idCat'] == 23 and $value['transaction']){
            $cat_text = "гараж";
        }elseif($value['idCat'] == 18){
            $cat_text = "офис";
        }else{
            $cat_text = mb_strtolower(Yii::app()->app->getH1($value['idCat']),'utf-8');
        }
    }else{
        $cat_text = "Недвижимость";
    }

    // количество комнат
    if(count($value['countRooms']) == 1 and $value['idCat'] == 7 and $value['idCat'] == 8 and $value['idCat'] == 9 and $value['idCat'] == 10){
        if($value['countRooms'] == 1){
            $countRooms = 'однокомнатную';
        }elseif($value['countRooms'] == 2){
            $countRooms = 'двухкомнатную';
        }elseif($value['countRooms'] == 3){
            $countRooms = 'трехкомнатную ';
        }elseif($value['countRooms'] == 4){
            $countRooms = 'четырехкомнатную';
        }
    }
    // площадь
    if($value['totalArea']){
        $area = ", площадь ".$value['totalArea']."м²";
    }
    // этаж
    if($value['floor']){
        $floor = ", этаж ".$value['floor'];
    }
    // тип дома

    if($value['typeHouse']){
        $typeHouse = mb_strtolower(", дом ".trim(Yii::app()->app->getTypeHouse($value['typeHouse'])),'utf-8');
    }

    $dscrp = $tran_text." ".$countRooms." ".$cat_text." ".$area." ".$floor." ".$typeHouse.$distr_text.$micdistr_text." ".$street_text." ".trim($nameDealer_text).". ";
    //echo $dscrp;
    ?>

    <div class = 'BoxRealtyObject' itemtype = 'http://schema.org/Offer' item = '<?=$value['id'];?>' views = '1'>

        <div class = 'notebook' reg = '<?=$reg;?>' add = '<?=$add;?>'>
        <span class="hint  hint--top  hint--info" data-hint="<?=$textAddNottebook;?>">
            <img src = '<?=$check_img_n_b;?>' width="25px;">
        </span>
        </div>
        <div class = 'priceTd'>
            <?php echo CHtml::encode($price);?>
            <div class = 'rent'><?=$rent;?></div>
        </div>
        <div class = 'imagesTd'>
            <div class = 'hiddenImg'>
                <a item = '<?=$value['id'];?>' target = '_blank' href = '<?=$url?>' title = '<?=$value['title']." - продажа, покупка, аренда без посредников в Пензе";?>'>
                    <img src = '<?=$img;?>' alt = '<?=$value['title'];?>' width = '130px'>
                    <? if($countImg) : ?>
                        <div class = 'countImg'><?=$countImg;?></div>
                    <? endif;?>
                    <? if($value['sold'] == 2) : ?>
                        <div class = 'smarcer'></div>
                    <? endif;?>
                </a>
            </div>
        </div>
        <div class = 'urlTd'>
            <a item = '<?=$value['id'];?>'  target = '_blank' href = '<?=$url;?>' title = '<?=$value['title']." - продажа, покупка, аренда без посредников в Пензе";?>'>
                <h3 class = 'headerAll'><?=mb_substr($value['title'],0,100,'utf-8');?></h3>
                <div class = 'address_urlTd'>
                    <?// if($district) echo "р-н ".trim($district).', ';?>
                    <?// if($microdistrict) echo 'мк-рн '.trim($microdistrict).', ';?>
                    <?// if($value['street']) echo trim($value['street']).', '; ?>
                    <?// if($value['totalArea']) echo 'пл. '.$value['totalArea'].' м<sup>2</sup>'; ?>
                    <?=Yii::app()->app->mb_ucfirst($dscrp);?>
                </div>
                <div class = 'agent_urlTd'>
                    <? if($value['agent'] == 2) echo 'Агентство';?>
                </div>
            </a>
        </div>
        <div class = 'dateTd'>
            <div class = 'browse' style = 'display:none;'>Смотрел</div>
            <?php echo Yii::app()->app->formatDate($value['dateTime']);?>
        </div>
        <!-- всплывающий комметарий -->

    </div>
<? endforeach; ?>
<div class = 'boxPaginator'>
    <div class = 'countShowPages'>
        <span>Показывать по:</span>
        <select name = 'countSP' id = 'countSP'>
            <option value = '20'>20</option>
            <option value = '50'>50</option>
            <option value = '100'>100</option>
        </select>
        <span>объектов</span>
    </div>
    <div class = 'paginator'>
        <?php $this->widget('CLinkPager', array('pages' => $pages,)) ?>
    </div>
</div>