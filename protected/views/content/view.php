<?php
/* @var $this ContentController */
/* @var $model Content */

$difference = time()-strtotime($model->dateTime);
header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', time()-$difference+10800));

$this->breadcrumbs=array(
	'Статьи'=>array('index'),
	$model->title,
);

$this->pageTitle   = $model->title;
$this->description = $model->description_tag;
$this->title =   $model->title;
$this->keywords = $model->keywords_tag;


$paht = $_SERVER['DOCUMENT_ROOT'].'/images/content/'.$model->id.'/'.$model->id.'.jpg';
if(file_exists($paht)){
   $img = '<img src = "/images/content/'.$model->id.'/'.$model->id.'.jpg" width = "605px">';
}else{
   $img = '';
}

?>
<div class = 'leftContent'>
   <div class = 'descBoxText'>
     <h1><?=$model->title;?></h1>
     <div class = 'dbt_date'><?php echo Yii::app()->app->formatDate($model->dateTime);?></div>
     <div class = 'dbt_img'><?=$img;?></div>
     <div class = 'dbt_text'><?=$model->description;?></div>
     <br>
     <div class="share42init"></div>
     <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/share42/share42.js"></script>
     <?php $this->widget('application.components.lastNews'); ?>
   </div>
</div>
<div class = 'rightContent'>
    <?php $this->widget('application.components.contentMenu'); ?>
    <?php $this->widget('application.components.searchArticle'); ?>
    <div class = 'banner_240'>
        <a href = '/statyi/avtomaticheskaya_publikaciya_obyyavleniy_-50.html'><img src = '/images/banners/banner_240.png'></a>
    </div>
</div>

