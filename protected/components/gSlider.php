<?
class gSlider extends CWidget {

    public function run() {

        $Post = new realtyObject;

        $data = $Post::model()->cache(500)->findAllBySql('SELECT * FROM table_object WHERE price > 0 ORDER BY id DESC LIMIT 0,50');

        $quality = array();

        foreach($data as $key => $value){

            $path_pars = Yii::app()->app->get_path_pars_img($value['idPars']);
            $imgPath = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/'.trim($path_pars).'/'.$value['idAds'].'/';
            $images = Yii::app()->app->get_files($imgPath);

            if(count($images) > 0){
               $quality[] = $value;
            }

        }

        $this->render('gSlider',array('data'=>$quality));


    }
}
?>