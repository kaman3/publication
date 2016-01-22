<div class = 'menu'>
<ul>
   <? foreach($data as $value): ?>
          <? $url = Yii::app()->app->getCatPach(trim($value['idCat'])).'_'.$value['idCat'].'.html'; ?>
          <?php //$url =  Yii::app()->createUrl('/realtyObject', array('cat'=>$value['idCat'],'name'=>Yii::app()->app->getCatPach($value['idCat'])))?>
          <li>
          	 <a href = '/<?php echo strtolower($url); ?>' title = 'Купить <?=trim($value['name']); ?> в Пензе'><?=$value['name']; ?></a>
          	 <span>( <? echo Yii::app()->app->countElement(Yii::app()->app->getPathCat($value['idCat'])); ?> )</span>
          </li>
   <? endforeach;?>
</ul>
</div>
<? if($_GET['cat'] == 7 or $_GET['cat'] == 8 or $_GET['cat'] == 9 or $_GET['cat'] == 10) : ?>
    <?

      $a = array(
            5=>'Комнату',
            1=>'Однокомнатные квартиры',
            2=>'Двухкомнатные квартиры',
            3=>'Трехкомнатные квартиры',
            4=>'Многокомнатные квартиры',
      );
      $p = array(
            1=>'Однокомнатные квартиры',
            2=>'Двухкомнатные квартиры',
            3=>'Трехкомнатные квартиры',
            4=>'Многокомнатные квартиры',
      );

      ($_GET['cat'] == 9) ? $b = $a : $b = $p;

    ?>
    <div class = 'box_c_App'>
        <ul>
            <? foreach($b as $key => $value) :?>
                <?
                in_array($key, $_GET['CountRooms']) ? $checked = 'style="color:red"' : $checked = '';
                //$url_count_app = '/?r=realtyObject&cat='.$_GET['cat'].'&CountRooms%5B%5D='.$key;
                $url_count_app = strtolower('/'.Yii::app()->app->getCatPach($_GET['cat']).'-'.$_GET['cat'].'-'.$key.'-'.Yii::app()->app->translit($value).'.html');
                ?>
                <li><a <?=$checked;?> href = '<?=$url_count_app;?>' title="<?=$value;?>"><?=$value;?></a></li>
            <? endforeach; ?>
        </ul>
    </div>
<? endif; ?>
<!-- меню микрорайоны -->
<? if ($_GET['cat'] == 1 or $_GET['cat'] == 3 or $_GET['cat'] == 7 or $_GET['cat'] == 8 or $_GET['cat'] == 9 or $_GET['cat'] == 10) : ?>
    <div class = 'hideMicrodistricts'>Скрыть микрорайоны</div>
    <div class = 'boxSortMiscrodist'>
       <ul>
   <? foreach($microdistrics['microdistricts'] as $key => $value) : ?>
   <?

      ($_GET['CountRooms'][0]) ? $rooms = '&CountRooms%5B%5D='.$_GET['CountRooms'][0] : $rooms = '';

      //($value['id'] == trim($_GET['microdistricts'][0])) ? $selected = 'style="color:red"' : $selected = ''

      if(in_array($value['id'],$_GET['microdistricts'])){
          $selected = 'style="color:red"';
      }else{
          $selected = '';
      }


      $url_micro = "/?r=realtyObject&cat=".$_GET['cat']."&microdistricts%5B%5D=".$value['id'].$rooms;

       if($_GET['CountRooms'][0]){
           if($_GET['CountRooms'][0] == 1){
               $t_rooms = "однокомнатную ";
           }else if($_GET['CountRooms'][0] == 2){
               $t_rooms = "двухкомнатную ";
           }else if($_GET['CountRooms'][0] == 3){
               $t_rooms = "трехкомнатную ";
           }else if($_GET['CountRooms'][0] == 4){
               $t_rooms = "многокомнатную ";
           }
       }else{
           $t_rooms == '';
       }

       if($_GET['cat'] == 1 or $_GET['cat'] == 7 or $_GET['cat'] == 8){
          $_transaction = 'Купить ';
       }else{
          $_transaction = 'Арендовать ';
       }

       $title_href = $_transaction.$t_rooms.' квартиру в Пензе';

    ?>
              <li><a <?=$selected;?> href = '<?=$url_micro;?>' title = '<?=$title_href;?>'><?=$value['name'];?></a></li>
   <? endforeach;?>
       </ul>
   </div>

<? endif; ?>