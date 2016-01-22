<div class = 'message mp'>
    Пользователь с указаным вами номером телефона будет зарегистрирован на сайте! Автоматически ему будет отправленна смс с логином паролем!</br>
    Если пользователь с таким номером существует он не будет добавлен.
</div>

<div class = 'form nUserNevForm'>
    <div class = 'headerNewUser'>Создание нового пользователя</div>
    <!--<form action="/index.php?r=realtyObject/NewUserSave" method="post">-->
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'newUser',
            'enableAjaxValidation'=>true,
            'action' => $this->createUrl('realtyObject/NewUser'),

        )); ?>
        <div class="row inputTextStyle">
            <!--<input type = 'text' name = 'phone' id = 'phone' placeholder = 'Введите номер телефона'>-->
            <?php echo $form->label($model, 'Номер телефона', array('class' => 'required')); ?>
            <?php echo $form->textField($model, 'phone')?>
            <?php echo $form->error($model,'phone'); ?>
        </div>

        <div>
            <?=CHtml::submitButton('Создать', array('id' => "submit")); ?>
        </div>
    <!--</form>-->
    <?php $this->endWidget(); ?>
</div>

<div class = 'nUserList'>
    <div class = 'headerNewUser'>Добавленные пользователи</div>
    <? foreach($userList as $key => $value) :?>
       <div class = 'nTableNu'>
          <div class = 'nStr'><?=Yii::app()->app->format_phone($value['phone']);?></div>
          <div class = 'nDate'><?=Yii::app()->app->formatDate($value['datePayment']);?></div>
       </div>
    <? endforeach; ?>
    <div class = 'paginator nuslpag'><?php $this->widget('CLinkPager', array('pages' => $pages,)) ?></div>
</div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/maskInput/mask.js"></script>
<script type="text/javascript">
    jQuery(function($){
        $("#newUser_phone").mask("+7 (999) 999-9999");
    });
</script>
