<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/application.php');
$app = new app;

$userId = trim($_GET['userId']);
$idTmp  = trim($_GET['idTmp']);
$name   = trim($_GET['name']);
$idCache = trim($_GET['idCache']);

if($idCache){
   $dir = $_SERVER['DOCUMENT_ROOT'].'/publish/images/cacheImg/'.$idTmp.'/';
}else{
   $dir = $_SERVER['DOCUMENT_ROOT'].'/publish/images/user'.$userId.'/'.$idTmp.'/';
}

$app->makeMajor($name,$dir);

?>