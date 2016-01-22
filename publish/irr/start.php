<?
include_once($_SERVER['DOCUMENT_ROOT'].'/publish/irr/public.php');

$login    = 'aligoweb@ya.ru';
$password = '89048512165';

$p = new public_irr($login,$password);

$p->authorize();


?>