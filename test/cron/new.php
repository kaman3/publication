<?

$to = "aligoweb@ya.ru" ; //обратите внимание на запятую

/* тема/subject */
$subject = "Запрос";	

/* сообщение */
$message = $_GET['param'];

/* Для отправки HTML-почты вы можете установить шапку Content-type. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";

/* дополнительные шапки */
//$headers .= "From: Магазин МЕЗОН\r\n";
//$headers .= "Cc: birthdayarchive@example.com\r\n";
//$headers .= "Bcc: birthdaycheck@example.com\r\n";

/* и теперь отправим из */
mail($to, $subject, $message, $headers);
?>