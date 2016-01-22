<div class = 'content_view'>
   <? foreach($data as $key => $value) : ?>
      <?
         //$url = "/index.php?r=content/view&title=".$value['title']."&id=".$value['id'];
         $url = strtolower('/statyi/'.Yii::app()->app->translit($value['title']).'-'.$value['id'].'.html');
       ?>
      <?
         $paht = $_SERVER['DOCUMENT_ROOT'].'/images/content/'.$value['id'].'/'.$value['id'].'.jpg';

         if(file_exists($paht)){
           $img = '/images/content/'.$value['id'].'/'.$value['id'].'-small.jpg';
         }else{
           $img = '/pars/tmp/images/no_foto.gif';
         }
      ?>
      <div itemscope itemtype="http://schema.org/Article" class = 'item_view_content'>
           <div class = 'img_ivc'>
                <a href = '<?=$url;?>'><img src = '<?=$img;?>' width="140px" alt = '<?=$value['title'];?>'></a>
           </div>
           <div class = 'text_ivc'>
                <div class = 'header_ivc'>
                    <span><?php echo Yii::app()->app->formatDate($value['dateTime']);?></span>
                    <a href = '<?=$url;?>' title = '<?=$value['title'];?>'><?=$value['title'];?></a>
                </div>
                <div class = 'description_ivc'><?=mb_substr($value['description'],0,150,'utf-8').'...';?></div>
           </div>
      </div>
   <? endforeach; ?>
</div>