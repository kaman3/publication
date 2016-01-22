<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/scripts/htmlSlider/htmlSlider.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/htmlSlider/htmlSlider.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/timeago/jquery.timeago.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/timeago/jquery.timeago.ru.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        jQuery("abbr.timeago").timeago();
    });
</script>

<div class = 'headerVSlider'><h2>Новые объявления по продаже недвижимости в Пензе</h2></div>
<div class="slider">
    <div class="slide-list">
        <div class="slide-wrap">

            <? foreach ($data as $key => $value) : ?>

                <?
                $path_pars = Yii::app()->app->get_path_pars_img($value['idPars']);
                $imgPath = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/'.trim($path_pars).'/'.$value['idAds'].'/small/';
                $images = Yii::app()->app->get_files($imgPath);

                if(isset($images[0])){
                    $img = '/pars/tmp/images/'.trim($path_pars).'/'.$value['idAds'].'/small/'.$images[0];
                }else{
                    $img = '/pars/tmp/images/no_img_in.gif';
                }

                //$url = Yii::app()->createUrl('realtyObject/view&cat='.$value['idCat'].'&id='.$value['id']);
                //$url = strtolower('/'.Yii::app()->app->getCityPach($value['city']).'/'.Yii::app()->app->translit($value['title'].'_ob_'.$value['idCat'].'_'.$value['id']).'.html');
                $url = strtolower(Yii::app()->app->getCatPach(trim($value['idCat'])).'_'.$value['idCat'].'.html');

                ($value['price']) ? $price = number_format($value['price'],0,'',' ').' руб.' : $price = '';

                ?>
            <div class="slide-item">
                <div class = 'itemInteresting'>
                    <div class = 'imgItemInt'>
                        <a href = '<?=$url;?>' title = '<?=$value['title'];?>'><img src = '<?=$img;?>' alt = '<?=$value['title'];?>' width = '180px'></a>
                    </div>
                    <div class = 'headerItemInt'>
                        <a href = '<?=$url;?>' title = '<?=$value['title'];?>'><?=mb_substr($value['title'],0,50,'utf-8');?></a>
                    </div>

                    <? if($value['price']) : ?>
                        <div class = 'priceItemInt'>
                            <div class = 'timeagoBox'>Добавлено: <abbr class="timeago" title="<?=$value['dateTime'];?>"></abbr></div>
                            <div class = 'priceItemIntLabel_2'><?=$price;?></div>
                        </div>
                    <? endif;?>
                </div>
            </div>
            <? endforeach; ?>


        </div>
        <div class="clear"></div>
    </div>
    <div name="prev" class="navy prev-slide"></div>
    <div name="next" class="navy next-slide"></div>
    <div class="auto play"></div>
</div>

