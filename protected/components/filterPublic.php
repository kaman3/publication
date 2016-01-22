<?
class filterPublic extends CWidget {

    public function run() {
        $dataSearch = Yii::app()->app->dataSearch();

        //$countRooms = array(6,1,2,3,4,5);
        $countRooms = array(1,2,3,4,5,6);

        $showAdsStatus = array(''=>'Активным','2'=>'Скрытым','3'=>'Всем');

        $this->render('filterPublic',array('dataSearch'=>$dataSearch,'countRooms'=>$countRooms,'showAdsStatus' => $showAdsStatus));
    }
}
?>