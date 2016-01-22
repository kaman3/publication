<?
class searchGuest extends CWidget {

    public function run() {
        $dataSearch = Yii::app()->app->dataSearch();

        $countRooms = array(5,1,2,3,4);

        $this->render('searchGuest',array('dataSearch'=>$dataSearch, 'countRooms' => $countRooms,));
    }
}
?>