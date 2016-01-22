<div class = 'sendEmail'>На ваш номер телефона <span><?=$phone; ?></span> был выслан код подтверждения. <span>Sms сообщение придет в течении 5-7 минут!</span></div>
<!--
<div class = 'sendEmail spam'><span>Если письма нет, проверьте папку спам.</span></div>
<div class = 'warningCode'>
  <p>( Внимание! Если вы используете Яндекс почту, то Вам необходимо некоторое время подождать, пока код подтверждения придет на ваш email )</p>
  <p>Если у Вас возникли какие либо проблемы, вы можете написать нам admin@rlpnz.ru</p>
</div>
-->
<div class = 'timer'>Код действителен в течении: <span id="timer" long="07:00">07:00</span></div>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'check-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div class="row inputTextStyle">
	<input type = 'hidden' name = 'idsesesion' value = '1'>
	<input type = 'text' name = 'code'>
</div>

<div>
    <a class = 'newCode' onClick="document.location.reload(true)">Получить новый код</a>
</div>

<div class="row buttons">
	 <input type = 'submit' value = 'Отправить'>
</div>

<?php $this->endWidget(); ?>

</div>

