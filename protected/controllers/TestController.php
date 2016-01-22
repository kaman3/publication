<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 20.08.14
 * Time: 13:11
 */
class TestController extends Controller
{
    public $description = '';
    public $keywords = '';
    public $title = '';

    public function actionIndex(){
        //echo 'Привет';
        $model = array(1=>'Привет',2=>'Пока');

        $this->render('index',array('data'=>$model));
    }
}