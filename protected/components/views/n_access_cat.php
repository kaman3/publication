<div class = 'learn_access'>
<? foreach($c as $name_user => $value) : ?>
   <div class = 'box_guest_cat_note'>
        <div class = 'header_gcn'><b>Вам открыл доступ:</b> +<?=Yii::app()->app->nameUser($name_user);?></div>
        <? foreach($value as $$key => $id) : ?>
            <? $url = Yii::app()->createUrl('realtyObject/viewAccessNote&user='.$name_user.'&cat='.$id.'');?>
            <? $title_ = Yii::app()->app->nameNoteCat($id);?>
            <? (strlen($title_) > 25) ? $title = mb_substr($title_,0,25,'utf-8') : $title = $title_;?>
            <div class = 'item_gcn'>
                <div class = 'header_item_gcn'>
                     <a href = '<?=$url;?>'><?=$title;?></a>
                </div>
                <div class = 'li_remove_bcnb' id = 'rgn' cat = '<?=$id;?>' user = '<?=Yii::app()->user->id;?>'>
                    <span class="hint  hint--right  hint--info" data-hint="Удалить">
                      <img src="/images/notebook/up_remove.png" width="20px">
                    </span>
                </div>
            </div>
        <? endforeach; ?>
   </div>
<? endforeach; ?>
</div>
