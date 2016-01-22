<?php
/* @var $this RealtyObjectController */
/* @var $model realtyObject */
/* @var $form CActiveForm */

$floors =  array('1' => '1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6',
                 '7' => '7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12',
                 '13' => '13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18',
                 '19' => '19','20'=>'20','21'=>'21','22'=>'22','23'=>'23','24'=>'24',
                 '25' => '25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30',
);

$userId = Yii::app()->user->id;
$idTmp  = Yii::app()->app->lastId();

?>

<div class="form">

     <div class = 'addAds_td_1'>

          <?php $form=$this->beginWidget('CActiveForm', array(
	         'id'=>'realty-object-form',
	         // Please note: When you enable ajax validation, make sure the corresponding
	         // controller action is handling ajax validation correctly.
	         // There is a call to performAjaxValidation() commented in generated controller code.
             // See class documentation of CActiveForm for details on this.
	         'enableAjaxValidation'=>false,
             'htmlOptions'=>array('enctype'=>'multipart/form-data'),
          )); ?>

	      <p class="note">Обязательные поля <span class="required">*</span> отмечены звездочкой</p>

	      <?php echo $form->errorSummary($model); ?>

          <?php
              (isset($model->user)) ? $user = $model->user : $user = Yii::app()->user->id;
              echo $form->hiddenField($model, 'user',array('value' => $user));
          ?>

          <?php
              (isset($model->url_manager)) ? $url_manager = $model->url_manager : $url_manager = md5(rand(1000,99999).date('Y-m-d H:i:s'));
              echo $form->hiddenField($model, 'url_manager',array('value' => $url_manager));

          ?>

          <?php echo $form->hiddenField($model, 'idPars',array('value' => 7)); ?>

	      <?php
              ($model->idAds) ? $idAds = $model->idAds : $idAds =  rand(1000, 9999);
              echo $form->hiddenField($model, 'idAds',array('value' => $idAds));
          ?>
	      
	      <?php echo $form->hiddenField($model, 'region',array('value' => 2)); ?>
	      
	      <?php
               ($model->view) ? $view = $model->view : $view = 0;
               echo $form->hiddenField($model, 'view',array('value' => $view));
          ?>
	      
	      <?php
              ($model->agent) ? $agent = $model->agent : $agent = 1;
              echo $form->hiddenField($model, 'agent',array('value' => $agent));
          ?>


	      <?php echo $form->hiddenField($model, 'idCat',array('value' => $model->idCat)); ?>

          <?php echo $form->hiddenField($model, 'dateTime',array('value' => date('Y-m-d H:i:s'))); ?>


	      <div class="row formPublic">
		           <?php echo $form->labelEx($model,'idCat'); ?>
                   <select name = 'catAdsChange_1' id = 'catAdsChange_1'>
                           <option value = '0'>------------</option>
                              <? for($i = 0; $i < 7; $i++) : ?>
                                 <option item = '<?=$idCat[$i]['parent'];?>' value = '<?=$idCat[$i]['idCat'];?>'><?=$idCat[$i]['name'];?></option>
                              <? endfor; ?>
                   </select>
                   <?php echo $form->error($model,'idCat');?>
	      </div>

          <div class="row formPublic">
              <select name = 'catAdsChange_2' id = 'catAdsChange_2' style = 'display:none;'>
              </select>
              <div id = 'ajax-load-cat' style = 'display:none;'><img src = '/images/ajax-loader.gif'></div>
          </div>

	<div class="row formPublic" id = 'transaction'>
        <?php echo $form->labelEx($model,'transaction'); ?>
        <?php echo $form->dropDownList($model, 'transaction',$transaction,
            array('empty' => '...'),
            array('options' => array($model['transaction']=>array('selected'=>true))));
        echo $form->error($model,'transaction');
        ?>
    </div>

	<div class="row formPublic" id = 'city'>
        <?php echo $form->labelEx($model,'city'); ?>
        <?php echo $form->dropDownList($model, 'city',$city,
            array('empty' => '...'),
            array('options' => array($model['city']=>array('selected'=>true))));
        echo $form->error($model,'city');
        ?>
    </div>
    
    <div class="row formPublic" id = 'microdistrict' style = 'display:none;'>
        <?php echo $form->labelEx($model,'microdistrict'); ?>
        <?php echo $form->dropDownList($model, 'microdistrict',$microdistrict,
            array('empty' => '...'),
            array('options' => array($model['microdistrict']=>array('selected'=>true))));
        echo $form->error($model,'microdistrict');
        ?>
    </div>

	<div class="row formPublic">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row formPublic">
		<?php echo $form->labelEx($model,'street'); ?>
		<?php echo $form->textField($model,'street',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>

	<div class="row formPublic">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row formPublic">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

    <div class="row formPublic">
        <?php echo $form->labelEx($model,'totalArea'); ?>
        <?php echo $form->textField($model,'totalArea'); ?>
        <?php echo $form->error($model,'totalArea'); ?>
    </div>

    <div class="row formPublic">
		<?php echo $form->labelEx($model,'area'); ?>
		<?php echo $form->textField($model,'area'); ?>
		<?php echo $form->error($model,'area'); ?>
	</div>

    <!-- этаж -->
    <div class="row formPublic showCat" id = 'floor'>
        <?php echo $form->labelEx($model,'floor'); ?>
        <?php echo $form->dropDownList($model, 'floor',$floors,
            array('empty' => '...'),
            array('options' => array($model['floor']=>array('selected'=>true))));
        echo $form->error($model,'floor');
        ?>
    </div>
    <!-- этажность -->
    <div class="row formPublic showCat" id = 'floors'>
        <?php echo $form->labelEx($model,'floors'); ?>
        <?php echo $form->dropDownList($model, 'floors',$floors,
            array('empty' => '...'),
            array('options' => array($model['floors']=>array('selected'=>true))));
        echo $form->error($model,'floors');
        ?>
    </div>

	<div class="row formPublic showCat" id = 'typeHouse'>
        <?php echo $form->labelEx($model,'typeHouse'); ?>
        <?php echo $form->dropDownList($model, 'typeHouse',$typeHouse,
            array('empty' => '...'),
            array('options' => array($model['typeHouse']=>array('selected'=>true))));
        echo $form->error($model,'typeHouse');
        ?>
    </div>

	<div class="row formPublic showCat" id = 'countRooms'>
        <?php echo $form->labelEx($model,'countRooms'); ?>
        <?php echo $form->textField($model,'countRooms'); ?>
        <?php echo $form->error($model,'countRooms'); ?>
    </div>

	<div class="row formPublic">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row formPublic">
		<?php echo $form->labelEx($model,'NameDealer'); ?>
		<?php echo $form->textField($model,'NameDealer',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'NameDealer'); ?>
	</div>

    <div class="row formPublic">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>250)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row formPublic">
         <div class = 'boxUpload'>
              <div class = 'boxUploadFiles' id = 'files'><?Yii::app()->app->loadImgUpdateRealty($model->idAds);?></div>
              <div class = 'boxButtonFiles' id = 'upload'><span id="status"></span></div>
         </div>
    </div>

    <div class="row fieldCaptcha">
         <?if(CCaptcha::checkRequirements() && Yii::app()->user->isGuest):?>
             <div class = 'header_field_captcha'><?=CHtml::activeLabelEx($model, 'verifyCode')?></div>
             <div class = 'img_field_captcha'><?$this->widget('CCaptcha')?></div>
             <div class = 'input_field_captcha'><?=CHtml::activeTextField($model, 'verifyCode')?></div>
         <?endif?>
    </div>

	<div class="row buttons addads">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

    </div>
    
    <div class = 'addAds_td_2'>
         <? if(isset($model->id)): ?>
            <div class = 'deleteAds'><a href = '/index.php?r=realtyObject/deleteAds&idAds=<?=$idAds;?>'>Удалить объявление</a></div>
         <? endif;?>
         <? if(Yii::app()->user->isGuest) : ?>
            <div class = 'message' style = 'margin-top:60px;'>
               <p><a href = '/index.php?r=User/default/registration'>Зарегистрируйтесь</a> и получите больше возможностей для управления вашими объявлениями.</p>
               <p><u>Объявление будет размещено на сайте rlpnz.ru!</u></p>
            </div>
         <? endif; ?>

         <? if(!Yii::app()->user->isGuest) : ?>
            <div class = 'message' style = 'margin-top:60px;'>
                <p>Внимание вы добавляете объявление в базу Rlpnz.ru. Если вы хотите <span style = 'color:red;'>АВТОМАТИЧЕСИ</span> публиковать объявление на другие сайты, пожалуйста  <a href = '/index.php?r=publication'>перейдите по ссылке</a></p>
            </div>
         <? endif; ?>
         <div class = 'banner_addAds'>
             <a href = '/statyi/avtomaticheskaya_publikaciya_obyyavleniy_-50.html'><img src = '/images/banners/public_ban.png'></a>
         </div>

    </div>


</div><!-- form -->

<?
// составляем правильные пути при добавлении новых объявлений или при редактировании старых
if($idTmp)
{
    $action = '/scripts/ajaxupload/php/uploadRealtyObject.php?phpsid='.$idTmp;
    $showImages = '/pars/tmp/cacheImg/'.$idTmp.'/';
    $delCache = 1;
    $param = $userId.'/'.$idTmp;
}else
{
    $action = '/scripts/ajaxupload/php/uploadRealtyObject.php?&idTmp='.$model->idAds;
    $showImages = '/pars/tmp/images/user/'.$model->idAds.'/';
    $delCache = 0;
    $param = $userId.'/'.$model->idAds;

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
                if($('.boxUploadFiles li').length > 2){
                   $('.boxButtonFiles').css({"display":'none'});
                }
//Add uploaded file to list
                if(response){
                    $('<li id = "<?=$param;?>/'+response+'"></li>').appendTo('#files').html('<div class = "imgHidden"><div class = "del_img_ads" id = "<?=$delCache;?>"></div><img src="<?=$showImages;?>'+response+'"/></div>').addClass('success');
                } else{
                    $('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
    });
</script>
<script src="/scripts/ajaxupload/js/ajaxupload.3.5.js" type="text/javascript"></script>