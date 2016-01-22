<form action = '' method = 'get'>
<div class = 'boxNewSearch'>
    <div class = 'bns'>

        <input type = 'hidden' name = 'r' value="publication">
        <div class = 'lineSnew'>
            <select name = 'cat' id = 'changeCat' >
                <option value= "0" >Выберите категорию</option>
                <? foreach($dataSearch['category'] as $value) :?>

                   <? ($value['id'] == trim($_GET['cat'])) ? $selected = 'selected' : $selected = ''; ?>
                   <option <?=$selected;?> value = '<?=$value['id']?>'><?=$value['name']?></option>

                <? endforeach; ?>
            </select>
            <input type = "text" name = 'titleDisc' placeholder="текст заголовка или описание">
            <input type = "submit" value="Найти">
        </div>

    </div>

    <div class = 'butns1'>
        <? //if(Yii::app()->app->endCountAds() == 0) : ?>
        <a href = '/index.php?r=publication/create'>+ Добавить объявление</a>
        <? //endif; ?>
    </div>
</div>

<div class = 'addRow'>
    <div class = 'aRSel'>
        <select name = 'contact_id' id = 'contact_id'>
            <option value = '0'>-- Контакты --</option>
            <? foreach($dataSearch['contact'] as $value) :?>
                <? ($value['id'] == trim($_GET['contact_id'])) ? $selected = 'selected' : $selected = ''; ?>
                <option <?=$selected;?> value = '<?=$value['id']?>'><?=$value['name']?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class = 'aRSel'>
        <select name = 'transaction' id = 'transaction'>
            <option value = '0'>-- Тип сделки --</option>
            <? foreach($dataSearch['transaction'] as $value) :?>
                <? ($value['id'] == trim($_GET['transaction'])) ? $selected = 'selected' : $selected = ''; ?>
                <option <?=$selected;?> value = '<?=$value['id']?>'><?=$value['name']?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class = 'aRSel'>
        <select name = 'active'>
            <? foreach($showAdsStatus as $key => $value) : ?>
                <? ($key == trim($_GET['active'])) ? $selected = 'selected' : $selected = ''; ?>
                <option <?=$selected;?> value = '<?=$key;?>'><?=$value;?></option>
            <? endforeach;?>
        </select>
    </div>
</div>
    <!-- свои формы для разделов -->
    <div class = 'addSection' id = 'rielt' style = 'display: none'>
        <div class = 'countRoomsHide'>
            <div class = 'tbSB'>Комнат</div>
            <? foreach($countRooms as $key => $value) :?>
                <? in_array($value, $_GET['CountRooms']) ? $checked = 'checked' : $checked = ''; ?>
                <?
                //$valueLabel =  $value;

                if($value == 1){ $valueLabel = 'ok.';}
                if($value == 2){ $valueLabel = 'ст.';}
                if($value == 3){ $valueLabel = '1';}
                if($value == 4){ $valueLabel = '2';}
                if($value == 5){ $valueLabel = '3';}
                if($value == 6){ $valueLabel = '4+';}

                ?>
                <div class = 'tbCheck'><input type = 'checkbox' name = 'CountRooms[]' value = '<?=$value;?>' <?=$checked;?>><?=$valueLabel;?></div>
            <? endforeach ?>
        </div>
        <div class = 'blockSearchFront'>
            <div class = 'changeMicrodistroctFilter'>
                <div class = 'bottomMicrDisFilter'>
                    <a href="#" data-reveal-id="myModal">Выбрать микрорайон</a>
                </div>
                <div class = 'countElementMdistr' style = 'opacity:0; text-align: center;'>0</div>
            </div>
            <!-- выпадающеее окно -->
            <div id="myModal" class="reveal-modal">
                <div class = 'boxMicrodistrict'>
                    <? foreach($dataSearch['microdistricts'] as $key => $value) :?>
                        <? in_array($value['id'], $_GET['microdistricts']) ? $checked = 'checked' : $checked = ''; ?>
                        <div class = 'itemMCBox'>
                            <input id = '<?=$value['id'];?>' class = 'check' type = 'checkbox' name = 'microdistricts[]' value = '<?=$value["id"];?>' <?=$checked;?>>
                            <label for='<?=$value["id"];?>'><?=$value['name'];?></label>
                        </div>
                    <? endforeach; ?>
                </div> <!-- любые теги, любая разметка -->
                <a class="close-reveal-modal">ОK</a>
            </div>
        </div>
    </div>
</form>