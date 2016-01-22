<?php
/* @var $this PublicationController */
/* @var $model publication */

$this->breadcrumbs=array(
	'Publications'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List publication', 'url'=>array('index')),
	array('label'=>'Create publication', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#publication-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Publications</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'publication-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'userId',
		'idCat',
		'region',
		'city',
		'district',
		/*
		'microdistrict',
		'title',
		'street',
		'description',
		'transaction',
		'area',
		'floor',
		'floors',
		'typeHouse',
		'countRooms',
		'phone',
		'email',
		'nameDealer',
		'deadlineRent',
		'dateCreate',
		'dateTime',
		'price',
		'publich',
		'link',
		'deliteLink',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
