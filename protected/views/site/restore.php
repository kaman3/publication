<?
$this->pageTitle = 'Восстановление пароля';
?>
<? if(!Yii::app()->user->isGuest) : ?>
    <script>
        document.location.href = '/index.php?r=publication/index';
    </script>
<? endif; ?>
<div class = 'line_bar_top'></div>


<div class = 'lBox'>
    <div class = 'lBoxForm'>
        <div class = 'lBoxHeader'>Восстановление доступа</div>
        <? if($model) : ?>
        <div class = 'rsMess'>
           <p><?=$model;?></p>
           <p><a href = '/'>Вернуться на глвную</a></p>
        </div>
        <? else: ?>
            <div class = 'rsMess'>Введите адрес электронной почты, который был указан при регистрации.</div>
            <form action="/index.php?r=site/restore" method="Post">
                <div class = 'row inputTextStyle'>
                   <input type = 'text' name = 'email'>
                </div>
                <div class = 'buttons auth'>
                   <input type = 'submit' value="Сбросить">
                </div>
            </form>
        <? endif; ?>

    </div>
</div>
<div class = 'lBoxReg'>
     <a href = '/index.php?r=site/login'>Войти</a>
</div>