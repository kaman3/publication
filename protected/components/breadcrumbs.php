<?php
class breadcrumbs extends CWidget {

    public function run() {

       $Post = new TableCategory();
       $data = $Post::model()->findAllBySql('SELECT parent, name, idCat FROM table_category');

       $data = $this->breadcrums($_GET['id'],$data);
       //print_r($data);

    }
  
    public function breadcrums($n = 0, $data){

        foreach ($data as $key => $value) {
            if($value['idCat'] == $n){
                //echo $value['name'];
                $this->breadcrums($value['parent']);
            }
        }
   

     return $mass;
    }

}