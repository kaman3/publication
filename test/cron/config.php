<?php
ini_set('display_errors', 1); 
error_reporting(E_WARNING | E_ERROR | E_PARSE); // E_NOTICE | E_WARNING | E_ERROR | E_PARSE

class Connection{
    const driver = 'mysql';
    const host = 'localhost';
    const dbname = 'vh30193_brokker_parser';
    const username = 'vh30193_sb_xica';
    const password = 'nokialumia800';

    function config(){
        return new PDO(self::driver.":host=".self::host.";dbname=".self::dbname.";charset=utf8", self::username, self::password);
    }	
}
?>