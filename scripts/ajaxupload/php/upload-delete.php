<?
// смотрим откуда удалять
if($_GET['delCache'])
{
   // временный файлы
   $url = $_SERVER['DOCUMENT_ROOT'].'/publish/images/cacheImg/'.trim($_GET['idTmp']).'/'.trim($_GET['name']);
}else
{
   // добавленные вместе с объявлением
   $url = $_SERVER['DOCUMENT_ROOT'].'/publish/images/user'.trim($_GET['userId']).'/'.trim($_GET['idTmp']).'/'.trim($_GET['name']);
}

if(file_exists($url)){
	unlink($url);
	echo 1;
}else{
	echo 0;
}


?>