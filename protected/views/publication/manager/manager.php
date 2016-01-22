<?php $this->widget('application.components.managerFilter'); ?>
<div class = 'boxManager'>
    <div class = 'headerManagerLabel'>
        <div class = 'itemManLabel idLabelM hml' style = 'text-align: center'>id</div>
        <div class = 'itemManLabel userLabelM hml'>Логин</div>
        <div class = 'itemManLabel dateLabelM hml'>Дата последней оплаты</div>
        <div class = 'itemManLabel countLabelM hml'>Оплачено</div>
        <div class = 'itemManLabel residLabelM hml'>Остаток</div>
        <div class = 'itemManLabel phoneLabelM hml'>Телефон</div>
    </div>
   <? foreach($dataProvider as $key => $value) : ?>
   <?
    ($value['residPublic'] == 0) ? $distinguish = 'style = "background: #ffced5;"' : $distinguish = '';

   ?>
    <div class = 'managerItem ' <?=$distinguish;?>>
         <div class = 'itemManLabel idLabelM'><?=$value['id'];?></div>
         <div class = 'itemManLabel userLabelM'><?=$value['username'];?></div>
         <div class = 'itemManLabel dateLabelM'><?=Yii::app()->app->formatDate($value['datePayment']);?></div>
         <div class = 'itemManLabel countLabelM'><?=$value['countPay'];?></div>
         <div class = 'itemManLabel residLabelM'><?=$value['residPublic'];?></div>
         <div class = 'itemManLabel phoneLabelM'><?=Yii::app()->app->format_phone($value['phone']);?></div>
    </div>
   <? endforeach;?>

</div>
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