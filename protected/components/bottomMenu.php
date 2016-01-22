<?
class bottomMenu extends CWidget {

    public function run() {

        $dataSearch = Yii::app()->app->dataSearch();
        
        $this->render('bottomMenu',array('dataSearch'=>$dataSearch));
        
    }

}

?>