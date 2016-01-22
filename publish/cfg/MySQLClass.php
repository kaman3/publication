<?php
// Помощник работы с БД
//
// Примеры:
// SELECT 	-	$_SQL->Select("SELECT ".implode(", ", $table_fileds[PAGES])." FROM ".PAGES." WHERE ".$table_fileds[PAGES][0]."='4'");
// INSERT 	-	$_SQL->Insert(PAGES, array($table_fileds[PAGES][5]=>'Заголовок'));
// UPDATE 	-	$_SQL->Update(PAGES, array($table_fileds[PAGES][5]=>'Заголовок'), 'id = 5');
// DELETE 	-	$_SQL->Delete(PAGES, 'id = 5');
// clearTable   $_SQL->clearTable(PAGES);
class MySQL
{
	private static $instance;	// экземпляр класса
	private $link;				// ссылка на соединение
	private $host;				// хост
	private $user;				// логин
	private $pass;				// пароль
	private $db;				// имя базы данных

	// Конструктор класса
	public function __construct($host, $user, $pass, $db) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->db = $db;
		$this->connect();
	}

	// Соединение с БД
	private function connect() {
		$this->link = mysql_connect($this->host, $this->user, $this->pass) or die("Невозможно подключится к серверу баз данных");
		mysql_select_db($this->db, $this->link) or die("Невозможно подключится к базе данных");
		mysql_query( "set session character_set_server=utf8;", $this->link);
		mysql_query( "set session character_set_database=utf8;", $this->link);
		mysql_query( "set session character_set_connection=utf8;", $this->link);
		mysql_query( "set session character_set_results=utf8;", $this->link);
		mysql_query( "set session character_set_client=utf8;", $this->link);
	}

	// Получение экземпляра класса
	// результат	- экземпляр класса MSQL
	public static function Instance($host, $user, $pass, $db) {
		if (self::$instance == null)
			self::$instance = new MySQL($host, $user, $pass, $db);	
		return self::$instance;
	}

	// очистить таблицу
	public function clearTable($table){
		//mysql_query("TRUNCATE TABLE $table"); 

		$query = "TRUNCATE TABLE $table";		
		$result = mysql_query($query);
		$this->Error($query) or $this->Error($query);

		return mysql_affected_rows();
	}

	// Выборка строк
	// $query    	- полный текст SQL запроса
	// результат	- массив выбранных объектов
	public function Select($query, $returntype = 'ROW') {
		//echo $query.'<br><br>';
		$result = mysql_query($query) or $this->Error($query);
		if (!$result)
			$arr = false;
		
		$n = mysql_num_rows($result);
		$arr = array();
		for($i = 0; $i < $n; $i++) {
			switch($returntype){
				case 'ARRAY': $row = mysql_fetch_array($result);break;
				case 'ASSOC': $row = mysql_fetch_assoc($result);break;
				default: $row = mysql_fetch_row($result);break;
			}	
			$arr[] = $row;
		}
		return $arr;				
	}
	
	// Вставка строки
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// результат	- идентификатор новой строки
	public function Insert($table, $object) {			
		$columns = array();
		$values = array();
	
		foreach ($object as $key => $value) {
			$key = mysql_real_escape_string($key . '');
			$columns[] = '`'.$key.'`';
			if ($value === null){
				$values[] = 'NULL';
			} else {
				$value = mysql_real_escape_string($value . '');							
				$values[] = "'$value'";
			}
		}	

		$columns_s = implode(',', $columns);
		$values_s = implode(',', $values);	

		$query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
		$result = mysql_query($query) or $this->Error($query);
								
		return mysql_insert_id();
	}
	
	// Изменение строк
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// $where		- условие (часть SQL запроса)
	// результат	- число измененных строк
	public function Update($table, $object, $where) {
		$sets = array();
	
		foreach ($object as $key => $value) {
			$key = mysql_real_escape_string($key . '');
			
			if ($value === null) {
				$sets[] = "`$key`=NULL";			
			} else {
				$value = mysql_real_escape_string($value . '');					
				$sets[] = "`$key`='$value'";			
			}			
		}
		
		$sets_s = implode(',', $sets);			
		$query = "UPDATE $table SET $sets_s WHERE $where";
		$result = mysql_query($query) or $this->Error($query);

		return mysql_affected_rows();	
	}
	
	// Удаление строк
	// $table 		- имя таблицы
	// $where		- условие (часть SQL запроса)	
	// результат	- число удаленных строк	
	public function Delete($table, $where) {
		$query = "DELETE FROM $table WHERE $where";		
		$result = mysql_query($query);
		$this->Error($query) or $this->Error($query);

		return mysql_affected_rows();	
	}

	// добавить ошибку БД в файл логов
	public function add_bd_logs($msg){
	  $msg = $this->Error($query);
	  if(SEND_LOGS){
	  	/*
	    $f = fopen(PATH.'db/db_logs.txt', 'a');
	    fwrite($f, "================\n".$msg . PHP_EOL);
	    fclose($f);
	    */
	    
	    $headers  = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "From: system@".$_SERVER['SERVER_NAME']."\nReply-To: $from\n";
		$headers .= "Bcc: \r\n";
		$msg = implode('',$msg);
		//echo $msg;
		mail(WEBMASTER, 'Ошибки в работе сайта '.$_SERVER['SERVER_NAME'], $msg, $headers);
	  }
	}

	/*********** Ошибка ***********/
	private function Error($query){
		if(mysql_errno() != 0){
			$msg[0] = "<div style='font-size:11px; margin-top: 15px;'>";
			$msg[0] .= "<h2>SQL ошибка:</h2>";
			$msg[1] .= '<b>Код ошибки</b>: '.mysql_errno().'<br>';
			$msg[1] .= '<b>Строка запроса</b>: '.mysql_error().'<br>';
			$msg[1] .= '<b>Url</b>: '.$_SERVER['REQUEST_URI'].'<br>';
			
			$msg[2] .= "</div>";

			echo $msg[0];
			if(isset($_SESSION['QWERTYlogin'])) {
				echo $msg[1];
			}	
			echo $msg[2];

			if(SEND_LOGS){
			  	/*
			    $f = fopen(PATH.'db/db_logs.txt', 'a');
			    fwrite($f, "================\n".$msg . PHP_EOL);
			    fclose($f);
			    */
			    
			    $headers  = "Content-type: text/html; charset=utf-8 \r\n";
				$headers .= "From: system@".$_SERVER['SERVER_NAME']."\nReply-To: $from\n";
				$headers .= "Bcc: \r\n";
				$msg = implode('',$msg);
				mail(WEBMASTER, 'Ошибки в работе сайта '.$_SERVER['SERVER_NAME'], $msg, $headers);
			}
		}
		
	}

	// Деструктор класса 
	public function __destruct() {
		$this->close();
	}

	// Отключаемся от БД
	public function close() {
		mysql_close($this->link);
	}

	// Получить соединение с БД
	public function getLink() {
		return $this;
	}
}

?>