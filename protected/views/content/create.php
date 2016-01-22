<?php
/* @var $this ContentController */
/* @var $model Content */

$this->breadcrumbs=array(
	'Статьи'=>array('index'),
	'Добавить',
);

$this->menu=array(
	array('label'=>'List Content', 'url'=>array('index')),
	array('label'=>'Manage Content', 'url'=>array('admin')),
);
?>

<h1>Добавить новость</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'category'=>$category)); ?>