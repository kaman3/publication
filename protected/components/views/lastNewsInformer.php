<div class = 'lastNewsInformer'>
     <h6>Последние новости</h6>
     <? foreach($data as $key => $value) : ?>
        <?
         $imgPath = $_SERVER['DOCUMENT_ROOT'].'/images/content/'.$value['id'].'/';
         $images = Yii::app()->app->get_files($imgPath);

         $img = '/images/content/'.$value['id'].'/'.$images[0];
         $url = strtolower('/statyi/'.Yii::app()->app->translit($value['title']).'-'.$value['id'].'.html');
        ?>
         <div class = 'item_ln_informer'>
              <div class = 'item_ln_img'>
                  <a href = '<?=$url;?>'><img src = '<?=$img;?>' alt = '<?=$value['title'];?>' width="45px;"></a>
              </div>
              <div class = 'item_ln_text'>
                   <a href = '<?=$url;?>' title = '<?=$value['title'];?>'><?=$value['title'];?></a>
              </div>
         </div>
     <? endforeach; ?>
</div>