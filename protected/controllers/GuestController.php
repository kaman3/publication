<?php

class GuestController extends Controller
{
    public $description = '';
    public $keywords = '';
    public $title = '';

    public $layout='//guest/index';

	public function actionIndex()
	{
        $criteria = new CDbCriteria;
        $criteria->order = 'id DESC';
        $criteria->limit = 1;
        $md = realtyObject::model()->findAll($criteria);

        $difference = time()-strtotime($md[0]['dateTime']);
        header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', time()-$difference+10800));

        $this->render('index');

	}

	// Uncomment the following methods and override them if needed

	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
        return array(
            /*
            array(
                'COutputCache + guest, index',
                'duration'=>100,
                'varyByParam'=>array('id'),
            ),
            */
        );
	}
    /*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}