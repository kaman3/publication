<div class = 'searchBox'>
   <form action = '/' method = 'get'>
      <!--<input type = 'hidden' name = 'cat' value = '<?=$_GET['cat'];?>'>-->

      <!--<div class = 'searchBlockFront'>
           <input type = 'text' name = 'title' placeholder = 'введите заголовок' value = '<?=$_GET['title'];?>'>
      </div>
       -->
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
          <!--
        <select name = 'districts' id = 'district'>
                      <option value = '0'>-- Выберите район --</option>
                  <? //foreach($dataSearch['districts'] as $value) :?>
                      <? //($value['id'] == trim($_GET['districts'])) ? $selected = 'selected' : $selected = ''; ?>
                      <option <?//=$selected;?> value = '<?//=$value['id']?>'><?//=$value['name']?></option>
                  <? //endforeach; ?>
        </select>
        -->
      </div>

      <div class = 'searchBlockButton'>
          <input type = 'submit' value = 'Найти'>
      </div>
      <!-- это скрытая часть поиска -->
       <? //($_GET['id']) ? $showBlock = 'none' : $showBlock = 'block'; ?>
      <div class = 'noneSearch' >
           <div class = 'searchBlock'>
              <input type = 'text' name = 'header' placeholder = 'введите заголовок' value = '<?=$_GET['header'];?>'>
           </div>
           
           <div class = 'searchBlock'>
               <select name = 'transaction'>
                   <option value = '0'>-- Выберите тип сделки --</option>
                   <? foreach($dataSearch['transaction'] as $value) :?>
                       <? ($value['id'] == trim($_GET['transaction'])) ? $selected = 'selected' : $selected = ''; ?>
                       <option <?=$selected;?> value = '<?=$value['id']?>'><?=$value['name']?></option>
                   <? endforeach; ?>
               </select>
           </div>

           <div class = 'searchBlock'>
               <input id = 'phone' type = 'text' name = 'phone' placeholder = 'номер телефона' value = '<?=$_GET['phone'];?>'>
           </div>

           <div class = 'searchBlock'>
               <input type = 'text' name = 'street' placeholder = 'улица' value = '<?=$_GET['street']?>'>
               <!--
              <select name = 'houseTypes'>
                    <option value = '0'>-- Выберите тип дома --</option>
                <? //foreach($dataSearch['houseTypes'] as $value) :?>
                    <?// ($value['id'] == trim($_GET['houseTypes'])) ? $selected = 'selected' : $selected = ''; ?>
                    <option <?//=$selected;?> value = '<?//=$value['id']?>'><?//=$value['name']?></option>
                <? //endforeach; ?>
              </select>
              -->
           </div>

           <div class = 'searchBlock'>

           </div>

           <div class = 'searchBlock'>

           </div>
 

          <div class = 'blockS_1'>
               <div class = 'searchBlock'>
                  <div class = 'tbSB'>Этажность</div>
                  <div class = 'tbSB'><input type = 'text' name = 'floor_start' value = '<?=$_GET['floor_start'];?>' placeholder = 'от'></div>
                  <div class = 'tbSB'><input type = 'text' name = 'floor_end' value = '<?=$_GET['floor_end'];?>' placeholder = 'до'></div>
               </div>

               <div class = 'searchBlock'>
                  <div class = 'tbSB'>Площадь</div>
                  <div class = 'tbSB'><input type = 'text' name = 'area_start' value = '<?=$_GET['area_start'];?>' placeholder = 'от'></div>
                  <div class = 'tbSB'><input type = 'text' name = 'area_end' value = '<?=$_GET['area_end'];?>' placeholder = 'до'></div>
               </div>

          </div>

          <div class = 'blockS_2'>
               <div class = 'searchBlockPrice'>
                 <div class = 'tbSB'>Цена</div>
                 <div class = 'tbSBq'><input id = 'mask' type = 'text' name = 'price_start' value = '<?=$_GET['price_start'];?>' placeholder = 'от'></div>
                 <div class = 'tbSBq'><input id = 'mask' type = 'text' name = 'price_end' value = '<?=$_GET['price_end'];?>' placeholder = 'до'></div>
               </div>
 
               
               <div class = 'searchBlockPrice'>
                    <div class = 'tbSB'>Комнат</div>
                    <? foreach($countRooms as $key => $value) :?>
                       <? in_array($value, $_GET['CountRooms']) ? $checked = 'checked' : $checked = ''; ?>
                       <? 
                         $valueLabel = $value;
                         if($valueLabel == 4){ $valueLabel = '4+';}
                         if($valueLabel == 5){ $valueLabel = 'ok';}
                       ?>
                       <div class = 'tbCheck'><input type = 'checkbox' id = 'group_cr' name = 'CountRooms[]' value = '<?=$value;?>' <?=$checked;?>><?=$valueLabel;?></div>
                    <? endforeach ?>
               </div>
          </div>

          <div class = 'blockS_3'>
               <div class = 'maps_header'>Карта</div>
               <div class = 'maps_select'>
                    <a href="#" data-reveal-id="myModal_maps">Область карты</a>
                    <div class = 'searchSelectMaps'>очистить</div>
               </div>
          </div>

          <div id="myModal_maps" class="reveal-modal-maps">
               <div class = 'maps_box'>
                    
                    <input type= 'button' value = 'Очистить' id = 'removePoligon'/>
                    <input type="button" value="Сохранить" id="stopEditPolyline"/>
                    <div id="geometry"></div>
                    <div id="map" style="width:800px; height:500px"></div>
                    <div class = 'message' style = 'margin-top:20px;'>
                         Кликните на карте для начала выделения нужной вам области. Для завершения нажмите на последнюю выделеную точку.
                    </div>
                    <a style = 'display:none;' class="close-reveal-modal">ОK</a>
                    <div class = 'classWindow'><img src = '/images/close.png'></div>
               </div>
          </div>

      </div>
   </form>
</div>
<div class = 'buttonViewSearch' id = 'clickSearch'>Расширенный поиск</div>


