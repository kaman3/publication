<?
//header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastModified).' GMT');
$t = strtotime("+3 hours",strtotime(time()));
echo $t;
echo gmdate('D, d M Y H:i:s',$t);
?>


