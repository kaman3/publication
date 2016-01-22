<div class = 'timer'>Здравствуйте, вы первый раз на сайте, необходимо подтвердить номер телефона указанный при регистрации.</div>
<div class = 'timer'>На ваш номер <span style = 'color:red;'><?=$phone; ?></span> был выслан секретный код.</div>
<div class = 'timer'>Код действителен в течении: <span id="timer" long="07:00">07:00</span></div>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'intensification-form',
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