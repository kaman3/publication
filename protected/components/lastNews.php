<?
class lastNews extends CWidget {

    public function run() {

        $content = Content::model()->findAllBySql('SELECT id,title FROM table_content WHERE idCat != 0 and id NOT IN('.$_GET["id"].') ORDER BY id DESC LIMIT 0,5');

        $this->render('lastNews',array('data'=>$content));

    }

}
?>