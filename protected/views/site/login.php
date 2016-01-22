<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = 'Вход';

?>
<? if(!Yii::app()->user->isGuest) : ?>
<script>
    document.location.href = '/index.php?r=publication/index';
</script>
<? endif; ?>

  <div class = 'lBox'>
       <div class = 'lBoxForm'>
            <div class = 'lBoxHeader'>Войти на сайт</div>
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'login-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                )); ?>

                <div class="row inputTextStyle">
                    <?php echo $form->labelEx($model,'Номер телефона в формате (+79378788787) <span class="required">*</span>'); ?>
                    <?php echo $form->textField($model,'username',array('value'=>'+7')); ?>
                    <?php echo $form->error($model,'username'); ?>
                </div>

                <div class="row inputTextStyle">
                    <?php echo $form->labelEx($model,'Пароль <span class="required">*</span>'); ?>
                    <?php echo $form->passwordField($model,'password'); ?>
                    <?php echo $form->error($model,'password'); ?>

                </div>

                <div class = 'reBoxRem'>
                    <div class="row rememberMe boxRestore">
                         <?php echo $form->checkBox($model,'rememberMe'); ?>
                         <?php echo $form->label($model,'rememberMe'); ?>
                         <?php echo $form->error($model,'rememberMe'); ?>
                    </div>
                    <div class = 'boxRestore'>
                        <a href = '/index.php?r=site/restore'>Забыли пароль?</a>
                    </div>
                </div>


                <div class="row buttons auth">
                    <?php echo CHtml::submitButton('Вход'); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
       </div>
  </div>
  <div class = 'lBoxReg'>
       Еще не зарегистрированы? <a href = '/index.php?r=User/default/registration'>Регистрация</a>
  </div>


