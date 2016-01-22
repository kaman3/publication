<?
class managerFilter extends CWidget {

    public function run() {

        //$content = Content::model()->findAllBySql('SELECT id,title FROM table_content WHERE idCat != 0 and id NOT IN('.$_GET["id"].') ORDER BY id DESC LIMIT 0,3');
        $select = array(
            1 => 20,
            2 => 40,
            3 => 60,
        );
        $this->render('managerFilter',array('select' => $select));

    }

}
?>