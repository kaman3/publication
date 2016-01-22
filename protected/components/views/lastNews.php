<div class = 'lastNews'>
   <h3 class="headerCmenu">Читайте также</h3>
   <ul>
   <? foreach($data as $key => $value) : ?>
      <? $url = strtolower('/statyi/'.Yii::app()->app->translit($value['title']).'-'.$value['id'].'.html'); ?>
      <li><a href = '<?=$url;?>' title="<?=$value['title'];?>"><?=$value['title'];?></a></li>
   <? endforeach;?>
   </ul>
</div>