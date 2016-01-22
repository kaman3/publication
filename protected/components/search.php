<?
class search extends CWidget {

    public function run() {
    	$dataSearch = Yii::app()->app->dataSearch();

    	$countRooms = array(5,1,2,3,4);

    	$this->render('search',array('dataSearch'=>$dataSearch, 'countRooms' => $countRooms, 'agent'=> $agent));
    }
}
?>