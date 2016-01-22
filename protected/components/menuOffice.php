<?
class menuOffice extends CWidget {
    public function run() {
        $data = array();
        //$data[] = array('action'=>'myads','name'=>'Мои объявления');
        $data[] = array('action'=>'option','name'=>'Настройки');
        $data[] = array('action'=>'OfficePayment','name'=>'Оплата услуг');
        $data[] = array('action'=>'invite','name'=>'Пригласить друга');
        $data[] = array('action'=>'codesofpublic','name'=>'Коды платных рубрик');


        $this->render('menuOffice',array('data'=>$data));
    }
}
?>