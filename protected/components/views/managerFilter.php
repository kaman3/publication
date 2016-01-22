<div class = 'managerFilter'>
     <form action="" method="get">
           <input type = 'hidden' name = 'r' value="publication/manager">
           <div class = 'mfInputLp'>
                <input type = 'text' name = 'loginPhone' placeholder="Номер телефона или логин" value="<?=$_GET['loginPhone'];?>">
           </div>
           <div class = 'mfInputRes'>
                <input type = 'text' name = 'countPay' placeholder="Оплачено" value="<?=$_GET['countPay'];?>">
           </div>
           <div class = 'mfInputRes'>
                <input type = 'text' name = 'resid' placeholder="Остаток" value="<?=$_GET['resid'];?>">
           </div>
           <div class = 'mfInputSelect'>
                <select name = 'ostatok'>
                    <option  value="">Осталось меньше</option>
                    <? foreach($select as $key => $value) : ?>
                       <? ($_GET['ostatok'] == $value ) ? $selected = 'selected' : $selected = ''; ?>
                       <option <?=$selected;?> value="<?=$value;?>">меньше <?=$value;?></option>
                    <? endforeach;?>
                </select>
           </div>
           <div class = 'mfButton'>
                <input type="submit" value="Поиск">
           </div>

     </form>
</div>