<?php
/* @var $this ContentController */
/* @var $model Content */

$this->breadcrumbs=array(
	'Статьи'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'List Content', 'url'=>array('index')),
	array('label'=>'Create Content', 'url'=>array('create')),
	array('label'=>'View Content', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Content', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'category'=>$category,'image'=>$image)); ?>