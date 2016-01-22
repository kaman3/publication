<?
class TypesMenu extends CWidget {

    public function run() {

        $model = new TableCategory();
        $idCat = trim($_GET['cat']);
         // проверяем выбранна ли категория, если нет то выводим все корневые
        ($idCat) ? $idCat = $_GET['cat'] : $idCat = 0;
        $data = $model::model()->cache(300)->findAllBySql('SELECT name, idCat FROM table_category WHERE parent = :num',array(':num' => $idCat));
        $microDistrics = Yii::app()->app->dataSearch();

        $this->render('typesMenu',array('data'=>$data,'microdistrics' => $microDistrics));
    }
}
?>