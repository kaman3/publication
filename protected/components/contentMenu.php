<?
class contentMenu extends CWidget {

    public function run() {

        $category = TableContentCat::model()->findAllBySql('SELECT * FROM table_content_cat WHERE parent = 0');

        $this->render('contentMenu',array('dataSearch'=>$category));

    }

}

?>