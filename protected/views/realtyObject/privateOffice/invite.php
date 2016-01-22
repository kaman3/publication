<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/maskInput/mask.js"></script>
<div class = 'boxOffice'>
    <div class="newCollLeft">
        <?php $this->widget('menuOffice'); ?>
    </div>
    <div class="newCollRight">
        <? if(Yii::app()->app->resolutionInvite() > 0) : ?>

        <? if($_GET['act'] != 1) : ?>
        <div class = 'message mp'>
            <p>Здесь вы можете пригласить друга и получить бонусный пакет для публикации объявлений в автоматическом режиме на сайт bazarpnz.ru</p>
            <p>Бонусы будут начислены после того как приглашенный вами человек оплатит пакет для публикации объявлений.</p>
            <p>Если он произведет оплату на сумму 1000 рублей, вы получите возможность  400 раз публиковать свои объявления на сайт bazarpnz.ru бесплатно.</p>
            <p>На суму 500 рублей, 200 раз.</p>
            <p>На суму 250 рублей, 80 раз.</p>
        </div>

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
            <?php echo $form->labelEx($model,'phone_to'); ?>
            <?php echo $form->textField($model,'phone_to',array('size'=>60,'maxlength'=>250)); ?>
            <?php echo $form->error($model,'phone_to'); ?>
        </div>

        <div class="row formPublic">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>250)); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row buttons addads">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Пригласить' : 'Изменить'); ?>
        </div>

       <?php $this->endWidget(); ?>

      </div>

       <? else : ?>
            <div class = 'successMess' style = 'width: 100%'>
                Вы пригласили друга. После того как он пополнит баланс вам будут начислены бонусы.<br><br>
                <a href = '/index.php?r=realtyObject/invite'>Пригласить еще...</a>
            </div>
       <? endif; ?>

       <? else: ?>
            <div class = 'message mp'>
                Для того чтобы пригласить друга вам нужно <a href = "/index.php?r=realtyObject/OfficePayment">пополнить баланс</a>
            </div>
       <? endif; ?>
    </div>

</div>
<script type="text/javascript">
    jQuery(function($){
        $("#TableInvite_phone_to").mask("+7 (999) 999-9999");
    });
</script>