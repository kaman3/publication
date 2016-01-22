<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "#Content_description",
        fix_list_elements : true,
        min_height: 300,
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify  | bullist numlist outdent indent | code link media image table | paste forecolor backcolor |",
        plugins: "code, link, media, image, table, textcolor",
        tools: "inserttable",
        link_list: [
            {title: 'My page 1', value: 'http://www.tinymce.com'},
            {title: 'My page 2', value: 'http://www.moxiecode.com'}
        ],
        image_list: [
            {title: 'My image 1', value: 'http://www.tinymce.com/my1.gif'},
            {title: 'My image 2', value: 'http://www.moxiecode.com/my2.gif'}
        ],
        block_formats: "Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3",


    });
</script>
<?php
/* @var $this ContentController */
/* @var $model Content */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'content-form',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
    <? //print_r($category);?>
    <?php echo $form->hiddenField($model, 'dateTime',array('value'=>date('Y-m-d H:i:s'))); ?>
    <div class="row formPublic">
        <select name = 'Content[idCat]'>
            <option value = '0'>------------</option>
            <? for($i = 0; $i < count($category); $i++) : ?>
               <? ($model->idCat == $category[$i]['id']) ? $selected = 'selected' : $selected = '';?>
               <option <?=$selected;?>  value = '<?=$category[$i]['id'];?>'><?=$category[$i]['name'];?></option>
            <? endfor; ?>
        </select>
    </div>

	<div class="row formPublic">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row formPublic">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'description'); ?>
	</div>

    <div class = 'row'>
        <img src = '<?=$image;?>' width="200px;">
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'image'); ?>
        <?php echo $form->fileField($model, 'image'); ?>
        <?php echo $form->error($model,'image'); ?>
    </div>

	<div class="row formPublic">
		<?php echo $form->labelEx($model,'keywords_tag'); ?>
		<?php echo $form->textField($model,'keywords_tag',array('size'=>60,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'keywords_tag'); ?>
	</div>

	<div class="row formPublic">

        <?php echo $form->labelEx($model,'description_tag'); ?>
        <?php echo $form->textArea($model,'description_tag',array('rows'=>2, 'cols'=>50)); ?>
        <?php echo $form->error($model,'description_tag'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->