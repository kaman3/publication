<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/maskInput/mask.js"></script>
<div class = 'boxOffice'>
    <div class="newCollLeft">
        <?php $this->widget('menuOffice'); ?>
    </div>
    <div class="newCollRight">
        <div class = 'message mp'>
            Настройки вашего аккаунта. Здесь вы можете изменить логин и пароль.<br>
            <? if(!$model->email) : ?>
            Рекомендуем вам добавить e-mail, он понадобиться для востановления данных если вы забудите логин либо пароль.
            <? endif; ?>
        </div>
        <? if($_GET['mess'] == 1) : ?>
           <div class = 'successMess'>
               Настройки аккаунта успешно изменены.
           </div>
        <? endif;?>
        <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'option',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        ));
       ?>

        <div class="row formPublic">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>250)); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row formPublic">
            <?php echo $form->labelEx($model,'username'); ?>
            <?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>250)); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>

        <div class="row formPublic">
            <input type = 'password' name = 'UserOption[password]' value = '' placeholder="Если хотите сменить пароль, введите новый">
        </div>


        <div class="row buttons addads">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить'); ?>
        </div>
       <?php $this->endWidget(); ?>
       </div>

    </div>
</div>
<script type="text/javascript">
    jQuery(function($){
        $("#UserOption_username").mask("+7 (999) 999-9999");
    });
</script>