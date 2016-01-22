<?
class notebook_cat extends CWidget {

   public function run() {

      $model = new TableCategory();
      $idCat = trim($_GET['cat']);
      // проверяем выбранна ли категория, если нет то выводим все корневые
      ($idCat) ? $idCat = $_GET['cat'] : $idCat = 0;
       $data = $model::model()->findAllBySql('SELECT id,name FROM table_n_book_cat WHERE parent = :num AND user = :user',array(':num' => $idCat,':user' => Yii::app()->user->id));

       $this->render('notebook_cat',array('data'=>$data));

   }
}
?>