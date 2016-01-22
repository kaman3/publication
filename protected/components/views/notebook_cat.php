<div class = 'boxCategory_nb'>
    <? foreach($data as $key => $value) : ?>
       <? (strlen($value['name']) > 25) ? $title = mb_substr($value['name'],0,25,'utf-8') : $title = $value['name'];?>
       <? $url = Yii::app()->createUrl('realtyObject/notebook&cat='.$value['id'].'');?>
       <div class = 'ul_bcnb' id = '<?=$value['id'];?>'>
            <div class = 'li_name_bcnb'>
                <a href = '<?=$url;?>'><?=$title;?></a>
                <input id = 'up_input_title' type = 'text' value="<?=$title?>">
            </div>
            <div class = 'li_upd_bcnb' read = '0'>
                <span class="hint  hint--right  hint--info" data-hint="Изменить">
                      <img src = '/images/notebook/up_notebook.png' width="20px">
                </span>
            </div>
            <div class = 'li_remove_bcnb'>
                <span class="hint  hint--right  hint--info" data-hint="Удалить">
                      <img src = '/images/notebook/up_remove.png' width="20px">
                </span>
            </div>
            <div class = 'cheked_item_note'></div>
       </div>
    <? endforeach;?>
</div>
