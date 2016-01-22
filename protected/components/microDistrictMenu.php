<?
class microDistrictMenu extends CWidget {

    public function run() {

        $dataSearch = Yii::app()->app->dataSearch();

        $this->render('microDistrictMenu',array('dataSearch'=>$dataSearch));

    }

}

?>