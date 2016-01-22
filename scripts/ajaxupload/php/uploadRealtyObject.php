<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/SimpleImage.php');

if($_GET['phpsid'])
{
    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/cacheImg/'.trim($_GET['phpsid']).'/';
}else
{
    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/pars/tmp/images/user/'.trim($_GET['idTmp']).'/';
}

if(!is_dir($targetTmp)){
    mkdir($uploaddir, 0777, true);
}

// определяем расширение файла
$info = pathinfo($_FILES['uploadfile']['name']);
$ext = ".".$info['extension'];
$filetypes = array('.jpg','.gif','.bmp','.png','.JPG','.BMP','.GIF','.PNG','.jpeg','.JPEG');

$newFileName = rand(100000,900000).$ext;
$insertFile = $uploaddir.$newFileName;

if(!in_array($ext,$filetypes)){
    echo "<p>Данный формат файлов не поддерживается</p>";}
else{

    if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $insertFile)) {

        $img = new abeautifulsite\SimpleImage($insertFile);
        $img->fit_to_width(800);
        $img->save($insertFile);

        echo $newFileName;
    } else {
        echo "error";
    }
}


?>