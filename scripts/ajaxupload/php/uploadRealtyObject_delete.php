<?
// смотрим откуда удалять
if($_GET['delCache'])
{
    // временный файлы
    $url = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/cacheImg/'.trim($_GET['idTmp']).'/'.trim($_GET['name']);
}else
{
    // добавленные вместе с объявлением
    $url = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/user/'.trim($_GET['idTmp']).'/'.trim($_GET['name']);
    $url_small = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/user/'.trim($_GET['idTmp']).'/small/'.trim($_GET['name']);
}

if(file_exists($url)){
    // удаляем большие
    unlink($url);
    // если существует маленькая ее тоже
    if(file_exists($url_small)){
       unlink($url_small);
    }
    echo 1;
}else{
    echo 0;
}


?>