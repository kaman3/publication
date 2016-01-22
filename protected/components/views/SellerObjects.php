<div class = 'interesting'>
    <?
    ($NameDealer) ? $name = $NameDealer : $name = 'этого продавца';
    ?>
    <div class = 'interestingHeader'>Другие предложения
        <span class="hint  hint--right  hint--info" data-hint="Другие предложения продавца">
        <? //if(!Yii::app()->user->isGuest) : ?>
            <a href = '/index.php?r=realtyObject/Offers&phone=<?=(trim($phone))?>'><?=$name;?></a>
        <? //else:?>
            <?//=$name;?>
        <?// endif; ?>
        </span>
    </div>
    <div class = 'interestingBox'>
        <? foreach ($data as $key => $value) : ?>

            <?
            $path_pars = Yii::app()->app->get_path_pars_img($value['idPars']);
            $imgPath = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/'.trim($path_pars).'/'.$value['idAds'].'/';
            $images = Yii::app()->app->get_files($imgPath);

            if(isset($images[0])){
                $img = '/pars/tmp/images/'.trim($path_pars).'/'.$value['idAds'].'/'.$images[0];
            }else{
                $img = '/pars/tmp/images/no_img_in.gif';
            }

            //$url = Yii::app()->createUrl('realtyObject/view&cat='.$value['idCat'].'&id='.$value['id']);
            $url = strtolower('/'.Yii::app()->app->getCityPach($value['city']).'/'.Yii::app()->app->translit($value['title'].'_ob_'.$value['idCat'].'_'.$value['id']).'.html');

            ($value['price']) ? $price = number_format($value['price'],0,'',' ').' руб.' : $price = '';

            ?>
            <div class = 'itemInteresting'>
                <div class = 'imgItemInt'>
                    <a href = '<?=$url;?>' title = '<?=$value['title'];?>'><img src = '<?=$img;?>' alt = '<?=$value['title'];?>' width = '180px'></a>
                </div>
                <div class = 'headerItemInt'>
                    <a href = '<?=$url;?>' title = '<?=$value['title'];?>'><?=mb_substr($value['title'],0,50,'utf-8');?></a>
                </div>

                <? if($value['price']) : ?>
                    <div class = 'priceItemInt'>
                        <div class = 'priceItemIntLabel_2'><?=$price;?></div>
                    </div>
                <? endif;?>
            </div>
        <? endforeach; ?>
    </div>
    <? //if(!Yii::app()->user->isGuest) : ?>
        <div class = 'offersbottom'>
            <span class = 'aoffers'><a href = '/index.php?r=realtyObject/Offers&phone=<?=trim($value['phone']);?>'>Все предложения</a></span>
        </div>
    <? //endif; ?>
</div>