<?php $this->breadcrumbs=array('Публикация'=>array('index'),'Таймер',);?>
<?php if(count($timer) == 0) : ?>

   <form action = '/index.php?r=publication/TSave' method = 'Post'>
       <input name = 'userId' value = '<?=Yii::app()->user->id;?>' type = 'hidden'>
       <div class="row formPublic" id = "catChild">
            <select name = 'timer'>
            <? foreach($select as $key => $value) : ?>
               <option value = '<?=$key;?>'><?=$value[1];?></option>
            <? endforeach;?>
            </select>
       </div>
       <input type = 'submit' value = 'Сохранить'>
   </form>

<?php else: ?>

<form action = '/index.php?r=publication/TDel' method = 'Post'>
      <input type = 'hidden' name = 'key' value = '<?=$timer['key'];?>'>
      <div class = ''>Таймер устнановлен на публикацию - <?=$timer['time'];?></div>
      <div class = 'buttonTimer'>
           <input type = 'submit' value = 'Изменить'>
      </div>
</form>
<?php endif;?>