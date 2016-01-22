<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/reveal/js/jquery.reveal.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/application.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/scripts/reveal/css/reveal.css"/>
<div class = 'searchBox'>
    <form action = '/' method = 'get'>
        <input type = 'hidden' name = 'r' value = 'realtyObject'>
        <div class = 'searchBlockFront'>
            <select name = 'cat' id = 'realtyCat'>
                <option value = '0'>-- Выберите категорию --</option>
                <? foreach($dataSearch['category'] as $value) :?>
                    <? if($value['parent'] == 0) : ?>
                        <? ($value['idCat'] == trim($_GET['cat'])) ? $selected = 'selected' : $selected = ''; ?>
                        <option style = 'background:#d9d9d9;' <?=$selected;?> value = '<?=$value['idCat']?>'><?=$value['name']?></option>
                    <? endif; ?>
                    <? foreach ($dataSearch['category'] as $key => $value2) : ?>
                        <? if($value['idCat'] == $value2['parent']) : ?>
                            <? ($value2['idCat'] == trim($_GET['cat'])) ? $selected2 = 'selected' : $selected2 = ''; ?>
                            <option <?=$selected2;?> value = '<?=$value2['idCat']?>'><?=$value2['name']?></option>
                        <? endif; ?>
                    <? endforeach?>
                <? endforeach; ?>
            </select>
        </div>
        <div class = 'searchBlockFront'>
            <select name = 'city' id = 'city'>
                <option value = '0'>-- Выберите город --</option>
                <? foreach($dataSearch['city'] as $value) :?>
                    <? ($value['id'] == trim($_GET['city'])) ? $selected = 'selected' : $selected = ''; ?>
                    <option <?=$selected;?> value = '<?=$value['id']?>'><?=$value['name']?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class = 'searchBlockFront'>
            <div class = 'changeMicrodistroct'>
                <div class = 'bottomMicrDis'>
                    <a href="#" data-reveal-id="myModal">Выбрать микрорайон</a>
                </div>
                <div class = 'countElementMdistr' style = 'opacity:0;'>0</div>
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

        <div class = 'searchBlockButton'>
            <input type = 'submit' value = 'Найти'>
        </div>
    </form>
</div>