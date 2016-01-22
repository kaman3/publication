<?

include_once($_SERVER['DOCUMENT_ROOT'].'/publish/bazarpnz/public.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/cfg/application.php');

$public_bazarpnz = new public_bazarpnz;

$public_bazarpnz->deleteAds('http://bazarpnz.ru/edit.php?id=f0cbc81a4120a40468baae01f8d77390');

?>