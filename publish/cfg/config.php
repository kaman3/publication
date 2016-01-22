<?php
//ini_set('display_errors', 0); error_reporting(0);
error_reporting(E_ALL);

class Connection{
   
    public function config(){
        $mysql = MySQL::Instance('localhost', 'kaman62', '89048512165', 'publishads'); // драйвер БД
      return $mysql;
    }	
}
?>