<?
if(count($data) > 0) :
    foreach($data as $key => $value) :?>

    <?
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

       $url = Yii::app()->createUrl('realtyObject/update&id='.$value['id'].'&manager='.$value['url_manager']);
       $url_view = Yii::app()->createUrl('realtyObject/view&cat='.$value['idCat'].'&id='.$value['id']);

       // расположение объекта
       $city =  Yii::app()->app->getCity($value['district']);
       $district = Yii::app()->app->getDistricts($value['district']);
       $microdistrict = Yii::app()->app->getMicrodistrict($value['microdistrict']);

       $show = Yii::app()->createUrl('realtyObject/show&id='.$value['id'].'&show='.$value['view'].'&page='.$_GET['page']);

        if($value['view'] == 1){
           $iconShow = '/images/office/eye.png';
           $hint_show = 'Снять с публикации';
       }else{
           $iconShow = '/images/office/eye_closed.png';
           $hint_show = 'Опубликовать';
       }


       ?>
       <div class = 'field_myAds'>
          <div class = 'myAds_td ccheck'>
              <input type="checkbox" class="example_check" name="cbname3[]" value="<?=$value['id'];?>" >
          </div>
          <div class = 'myAds_td price'><?=$price;?></div>
            <div class = 'myAds_td img'>
               <div class = 'hiddenImg'>
                    <a href = '<?=$url_view;?>'>
                       <img src = '<?=$img;?>'>
                    </a>
               </div>

           </div>
           <div class = 'myAds_td header'>
               <a href = '<?=$url_view;?>'>
                   <div><?=mb_substr($value['title'],0,50,'utf-8');?></div>
                      <div class = 'address_urlTd'>
                         <? if($district) echo "р-н ".trim($district).', ';?>
                         <? if($microdistrict) echo 'мк-рн '.trim($microdistrict).', ';?>
                         <? if($value['street']) echo trim($value['street']).', '; ?>
                         <? if($value['totalArea']) echo 'пл. '.$value['totalArea'].' м<sup>2</sup>'; ?>
                   </div>
                </a>
           </div>
           <div class = 'myAds_td edit'>
                <div class = 'edit_item'>
                     <span class="hint  hint--top  hint--info" data-hint="Редактировать">
                        <a href = '<?=$url;?>'>
                           <img src = '/images/office/read.png'>
                        </a>
                     </span>
                </div>
                <div class = 'edit_item'>
                     <span class="hint  hint--top  hint--info" data-hint="<?=$hint_show;?>">
                         <a href = '<?=$show;?>'>
                             <img src = '<?=$iconShow;?>'>
                         </a>
                     </span>
                </div>
                <div class = 'edit_item' id = 'remove_edit' idAds = '<?=$value['idAds'];?>'>
                     <span class="hint  hint--top  hint--info" data-hint="Удалить">
                         <a href = '#'>
                            <img src = '/images/office/remove.png'>
                         </a>
                     </span>
                </div>
           </div>
       </div>

    <? endforeach;?>
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
<? else:?>
    <div class = ''>Пока у вас нет объявлений.</div>
    <div class = 'button_new_ads'>
         <a href = '/index.php?r=realtyObject/create'>Подать объявление</a>
    </div>
<? endif;?>