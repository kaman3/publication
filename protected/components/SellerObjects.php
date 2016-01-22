<?
class SellerObjects extends CWidget {

    public $phone;
    public $NameDealer;

    public function run() {

        $Post = new realtyObject;

        $phone = explode(' ',trim($this->phone));


        if(strlen(trim($phone[0])) > 11){
            $p =  substr(trim($phone[0]),0,11);
        }else{
            $p = trim($phone[0]);
        }
       $data = $Post::model()->findAllBySql('SELECT * FROM table_object WHERE phone = '.trim($p).' AND id NOT IN('.$_GET['id'].') AND dateTime > (NOW() - interval 20 day) ORDER BY id DESC LIMIT 0,6');
       if($data)
       $this->render('SellerObjects',array('data'=>$data,'NameDealer'=>$this->NameDealer,'phone' => $this->phone));

    }

}
?>