<?php

class ContentController extends Controller
{
    public $description = '';
    public $keywords = '';
    public $title = '';
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
            /*
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
            */
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('create','update'),
                'users'=>array('+79374376600'),
            ),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

		$model=new Content;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Content']))
		{
			$model->attributes=$_POST['Content'];

            if($model->save()){

                $model->image=CUploadedFile::getInstance($model,'image');
                if($model->image){
                   $info = pathinfo($model->image);
                   $ext = ".".$info['extension'];
                   $gPaht = $_SERVER['DOCUMENT_ROOT'].'/images/content/';
                   mkdir($gPaht.$model->id.'/', 0755);
                   $model->image->saveAs($_SERVER['DOCUMENT_ROOT'].'/images/content/'.$model->id.'/'.$model->id.$ext);
                   $path = $_SERVER['DOCUMENT_ROOT'].'/images/content/'.$model->id.'/'.$model->id.$ext;

                   $pathSmall = $_SERVER['DOCUMENT_ROOT'].'/images/content/'.$model->id.'/'.$model->id.'-small'.$ext;


                   $image = Yii::app()->image->load($path);
                   $image->resize(200);
                   $image->save($pathSmall); // or $image->save('images/small.jpg');
                }
                $this->redirect(array('view','id'=>$model->id));
            }

		}

        $category = TableContentCat::model()->findAllBySql('SELECT * FROM table_content_cat WHERE parent = 0');

		$this->render('create',array(
			'model'=>$model,
            'category'=>$category,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Content']))
		{
            $model->attributes=$_POST['Content'];

            if($model->save()){

                $model->image=CUploadedFile::getInstance($model,'image');

                if($model->image){
                   $info = pathinfo($model->image);
                   $ext = ".".$info['extension'];

                   $gPaht = $_SERVER['DOCUMENT_ROOT'].'/images/content/';
                   $bigPatch = $_SERVER['DOCUMENT_ROOT'].'/images/content/'.$model->id.'/'.$model->id.$ext;
                   $pathSmall = $_SERVER['DOCUMENT_ROOT'].'/images/content/'.$model->id.'/'.$model->id.'-small'.$ext;

                   if(file_exists($bigPatch)){
                       unlink($bigPatch);
                       unlink($pathSmall);
                   }

                    mkdir($gPaht.$model->id.'/', 0755);
                    $model->image->saveAs($bigPatch);
                //$path = $_SERVER['DOCUMENT_ROOT'].'/images/content/'.$model->id.'/'.$model->id.$ext;

                   $image = Yii::app()->image->load($bigPatch);
                   $image->resize(200);
                   $image->save($pathSmall); // or $image->save('images/small.jpg');
                }

                $this->redirect(array('view','id'=>$model->id));
            }
		}
        $category = TableContentCat::model()->findAllBySql('SELECT * FROM table_content_cat WHERE parent = 0');

        $pathUpdate = '/images/content/'.$model->id.'/'.$model->id.'-small.jpg';

		$this->render('update',array(
			'model'=>$model,
            'category' => $category,
            'image'=> $pathUpdate,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		//$dataProvider=new CActiveDataProvider('Content');
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';

        if($_GET['cat']){
           $criteria->addCondition("idCat = ".$_GET['cat']);
        }

        if($_GET['title_search']){
           $criteria->addCondition("title LIKE '%".trim($_GET['title_search'])."%'");
        }

        $count = Content::model()->count($criteria);
        $pages = new CPagination($count);

        $pages->pageSize = 20;

        $pages->applyLimit($criteria);
        $models = Content::model()->findAll($criteria);//->cache(300)

        if($_GET['cat']){
           $h1 = TableContentCat::model()->findBySql('SELECT * FROM table_content_cat WHERE id = '.$_GET['cat']);
        }


        $this->render('index',array(
            'data'=>$models,
            'pages'=>$pages,
            'h1' => $h1,
        ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Content('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Content']))
			$model->attributes=$_GET['Content'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Content the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Content::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Content $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='content-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
