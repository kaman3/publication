<?php if($this->beginCache($id,array('duration'=>3600))) { ?>
<div class = 'gBoxMicrodistricts'>
<? foreach($dataSearch['microdistricts'] as $key => $value) : ?>
   <?
   $title = strtolower(Yii::app()->app->translit(Yii::app()->app->getTransaction(2)."_".Yii::app()->app->getH1(1)."_".Yii::app()->app->getMicrodistrict($value['id'])));
   //$url = "/?r=realtyObject&chpu=".$title."&cat=1&microdistricts%5B%5D=".$value['id']."&transaction=2";
    $url = $title."-1-2-".$value['id'].'.html';
   ?>
   <div class = 'gbmLinks'><a href = '<?=$url;?>' title="Купить квартиру <?=$value['name'];?> Пенза"><?=$value['name'];?> </a></div>
<? endforeach;?>
</div>
<?php $this->endCache(); } ?>


