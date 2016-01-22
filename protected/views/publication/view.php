<div class = 'line_bar_top'></div>
<?php
/* @var $this PublicationController */
/* @var $model publication */

$this->breadcrumbs=array(
	'Publications'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List publication', 'url'=>array('index')),
	array('label'=>'Create publication', 'url'=>array('create')),
	array('label'=>'Update publication', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete publication', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage publication', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'userId',
		'idCat',
		'region',
		'city',
		'district',
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
	),
)); ?>
