<div class = 'brdcrumbs'>
     <?php $this->breadcrumbs=array('Публикация'=>array('index'),'Контакты'=>array('publication/contact'));?>
</div>

<div class = 'form'>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'TablePublicContacts-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>
    <div class="row">
        <?php echo $form->hiddenField($model, 'userId',array('value'=>Yii::app()->user->id)); ?>
    </div>
    <div class = 'box_contacts'>
       <div class = 'bc_bazar'>
        <div class="row formPublic">
           <?php echo $form->labelEx($model,'name'); ?>
           <?php echo $form->textField($model,'name'); ?>
           <?php echo $form->error($model,'name'); ?>
        </div>

        <div class="row formPublic">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email'); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row formPublic">
             <?php echo $form->labelEx($model,'phone'); ?>
             <?php echo $form->textField($model,'phone'); ?>
             <?php echo $form->error($model,'phone'); ?>
        </div>
           <div class = 'message'>
               Внимание!!!
               Уважаемые пользователи убедительная просьба добавляйте только один номер телефона. Это поможет нашим сотрудникам более качественно выполнять свою работу!
           </div>
        </div>
        <!--
    <div class = 'bc_avito'>
         <div class = 'headerContact'>Авито</div>

         <div class="row formContact">
              <?php //echo $form->labelEx($model,'password_avito'); ?>
              <?php //echo $form->textField($model,'password_avito'); ?>
              <?php //echo $form->error($model,'password_avito'); ?>
         </div>
    </div>
        -->
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

<? $this->endWidget(); ?>
</div>