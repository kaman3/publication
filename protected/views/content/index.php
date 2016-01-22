<?php
/* @var $this ContentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Статьи',
);

$this->menu=array(
	array('label'=>'Create Content', 'url'=>array('create')),
	array('label'=>'Manage Content', 'url'=>array('admin')),
);
?>
<? ($h1['name']) ? $headerH1 = $h1['name'] : $headerH1 = 'Все статьи'; ?>

<div class = 'hConBox'><h1><?=$headerH1;?></h1></div>

<div class = 'boxContent'>
     <div class = 'leftContent'>
         <?php $this->renderPartial('_view',array(
             'data'=>$data,
         ));?>
     </div>
     <div class = 'rightContent'>
          <?php $this->widget('application.components.contentMenu'); ?>
          <?php $this->widget('application.components.searchArticle'); ?>
          <div class = 'banner_240'>
              <a href = '/statyi/avtomaticheskaya_publikaciya_obyyavleniy_-50.html'><img src = '/images/banners/banner_240.png'></a>
          </div>
     </div>
</div>
<div class = 'paginator'>
    <?php $this->widget('CLinkPager', array('pages' => $pages,)) ?>
</div>
<div class = 'footer_object'>
    <?php $this->widget('application.components.bottomMenu'); ?>
</div>
