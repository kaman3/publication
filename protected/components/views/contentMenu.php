<div class = 'boxCMenu'>
   <h3 class = 'headerCmenu'>Каталог статей</h3>
   <ul>
   <? foreach($dataSearch as $key => $value) : ?>
   <?
      // $url = '/index.php?r=content&cat='.$value['id'];
      $url = strtolower('/statyi/'.Yii::app()->app->translit($value['name']).'-id'.$value['id'].'.html');

   ?>
         <li><a href = '<?=$url;?>' title = '<?=$value['name'];?>'><?=$value['name'];?></a></li>
   <? endforeach;?>
   </ul>
</div>