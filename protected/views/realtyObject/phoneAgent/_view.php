<? foreach($data as $key => $value) : ?>
   <? if($value['objectid']) : ?>
   <?
     $post = new realtyObject;
     $data = $post::model()->findBySql('SELECT title, idCat FROM table_object WHERE id = :num',array(':num' => $value['objectid']));
     // формируем ссылку
     $link = Yii::app()->createUrl('realtyObject/view&cat='.$data['idCat'].'&id='.$value['objectid']);
     // обрезаем заголовок
     $title = mb_substr($data['title'],0,50,'utf-8');

     $pattern = array(')','(','+','-',' ');
     $phone = str_replace($pattern,'',$value['phone']);

   ?>
   <div class = 'PhoneAgentItem' item = '<?=$value["objectid"];?>'>
   	    <div class = 'tdPaItem_0'><input type = 'checkbox' class="example_check" name = 'cbname3[]' value="<?=$value['objectid'];?>"></div>
   	    <div class = 'tdPaItem_1'><?=$phone;?></div>
   	    <div class = 'tdPaItem_2'><a target = '_blank' href = '<?=$link;?>'><?=$title;?>...</a></div>
   	    <div class = 'tdPaItem_3'>
             <div class = 'bphone update' id = 'clickAgent' action = '1'>Агент</div>
   	    </div>
   	    <div class = 'tdPaItem_3'>
             <div class = 'bphone error' id = 'clickAgent' action = '2'>Нет</div>
   	    </div>
   </div>
<? endif; ?>
<? endforeach;?>
