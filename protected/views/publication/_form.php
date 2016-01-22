<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/jCarouselLite/jcarousellite_1.0.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/scripts/jCarouselLite/jCarouselLite.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/num2str/numStr.js"></script>
<?php $this->breadcrumbs=array('Публикация'=>array('index'),'Объект',);?>

<?php
// массив для этажей
$floors =  array('1' => '1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6',
                 '7' => '7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12',
                 '13' => '13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18',
                 '19' => '19','20'=>'20','21'=>'21','22'=>'22','23'=>'23','24'=>'24',
                 '25' => '25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30',
);

// получаем контактные данные
$data = Yii::app()->app->writeContact(Yii::app()->user->id);

// пользователь и id директории
$userId = Yii::app()->user->id;
$idTmp  = Yii::app()->app->lastId();

(count($cron)>0) ? $pDayHours = $cron : $pDayHours = '';

?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'publication-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Обязательные поля <span class="required">*</span> отмечены звездочкой</p>

<div class = 'boxAdsTd_1'>

	<?php echo $form->errorSummary($model); ?>
    <!-- id юзера -->
    <div class = 'row'>
        <?php echo $form->hiddenField($model, 'userId',array('value'=>Yii::app()->user->id)); ?>
    </div>
    <!-- выбранные дни для публикации -->
    <div class = 'row'>
        <?php echo $form->hiddenField($model, 'pDayHours',array('value'=>'')); ?>
    </div>
    <div class = 'row'>
        <?php //echo $form->hiddenField($model, 'pHours',array('value'=>$hours)); ?>
    </div>

    <? if($model['idCat']) : ?>
         <div class="row formPublic">
              Категория: <?=Yii::app()->app->getCatPublic($model['idCat']); ?>
         </div>
         <div class = 'amendCat'>Изменить</div>
    <? endif; ?>
    <? ($model['idCat']) ?  $display_Sel_Cat = "style = 'display:none'" : $display_Sel_Cat = "style = 'display:block'"?>

    <div class = 'catBoxPublic' <?=$display_Sel_Cat;?>>
    <!-- id категории -->
    <?php echo $form->hiddenField($model, 'idCat',array('value'=>$model['idCat'])); ?>

    <div class="row formPublic">
        <?php echo $form->labelEx($model,'idCat'); ?>
        <select name = 'catChange_1' id = 'catChange' selId = '1'>
            <option value = '9999' selid = '1'>------------</option>
            <? for($i = 0; $i < count($idCat); $i++) : ?>
                <option selid = '1' bid = '<?=$idCat[$i]['bid'];?>' value = '<?=$idCat[$i]['id'];?>'><?=$idCat[$i]['name'];?></option>
            <? endfor; ?>
        </select>
    </div>


    <div class = 'row formPublic' style = 'display:none'>
         <select name = 'catChange_2' id = 'catChange' selId = '2'>
         </select>

    </div>

    <div class = 'row formPublic' style = 'display:none'>
        <select name = 'catChange_3' id = 'catChange' selId = '3'>
        </select>
    </div>

    <div class = 'row formPublic' style = 'display:none'>
        <select name = 'catChange_4' id = 'catChange' selId = '4'>
        </select>
    </div>

    <div class = 'loadCatGif' style = 'display: none;'><img src = '/images/715.GIF' width="30px"></div>
    </div>

    <!-- тип сделки -->
    <div class="row formPublic">
        <?php echo $form->labelEx($model,'transaction'); ?>
        <?php echo $form->dropDownList($model, 'transaction', $transaction,
            array('empty' => '...'),
            array('options' => array($model['transaction']=>array('selected'=>true))));
        echo $form->error($model,'transaction');
        ?>
    </div>
    <!-- подгружаемые поля для каждой категории -->
    <!-- купить платный доступ -->
    <!-- общая площадь -->
    <? if(Yii::app()->app->getBuyCode() == 0) : ?>
    <div class="row formPublic showCat" id = 'lot'>
        <div class = 'accessRent'>

                 <div class = 'ar_box_input'>
                     <b>У вас нет ключей платного доступа, для публикации объявления в этот раздел необходимо их приобрести.</b><br><br>
                      Внимание! После покупки ключей доступа, необходимо прикрепить их к своему аккаунту! Это можно сделать в <a href = '/index.php?r=realtyObject/codesofpublic'>личном кабинете</a>.<br><br>
                 </div>

                 <div class = 'ar_box_input'>
                      <div class = 'arb_text'>Количество кодов</div>
                      <div class = 'arb_input'>
                          <select id = 'rentaccess'>
                              <option value = '1'>1</option>
                              <option value = '2'>2</option>
                              <option value = '3'>3</option>
                              <option value = '4'>4</option>
                              <option value = '5'>5</option>
                              <option value = '6'>6</option>
                              <option value = '7'>7</option>
                              <option value = '8'>8</option>
                              <option value = '9'>9</option>
                              <option value = '10'>10</option>
                              <option value = '15'>15</option>
                              <option value = '20'>20</option>
                          </select>
                      </div>
                 </div>

                 <div class = 'ar_box_input'>
                     <div class = 'arb_text'>Федеральный номер телефона куда прислать sms с кодами</div>
                     <div class = 'arb_input'>
                          <input id = 'phoneRent' value = ''>
                     </div>
                 </div>

                 <div class = 'ar_box_input'>
                      <div class = 'arb_text'>Почта, куда дополнительно продублировать письмо с кодами</div>
                      <div class = 'arb_input'>
                          <input id = 'emailRent' value = ''>
                      </div>
                 </div>

                 <div class = 'ar_box_input'>
                      <input type = 'button' value="Перейти к оплате" onclick="window.open('http://bazarpnz.ru/robokassa.php?type=pay&phone='+document.getElementById('phoneRent').value+'&email='+document.getElementById('emailRent').value+'&lot='+document.getElementById('rentaccess').value)">
                 </div>

        </div>
    </div>
    <? endif; ?>

    <div class="row formPublic showCat" id = 'area'>
        <?php echo $form->labelEx($model,'area'); ?>
        <?php echo $form->textField($model,'area'); ?>
        <?php echo $form->error($model,'area'); ?>
    </div>
    <!-- этаж -->
    <!--
    <div class="row formPublic showCat" id = 'floor'>
        <?php //echo $form->labelEx($model,'floor'); ?>
        <?php //echo $form->dropDownList($model, 'floor',$floors,
           //array('empty' => '...'),
          // array('options' => array($model['floor']=>array('selected'=>true))));
    // echo $form->error($model,'floor');
        ?>
    </div>
    -->
    <!-- этажность -->
    <!--
    <div class="row formPublic showCat" id = 'floors'>
        <?php //echo $form->labelEx($model,'floors'); ?>
        <?php //echo $form->dropDownList($model, 'floors',$floors,
            //array('empty' => '...'),
            //array('options' => array($model['floors']=>array('selected'=>true))));
        //echo $form->error($model,'floors');
        ?>
    </div>
    -->
    <!-- тип дома
    <div class="row formPublic showCat" id = 'typeHouse'>
        <?php //echo $form->labelEx($model,'typeHouse'); ?>
        <?php //echo $form->dropDownList($model, 'typeHouse', $houseType,
            //array('empty' => '...'),
            //array('options' => array($model['typeHouse']=>array('selected'=>true))));
        //echo $form->error($model,'typeHouse');
        ?>
    </div>
    -->
    <!-- количество комнат -->
    <div class="row formPublic showCat" id = 'countRooms'>
        <?php echo $form->labelEx($model,'countRooms'); ?>
        <?php echo $form->dropDownList($model, 'countRooms', $countRooms,
            array('empty' => '...'),
            array('options' => array($model['countRooms']=>array('selected'=>true))));
        echo $form->error($model,'countRooms');
        ?>
    </div>
    <!-- материалы стен
    <div class="row formPublic showCat" id = 'wall_material'>
        <?php //echo $form->labelEx($model,'wall_material'); ?>
        <?php //echo $form->dropDownList($model, 'wall_material',$wall_material,
            //array('empty' => '...'),
            //array('options' => array($model['wall_material']=>array('selected'=>true))));
        //echo $form->error($model,'wall_material');
        ?>
    </div>
    -->
    <!-- растояние до города -->
    <!--
    <div class="row formPublic showCat" id = 'distance_to_town'>
        <?php //echo $form->labelEx($model,'distance_to_town'); ?>
        <?php //echo $form->dropDownList($model, 'distance_to_town',$distance_to_town,
            //array('empty' => '...'),
           // array('options' => array($model['distance_to_town']=>array('selected'=>true))));
       // echo  $form->error($model,'distance_to_town');
        ?>
    </div>
    -->
    <!-- площадь участка -->
    <div class="row formPublic showCat" id = 'land_area'>
        <?php echo $form->labelEx($model,'land_area'); ?>
        <?php echo $form->textField($model,'land_area',array('size'=>60,'maxlength'=>250,'placeholder'=>'соток')); ?>
        <?php echo $form->error($model,'land_area'); ?>
    </div>
    <!-- местонахождение
    <div class="row formPublic showCat" id = 'location'>
        <?php //echo $form->labelEx($model,'location'); ?>
        <?php //echo $form->dropDownList($model, 'location',$location,
            //array('empty' => '...'),
            //array('options' => array($model['location']=>array('selected'=>true))));
        //echo $form->error($model,'location');
        ?>
    </div>
    -->
    <!-- срок аренды -->
    <div class="row formPublic showCat" id = 'deadlineRent'>
        <?php echo $form->labelEx($model,'deadlineRent'); ?>
        <?php echo $form->dropDownList($model, 'deadlineRent',$deadlineRent,
            array('empty' => '...'),
            array('options' => array($model['deadlineRent']=>array('selected'=>true))));
        echo $form->error($model,'deadlineRent');
        ?>
    </div>

    <!-- класс зданий -->
    <!--
    <div class="row formPublic showCat" id = 'classroom_building'>
        <?php //echo $form->labelEx($model,'classroom_building'); ?>
        <?php //echo $form->dropDownList($model, 'classroom_building',$classroom_building,
            //array('empty' => '...'),
            //array('options' => array($model['classroom_building']=>array('selected'=>true))));
        //echo $form->error($model,'classroom_building');
        ?>
    </div>
    -->
    <!-- тип гаража -->
    <!--
    <div class="row formPublic showCat" id = 'type_garage'>
        <?php //echo $form->labelEx($model,'type_garage'); ?>
        <?php //echo $form->dropDownList($model, 'type_garage',$type_garage,
            //array('empty' => '...'),
            //array('options' => array($model['type_garage']=>array('selected'=>true))));
       // echo $form->error($model,'type_garage');
        ?>
    </div>
    -->
    <!-- охрана -->
    <!--
    <div class="row formPublic showCat" id = 'protection'>
        <?php //echo $form->labelEx($model,'protection'); ?>
        <?php// echo $form->dropDownList($model, 'protection',$protection,
            //array('empty' => '...'),
           // array('options' => array($model['protection']=>array('selected'=>true))));
       // echo $form->error($model,'protection');
        ?>
    </div>
    -->
    <!-- подгружаемые поля для каждой категории конец-->

	<div class="row formPublic">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
    <!-- улица
	<div class="row formPublic">
		<?php //echo $form->labelEx($model,'street'); ?>
		<?php //echo $form->textField($model,'street',array('size'=>60,'maxlength'=>250)); ?>
		<?php //echo $form->error($model,'street'); ?>
	</div>
    -->
    <!-- форма для автомобилей -->
    <div class = 'avtoForm' style = 'display:none'>
         <div class = 'af_left'>
             <!-- бренд авто -->
             <div class = 'label_avto'>
                 <label for="" class="required">Марка<span class="required">*</span></label>
                 <select name = 'avto[brand]' id = 'brendGet'>
                    <option value="0">-- выберите модель --</option>
                    <? foreach($brend as $key => $value) : ?>
                       <option id = "<?=$value['id'];?>" value="<?=$value['bid'];?>"><?=$value['name'];?></option>
                    <? endforeach; ?>
                 </select>
              </div>
              <!-- модель авто -->
              <div class = 'label_avto' id = 'modelAvto' style = 'display: none;'>
                   <label for="" class="required">Модель<span class="required">*</span></label>
                   <select name = 'avto[model]'></select>
              </div>
              <!-- модификация -->
              <div class = 'label_avto'>
                   <label for="" >Модификация</label>
                   <input type = 'text' name = "avto[modification]" value="" >
              </div>
              <!-- год выпуска -->
              <div class = 'label_avto'>
                  <label for="" class="required">Год выпуска<span class="required">*</span></label>
                  <select name = 'avto[GYear]'>
                      <option value="0">-- выберите год выпуска --</option>
                      <? foreach($avto['GYear'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                      <? endforeach;?>
                  </select>
              </div>
             <!-- пробег -->
             <div class = 'label_avto'>
                  <label for="" class="required">Пробег<span class="required">*</span></label>
                  <input type = 'text' name = "avto[mileage]" value="" >
             </div>
             <!-- объкем двигателя -->
             <div class = 'label_avto'>
                 <label for="" class="required">Объем двигателя ( см <sup>3</sup> ) <span class="required">*</span></label>
                 <input type = 'text' name = "avto[engineCap]" value="" >
             </div>
             <!-- мощность -->
             <div class = 'label_avto'>
                 <label for="">Мощность, л.с.</label>
                 <input type = 'text' name = "avto[power]" value="" >
             </div>
             <!-- общее состояние -->
             <div class = 'label_avto'>
                 <label for="" class="required">Общее состояние<span class="required">*</span></label>
                 <select name = 'avto[general_state]'>
                     <option value="0">----</option>
                     <? foreach($avto['general_state'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
             <!-- готовность к эксплуатации -->
             <div class = 'label_avto'>
                 <label for="" class="required">Готовность к эксплуатации<span class="required">*</span></label>
                 <select name = 'avto[readiness]'>
                     <option value="0">----</option>
                     <? foreach($avto['readiness'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
             <!-- таможня -->
             <div class = 'label_avto'>
                 <label for="" >Таможня</label>
                 <select name = 'avto[customs]'>
                     <option value="0">----</option>
                     <? foreach($avto['customs'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
             <!-- цвет -->
             <div class = 'label_avto'>
                 <label for="" class="required">Цвет<span class="required">*</span></label>
                 <select name = 'avto[colour]'>
                     <option value="0">----</option>
                     <? foreach($avto['colour'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
             <!-- тип кузова -->
             <div class = 'label_avto'>
                 <label for="" class="required">Тип кузова<span class="required">*</span></label>
                 <select name = 'avto[body_type]'>
                     <option value="0">----</option>
                     <? foreach($avto['body_type'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
             <!-- тип двигателя -->
             <div class = 'label_avto'>
                 <label for="" class="required">Тип двигателя<span class="required">*</span></label>
                 <select name = 'avto[engines_type]'>
                     <option value="0">----</option>
                     <? foreach($avto['engines_type'] as $key => $value): ?>
                         <optgroup label = "<?=$key;?>">
                             <? foreach($avto['engines_type'][$key] as $key2 => $value2): ?>
                                <option value="<?=$key2;?>"><?=$value2;?></option>
                             <? endforeach;?>
                         </optgroup>
                     <? endforeach;?>
                 </select>
             </div>
             <!-- Привод -->
             <div class = 'label_avto'>
                 <label for="" class="required">Привод<span class="required">*</span></label>
                 <select name = 'avto[drive]'>
                     <option value="0">----</option>
                     <? foreach($avto['drive'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
             <!-- кпп -->
             <div class = 'label_avto'>
                 <label for="" class="required">КПП<span class="required">*</span></label>
                 <select name = 'avto[box]'>
                     <option value="0">----</option>
                     <? foreach($avto['box'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
             <!-- руль -->
             <div class = 'label_avto'>
                 <label for="" class="required">Руль<span class="required">*</span></label>
                 <select name = 'avto[steering_wheel]'>
                     <option value="0">----</option>
                     <? foreach($avto['steering_wheel'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
             <!--Количество хозяев по ПТС -->
             <div class = 'label_avto'>
                 <label for="" class="required">Количество хозяев по ПТС<span class="required">*</span></label>
                 <select name = 'avto[pts]'>
                     <option value="0">----</option>
                     <? foreach($avto['pts'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
             <!-- Наличие -->
             <div class = 'label_avto'>
                 <label for="" class="required">Наличие<span class="required">*</span></label>
                 <select name = 'avto[availability]'>
                     <option value="0">----</option>
                     <? foreach($avto['availability'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
             <!-- обмен -->
             <div class = 'label_avto'>
                 <label for="" class="required">Обмен<span class="required">*</span></label>
                 <select name = 'avto[exchange]'>
                     <option value="0">----</option>
                     <? foreach($avto['exchange'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>
         </div>
         <div class = 'af_right'>
              <div class = 'label_avto'>
                   <div class = 'checkAlText'>
                       <label for="avto[antibuks]" >Антипробуксовочная система</label>
                   </div>
                   <div class = 'checkAlLabel'>
                       <input id = 'avto[antibuks]' type="checkbox" name="avto[antibuks]" value="1">
                   </div>
              </div>

              <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[abs]" >Антиблокировочная система (ABS)</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[abs]' type="checkbox" name="avto[abs]" value="1">
                 </div>
              </div>

              <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[on-board_computer]" >Бортовой компьютер</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[on-board_computer]' type="checkbox" name="avto[on-board_computer]" value="1">
                 </div>
              </div>

              <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[GBO]" >Газобаллонное оборудование (ГБО)</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[GBO]' type="checkbox" name="avto[GBO]" value="1">
                 </div>
              </div>

              <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[rain]" >Датчик дождя</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[rain]' type="checkbox" name="avto[rain]" value="1">
                 </div>
              </div>

              <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[light]" >Датчик света</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[light]' type="checkbox" name="avto[light]" value="1">
                 </div>
              </div>

              <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[cruise_control]" >Круиз-контроль</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[cruise_control]' type="checkbox" name="avto[cruise_control]" value="1">
                 </div>
              </div>

              <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[xenon]" >Ксеноновые фары</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[xenon]' type="checkbox" name="avto[xenon]" value="1">
                 </div>
              </div>

              <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[drives]" >Легкосплавные диски</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[drives]' type="checkbox" name="avto[drives]" value="1">
                 </div>
              </div>

              <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[hatch]" >Люк</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[hatch]' type="checkbox" name="avto[hatch]" value="1">
                 </div>
              </div>

              <div class = 'label_avto'>
                 <label>Магнитола</label>
                 <select name = 'avto[radio_cassette]'>
                     <option value="0">----</option>
                     <? foreach($avto['radio_cassette'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
              </div>

              <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[navigation_system]" >Навигационная система</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[navigation_system]' type="checkbox" name="avto[navigation_system]" value="1">
                 </div>
             </div>

             <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[heated_mirrors]" >Обогрев зеркал</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[heated_mirrors]' type="checkbox" name="avto[heated_mirrors]" value="1">
                 </div>
             </div>

             <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[heated_steering]" >Обогрев руля</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[heated_steering]' type="checkbox" name="avto[heated_steering]" value="1">
                 </div>
             </div>

             <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[heated_seats]" >Обогрев сидений</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[heated_seats]' type="checkbox" name="avto[heated_seats]" value="1">
                 </div>
             </div>

             <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[headlight_washer]" >Омыватель фар</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[headlight_washer]' type="checkbox" name="avto[headlight_washer]" value="1">
                 </div>
             </div>

             <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[security_system]" >Охранная система</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[security_system]' type="checkbox" name="avto[security_system]" value="1">
                 </div>
             </div>

             <div class = 'label_avto'>
                 <div class = 'checkAlText'>
                     <label for="avto[parktronic]" >Парктроник</label>
                 </div>
                 <div class = 'checkAlLabel'>
                     <input id = 'avto[parktronic]' type="checkbox" name="avto[parktronic]" value="1">
                 </div>
             </div>

             <div class = 'label_avto'>
                 <label>Подушки безопасности</label>
                 <select name = 'avto[airbags]'>
                     <option value="0">----</option>
                     <? foreach($avto['airbags'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>

             <div class = 'label_avto'>
                 <label>Регулировка сиденья водителя</label>
                 <select name = 'avto[seat_adjustment]'>
                     <option value="0">----</option>
                     <? foreach($avto['seat_adjustment'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>

             <div class = 'label_avto'>
                 <label>Регулировка сиденья пассажира</label>
                 <select name = 'avto[adjusting_passenger_seat]'>
                     <option value="0">----</option>
                     <? foreach($avto['adjusting_passenger_seat'] as $key => $value): ?>
                         <option value="<?=$key;?>"><?=$value;?></option>
                     <? endforeach;?>
                 </select>
             </div>

              <div class = 'label_avto'>
                  <label>Регулировка руля</label>
                  <select name = 'avto[adjustable_steering_wheel]'>
                      <option value="0">----</option>
                      <? foreach($avto['adjustable_steering_wheel'] as $key => $value): ?>
                          <option value="<?=$key;?>"><?=$value;?></option>
                      <? endforeach;?>
                  </select>
              </div>

              <div class = 'label_avto'>
                  <label>Отделка салона</label>
                  <select name = 'avto[trim]'>
                      <option value="0">----</option>
                      <? foreach($avto['trim'] as $key => $value): ?>
                          <option value="<?=$key;?>"><?=$value;?></option>
                      <? endforeach;?>
                  </select>
              </div>

              <div class = 'label_avto'>
                  <div class = 'checkAlText'>
                      <label for="avto[stability]" >Система курсовой стабилизации</label>
                  </div>
                  <div class = 'checkAlLabel'>
                      <input id = 'avto[stability]' type="checkbox" name="avto[stability]" value="1">
                  </div>
              </div>

              <div class = 'label_avto'>
                  <div class = 'checkAlText'>
                      <label for="avto[tinting]" >Тонированные стекла</label>
                  </div>
                  <div class = 'checkAlLabel'>
                      <input id = 'avto[tinting]' type="checkbox" name="avto[tinting]" value="1">
                  </div>
              </div>

              <div class = 'label_avto'>
                  <label>Управление климатом</label>
                  <select name = 'avto[climate_control]'>
                      <option value="0">----</option>
                      <? foreach($avto['climate_control'] as $key => $value): ?>
                          <option value="<?=$key;?>"><?=$value;?></option>
                      <? endforeach;?>
                  </select>
              </div>

              <div class = 'label_avto'>
                  <label>Усилитель рулевого управления</label>
                  <select name = 'avto[power_steering]'>
                      <option value="0">----</option>
                      <? foreach($avto['power_steering'] as $key => $value): ?>
                          <option value="<?=$key;?>"><?=$value;?></option>
                      <? endforeach;?>
                  </select>
              </div>

              <div class = 'label_avto'>
                  <div class = 'checkAlText'>
                      <label for="avto[central_locking]" >Центральный замок</label>
                  </div>
                  <div class = 'checkAlLabel'>
                      <input id = 'avto[central_locking]' type="checkbox" name="avto[central_locking]" value="1">
                  </div>
              </div>

              <div class = 'label_avto'>
                  <div class = 'checkAlText'>
                      <label for="avto[electric_mirrors]" >Электрозеркала</label>
                  </div>
                  <div class = 'checkAlLabel'>
                      <input id = 'avto[electric_mirrors]' type="checkbox" name="avto[electric_mirrors]" value="1">
                  </div>
              </div>

              <div class = 'label_avto'>
                  <label>Электростеклоподъемники</label>
                  <select name = 'avto[electric_mirrors]'>
                      <option value="0">----</option>
                      <? foreach($avto['electric_mirrors'] as $key => $value): ?>
                          <option value="<?=$key;?>"><?=$value;?></option>
                      <? endforeach;?>
                  </select>
              </div>


         </div>
    </div>
    <!-- конец формы -->
    <!-- описание -->
	<div class="row formPublic">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
    <!-- Цена -->
    <div class="row formPublic writePrice">
        <div id="str"></div>
    </div>
    <div class="row formPublic">
        <?php echo $form->labelEx($model,'price'); ?>
        <?php echo $form->textField($model,'price',array('size'=>60,'maxlength'=>150,'autocomplete'=>'off')); ?>
        <?php echo $form->error($model,'price'); ?>
    </div>

    <!-- регион -->
    <?php echo $form->hiddenField($model, 'region',array('value'=>'1')); ?>
    <!-- город -->
    <?// echo $form->hiddenField($model, 'city',array('value'=>'2')); ?>
    <!--<div class="row formPublic">
        <?php //echo $form->labelEx($model,'city'); ?>
        <?php //echo $form->dropDownList($model, 'city', $city,
            //array('empty' => '------------'),
            //array('options' => array($model['city']=>array('selected'=>true))));
        //echo $form->error($model,'city');
        ?>
    </div>-->
    <!-- район
    <div class="row formPublic" id = "showDistrict" style = 'display: none;'>
        <?php //echo $form->labelEx($model,'district'); ?>
        <?php //echo $form->dropDownList($model, 'district', $district,
        //    array('empty' => '------------'),
        //    array('options' => array($model['district']=>array('selected'=>true))));
       // echo $form->error($model,'district');
       // ?>
    </div>
    -->
    <!-- микрорайон -->
    <div class="row formPublic" ><!--id = "showMicrodistrict" style = 'display:none;'-->
        <?php echo $form->labelEx($model,'microdistrict'); ?>
        <?php echo $form->dropDownList($model, 'microdistrict', $microdistrict,
            array('empty' => '...'),
            array('options' => array($model['microdistrict']=>array('selected'=>true))));
        echo $form->error($model,'microdistrict');
        ?>
    </div>

    <!-- контактные данные -->
    <div class="row formPublic">
        <?php echo $form->labelEx($model,'contact_id'); ?>
        <?php echo $form->dropDownList($model, 'contact_id', $contact,
            //array('empty' => '...'),
            array('options' => array($model['contact_id']=>array('selected'=>true))));
        echo $form->error($model,'contact_id');
        ?>
    </div>

    <div class="row formPublic">
        <div class = 'boxUpload'>
             <div class = 'boxUploadFiles' id = 'files'><?Yii::app()->app->loadImgUpdate($userId,$_GET['id']);?></div>
             <div class = 'boxButtonFiles' id = 'upload'><span id="status"></span></div>
        </div>
    </div>

    <!-- дата редактирования -->
	<div class="row">
        <?php echo $form->hiddenField($model, 'dateTime',array('value'=>date('Y-m-d H:i:s'))); ?>
	</div>

    <!-- Опубликовать объявление , если редактируем добавляем статус публикации из базы-->
    <?($idTmp) ? $pub = 1 : $pub = $model['publich'];?>
	<div class="row">
        <?php echo $form->hiddenField($model, 'publich',array('value'=>$pub)); ?>
	</div>

	<div class="row buttons pButtons" id = 'pbsave'>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>


    </div>
    <!-- второй столбец -->
    <div class = 'boxAdsTd_2'>
        <div class = 'androidTimerBox'>
             <div class = 'list-atb'>
                <? if($cronData): ?>
                    <? foreach($cronData as $key => $value): ?>
                        <?
                          foreach($timeInterval as $key => $t){
                               if($key == $value['hours']){
                                  $time = $t;
                               }
                          }
                        $days = '';
                        $day = explode(',',$value['days']);
                        foreach($week as $key => $d){
                              for($i = 0; $i < count($day); $i++){
                                  if($key == $day[$i]){
                                      $days .= $d.'-';
                                  }
                              }
                        }
                        ?>
                        <div class = "t-item"  day = "<?=$value['days'];?>" hours = "<?=$value['hours'];?>">
                            <div class = "t-item-time">
                                <div class = "b-days">
                                    <div class = "b-dt-td1">Дни недели:</div>
                                    <div class = "b-dt-td2"><?=substr($days,0,-1);?></div>
                                </div>
                                <div class = "b-time">
                                    <div class = "b-dt-td1">В интервале:</div>
                                    <div class = "b-dt-td2"><?=$time;?></div>
                                </div>
                            </div>
                            <div class = "t-item-remove">
                                <img src="/publish/resources/images/basket.png"></div>
                        </div>
                    <? endforeach; ?>
                <? endif; ?>
             </div>
             <div class = 'new-at'>
                 <a href="#" data-reveal-id="myModal_time" index = ''>Добавить время публикации</a>
             </div>
        </div>
        <!--<div class = ''><b>Это пока еще не готово пользуйтесь нижнем выбором времени!</b></div>-->
        <!--
        <div class = 'cTime'>
            <div class = 'cTimeHeader'>Выберите дни для публикации:</div>
            <div class = 'boxCheckDay'>
                <ul>
                    <li item = 1>Пн</li>
                    <li item = 2>Вт</li>
                    <li item = 3>Ср</li>
                    <li item = 4>Чт</li>
                    <li item = 5>Пт</li>
                    <li item = 6 class = 'output'>Сб</li>
                    <li item = 7 class = 'output'>Вс</li>
                </ul>
            </div>
            <div class = 'cTimeHeader'>Установите нужное вам время:</div>

            <div class  = 'cHoursBox'>
               <div class = 'cHb_td1'>В интервале</div>
               <div class = 'cHb_td3'><img src="/publish/resources/images/bud.png" width="15px"></div>
               <div class = 'cHb_td2'>
                   <div class="Vwidget">
                        <a href="#" class="up"></a>
                        <div class="VjCarouselLite">
                           <ul>
                               <? //foreach($timeInterval as $key => $value) :?>
                                <li item = '<?//=$key;?>'>
                                   <div>
                                      <?//=$value;?>
                                    </div>
                                 </li>
                               <?// endforeach; ?>
                            </ul>
                        </div>
                        <div class = 'cur'>
                          <a href="#" class="down"></a>
                        </div>
                      <div id = 'default_time' style = 'display:none;'>14</div>
                   </div>
                </div>
            </div>

        </div>
        -->

        <!--
        <div class = 'boxTimer'>
           <div class = 'headerTimer'>Интервал публикации:</div>
           <div class="row formPublic" id = "catChild">
              <select name = 'publication[timer]'>
                   <? //foreach($timer_ads as $key => $value) : ?>
                   <? //($key == $model['timer']) ? $selected = 'selected' : $selected = '';?>
                      <option <?//=$selected;?>  value = '<?//=$key;?>'><?//=$value;?></option>
                   <? //endforeach;?>
              </select>
           </div>
        </div>
        -->

        <div class = 'message' style = 'margin-top:10px;'>
            <ul>
               <li>
                   <p><b>Интервалы публикации:</b></p>
                   <p><b>НАПРИМЕР:</b></p>
                   <p><b>В интервале с 10:00 до 11:00</b> - означает что ваше объявление появиться на сайте bazarpnz.ru в период с 10:00 до 11:00 часов в выбранные вами дни.</p>
               </li>
               <li>Для корректного размещения объявлений, просим Вас заполнять все предложенные  поля формы!</li>
               <li>При загрузке изображений у Вас есть возможность выбрать первую (главную) фотографию для вашего объявления,
                   это условие действует только для сайта Bazarpnz.ru. <ins>Для выбора поставьте галочку на нужном изображении в левом верхнем углу.</ins>
               </li>
               <li>Если у Вас возникают какие либо вопросы и Вам требуется оперативный ответ, в левой части экрана находиться <ins>ТАКАЯ БОЛЬШАЯ КНОПКА <b>ЗАДАТЬ ВОПРОС</b></ins>,
                   пользуйтесь, да и если возникают какие либо здравые мысли как можно сделать сайт лучше, пишите буду рад Вашим предложениям!
               </li>
            </ul>
        </div>

    </div>
<?php $this->endWidget(); ?>


</div>
<!-- form -->
<div id="myModal_time" class="reveal-myModal-time">
    <div class = 'cTime'>
        <div class = 'cTimeHeader'>Выберите дни для публикации:</div>
        <div class = 'boxCheckDay'>
            <ul>
                <li item = 1>Пн</li>
                <li item = 2>Вт</li>
                <li item = 3>Ср</li>
                <li item = 4>Чт</li>
                <li item = 5>Пт</li>
                <li item = 6 class = 'output'>Сб</li>
                <li item = 7 class = 'output'>Вс</li>
            </ul>
        </div>
        <div class = 'cTimeHeader'>Установите нужное вам время:</div>
        <div class  = 'cHoursBox'>
            <div class = 'cHb_td1'>В интервале</div>
            <div class = 'cHb_td3'><img src="/publish/resources/images/bud.png" width="15px"></div>
            <div class = 'cHb_td2'>
                <div class="Vwidget">
                    <a href="#" class="up"></a>
                    <div class="VjCarouselLite">
                        <ul>
                            <? foreach($timeInterval as $key => $value) :?>
                                <li item = '<?=$key;?>'>
                                    <div>
                                        <?=$value;?>
                                    </div>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                    <div class = 'cur'>
                        <a href="#" class="down"></a>
                    </div>
                    <div id = 'default_time' style = 'display:none;'>14</div>
                </div>
            </div>
        </div>
        <div class = 'pb-box'>
            <div class = 'pb-line-box'>
                <a id = 'click-ts-el' href = '#'>ОК</a>
            </div>
            <div class = 'pb-line-box'>
                <a id = 'clickTimeClose' href = '#'>Отмена</a>
            </div>
        </div>


    </div>
</div>



<?
// составляем правильные пути при добавлении новых объявлений или при редактировании старых
if($idTmp)
{
   $action = '/scripts/ajaxupload/php/upload-file.php?phpsid='.$idTmp;
   $showImages = '/publish/images/cacheImg/'.$idTmp.'/';
   $delCache = 1;
   $param = $userId.'/'.$idTmp;
}else
{
   $action = '/scripts/ajaxupload/php/upload-file.php?userId='.$userId.'&idTmp='. $_GET['id'];
   $showImages = '/publish/images/user'.$userId.'/'.$_GET['id'].'/';
   $delCache = 0;
   $param = $userId.'/'.$_GET['id'];
}
?>

<script type="text/javascript">
    $(function(){
        var btnUpload=$('#upload');
        var status=$('#status');
        new AjaxUpload(btnUpload, {
            action: '<?=$action;?>',
            name: 'uploadfile',
            onSubmit: function(file, ext){

                if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
// extension is not allowed
                    alert(ext);
                    status.text('Поддерживаемые форматы JPG, PNG или GIF');
                    return false;
                }
                status.html('<div class = "loaderImg"><img src = "/publish/resources/images/loadImg.gif" width="100px"></div>');
            },
            onComplete: function(file, response){
//On completion clear the status
                status.html('');
//Add uploaded file to list
                if(response){
                    $('<li id = "<?=$param;?>/'+response+'"></li>').appendTo('#files').html('<div class = "imgHidden"><div class = "del_img" id = "<?=$delCache;?>"></div><div class = "general" move = "0"></div><img src="<?=$showImages;?>'+response+'"/></div>').addClass('success');
                } else{
                    $('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
    });
</script>
<script src="/scripts/ajaxupload/js/ajaxupload.3.5.js" type="text/javascript"></script>
<script>

    $(function() {

        $(".Vwidget  .VjCarouselLite").jCarouselLite({
            btnNext: ".Vwidget .down",
            btnPrev: ".Vwidget .up",
            mouseWheel: true,
            vertical: true,
            visible: 1,
            auto: false,
            speed: 500,
            //start:7,
            circular: true,

            beforeStart:
                function() {
                    //var hours = parseInt($.cookie("timer"))+1;
                    //if(hours){
                    //    start = hours;
                   // }
                    //o.start = 10;
             //$(".Vwidget  .VjCarouselLite").jCarouselLite({start:parseInt($.cookie("timer"))+1;})
            }




        });
    });


    $(document).ready(function(){
        $('.VjCarouselLite').css({"opacity":"0"})
    });
    // цена прописью
    $('#publication_price').keyup(function(){
        var s = $(this).val();
        num2str(s, 'str')
    })
</script>



