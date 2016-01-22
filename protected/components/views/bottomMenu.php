<?php if($this->beginCache($id,array('duration'=>3600))) { ?>

<? foreach($dataSearch['category'] as $key => $value): ?>

         <? if($value['parent'] == 0) : ?>
         <?php //echo Yii::app()->createUrl('realtyObject/index', array('cat'=>$value['idCat']))?>
         <? $url_1 = Yii::app()->app->getCatPach(trim($value['idCat'])).'_'.$value['idCat'].'.html'; ?>
         <div class = 'boxItemMenuFooter'>
            <ul>
              <li><a href = '/<?php echo strtolower($url_1);?>' title = 'Продам <?=$value['name'];?> в Пензе'><b><?=$value['name']; ?> </b></a></li>
         <? endif; ?>
         
         <? foreach ($dataSearch['category'] as $key => $value2) : ?>
                   
                    <? if($value['idCat'] == $value2['parent']) : ?>
                    <?php// echo Yii::app()->createUrl('realtyObject/index', array('cat'=>$value2['idCat']))?>
                    <? $url_2 = Yii::app()->app->getCatPach(trim($value2['idCat'])).'_'.$value2['idCat'].'.html'; ?>
                        <ul>
                          <li>
                             <a href = '/<?=strtolower($url_2);?>' title = 'Продам <?=$value2['name']; ?> в Пензе'><?=$value2['name']; ?></a>
                          </li>
                        </ul>
                    <? endif; ?>
         
  <? endforeach; ?> 
          </ul>
        </div>
<? endforeach; ?>
<?php $this->endCache(); } ?>

