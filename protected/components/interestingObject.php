<?
class interestingObject extends CWidget {

    public function run() {

        $Post = new realtyObject;

        $id = trim($_GET['id']);
        $idCat = trim($_GET['cat']);

        $data = $Post::model()->findBySql('SELECT * FROM table_object WHERE id = '.$id.' AND dateTime > (NOW() - interval 20 day)');

        $district = $data['district'];
        $price = str_replace(' ', '', $data['price']);
        $countRooms = $data['countRooms'];
        $transaction = $data['transaction'];
        $idCat = $data['idCat'];
        $city = $data['city'];

        if($district){
        	$sql .= ' AND district = '.$district;
        }
        if($price){
        	// усли гаражи
        	if($idCat == 23){
        	   $price_min = $price - 100000;
        	   $price_max = $price + 100000;
        	   $sql .= ' AND (price > '.$price_min.' AND price < '.$price_max.')';
        	}
            // если квартиры новостройки
            elseif($idCat == 7 || $idCat == 8){
               $price_min = $price - 200000;
        	   $price_max = $price + 200000;
        	   $sql .= ' AND (price > '.$price_min.' AND price < '.$price_max.')';
            }
            // если долгосрочная сдача
            elseif($idCat == 9){
               $price_min = $price - 2000;
        	   $price_max = $price + 2000;
        	   $sql .= ' AND (price > '.$price_min.' AND price < '.$price_max.')';
            }
            // если суточная
            elseif($idCat == 10){
               $price_min = $price - 200;
        	   $price_max = $price + 200;
        	   $sql .= ' AND (price > '.$price_min.' AND price < '.$price_max.')';
            }else{
               $sql .= '';
            }
            
        }
        // количество комнат
        if($countRooms){
           $sql .= ' AND countRooms = '.$countRooms;
        }
        // тип сделки
        if($transaction){
           $sql .= ' AND transaction = '.$transaction;
        }
        // город
        if($city){
        	$sql .= ' AND city = '.$city;
        }
        
        // проверяем выбранна ли категория, если нет то выводим все корневые
        ($idCat) ? $idCat = $_GET['cat'] : $idCat = 0;
        $data = $Post::model()->findAllBySql('SELECT * FROM table_object WHERE idCat = '.$idCat.' AND id NOT IN('.$_GET['id'].') '.$sql.' ORDER BY id DESC LIMIT 0,6');
        if($data)
        $this->render('interestingObject',array('data'=>$data));
        
        
    }
}
?>