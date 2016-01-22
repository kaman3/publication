<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/maskInput/mask.js"></script>

<h1>Регистрация</h1>
 
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'user-form',
            'enableAjaxValidation'=>true,
    )); ?>
 
    <p class="note">Поля отмеченные <span class="required">*</span> обязательны.</p>
 
    <?php echo $form->errorSummary($model); ?>

   <!-- <div class="row rememberMe test">
        <?php// echo $form->checkBox($model,'test'); ?>
        <?php// echo $form->label($model,'test'); ?>
        <?php// echo $form->error($model,'test'); ?>
    </div>-->

    <div class="row inputTextStyle">
        <?php echo $form->label($model, 'Номер телефона <span class="required">*</span>', array('class' => 'required')); ?>
        <?php echo $form->textField($model, 'phone')?>
        <?php echo $form->error($model,'phone'); ?>
    </div>
 
    <div class="row inputTextStyle">
        <?php echo $form->label($model, 'Ваш email <span class="required">*</span>', array('class' => 'required')); ?>
        <?php echo $form->textField($model, 'email')?>
        <?php echo $form->error($model,'email'); ?>
    </div>
    <!--
    <div class="row inputTextStyle">
        <?php //echo $form->label($model, 'Логин <span class="required">*</span>'); ?>
        <?php //echo $form->textField($model, 'username' )?>
        <?php //echo $form->error($model,'username'); ?>
    </div>
    -->
    <div class="row inputTextStyle">
        <?php echo $form->label($model, 'Пароль <span class="required">*</span>'); ?>
        <?php echo $form->passwordField($model, 'password') ?>
        <?php echo $form->error($model,'password'); ?>
    </div>
 
    <div class="row inputTextStyle">
        <?php echo $form->label($model, 'Пароль еще раз <span class="required">*</span>'); ?>
        <?php echo $form->passwordField($model, 'password2') ?>
        <?php echo $form->error($model,'password2'); ?>
    </div>
 
    <div class="row inputTextStyle">
        <?php $this->widget('CCaptcha', array('buttonLabel' => '<br>[новый код]')); ?>
        <?php echo $form->label($model, 'результат <span class="required">*</span>'); ?>
        <?=CHtml::activeTextField($model,'captcha'); ?>
    </div>
 
    <div class="row submit">
        <?=CHtml::submitButton('Зарегистрироваться', array('id' => "submit")); ?>
    </div>
 
    <?php $this->endWidget(); ?>
</div><!-- form -->
<script type="text/javascript">
    jQuery(function($){
        $("#User_phone").mask("+7 (999) 999-9999");
    });
</script>