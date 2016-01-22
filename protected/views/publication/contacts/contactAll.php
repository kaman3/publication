<?php $this->breadcrumbs=array('Публикация'=>array('index'),'Контакты',);?>



<div class = 'bCcreate'>
    <a href = '/index.php?r=publication/contactAdd'>Новый контакт</a>
</div>

<div class = 'box_all_contacts'>
    <ol>
    <? foreach($data as $key => $value):?>
        <?
           if($value['show'] == 1){ // показать контакты
              $show = '/publish/resources/images/eyeShow.png';
              $textHelp = 'Сейчас Email и Имя видны в объявлении';
           }else{
              $show = '/publish/resources/images/eye.png';
              $textHelp = 'Сейчас Email и Имя скрыты';
           }
        ?>

        <li class = 'ba_items'>
              <div class = 'td_ba_items t4'>
                  <a href = '/index.php?r=publication/contactAdd&id=<?=$value['id'];?>'>
                      <span class="hint  hint--top  hint--info" data-hint="Редактировать">
                          <img src = '/publish/resources/images/read.png'>
                       </span>
                  </a>
               </div>
               <div class = 'td_ba_items t1'>
                   <a href = '/index.php?r=publication/contactAdd&id=<?=$value['id'];?>'>
                       <?=$value['name'];?>
                   </a>
               </div>
               <div class = 'td_ba_items t2'><?=$value['phone'];?></div>
               <div class = 'td_ba_items t3'><?=$value['email'];?></div>

               <div class = 'td_ba_items t5' id = 'delContacts' item = '<?=$value['id'];?>'>
                   <a href = '#'>
                      <span class="hint  hint--top  hint--info" data-hint="Удалить">
                          <img src = '/publish/resources/images/basket.png'>
                      </span>
                   </a>
               </div>
               <div class = 'td_ba_items t6'>
                    <a href = '/index.php?r=publication/ShowContact&id=<?=$value["id"];?>&show=<?=$value["show"];?>'>
                        <span class="hint  hint--top  hint--info" data-hint="<?=$textHelp;?>"><img src = '<?=$show;?>'></span>
                    </a>
               </div>

        </li>
    <? endforeach;?>
    </ol>
</div>