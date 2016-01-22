<?
class n_access_cat extends CWidget {

    public function run() {
        $model = new nAccessGuest();
        $data = $model::model()->findAllBySql('SELECT * FROM table_n_access_guest WHERE user_read = :num',
            array(':num' => Yii::app()->user->id));

         foreach($data as $key => $value){
             $user_doubles[] =  $value['user_creat'];
         }

        $user = array_unique($user_doubles);

        //print_r($user);

        foreach($user as $key => $value){

            for($i = 0; $i < count($data); $i++){

                if($value == $data[$i]['user_creat']){
                    $c[$value][] = $data[$i]['cat_show'];
                }
            }
        }

        $this->render('n_access_cat',array('c'=>$c));





    }
}
?>
