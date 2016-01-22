<?php

//Подключаем класс клиента
include('client.class.php');
//Подключаем настройки подключения к API
include('config.php');


$error = '';

//Создаем экземпляр класса клиента
$client = new synonymaClient($login, $hash);

//Получаем список доступных словарей
$dictionaries = $client->dictionaries();

//Проверяем была ли отправлена форма
if(!empty($_POST['text'])){
	
	if(empty($_POST['dicts'])){ //Проверяем был ли передан хотя бы один словарь, если нет, то показываем пользователю сообщение об ошибке
		$error = 'Укажите хотя бы один словарь';
	}else{ //Иначе синонимизируем текст
		$dicts = implode(",",$_POST['dicts']);
		$data = $client->synonymize($_POST['text'],$dicts);
		//Если сервер вернул ответ со статусом failed, показываем пользовтелю сообщение об ошибке, которая содержится в свойстве text, возвращенного класса
		if($data->status=='failed') $error = $data->text;
	}	
}else{
	$_POST['text'] = '';
}
?>

<html>
<head>
	<title>Примеры работы синонимайзера Synonyma API</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<h1>Примеры работы синонимайзера Synonyma API</h1>
	<form method="post" action="">
	<p>
		<b>Введите текст для синонимизации (макс. 10000 символов):</b>
		<br />
		<table border="0" width="100%">
			<tr valign="top">
				<td>
					<textarea name="text" rows="14" cols="90"><?=$_POST['text']?></textarea>
				</td>
				<td>
					<select size="10" name="dicts[]" multiple="multiple ">
						<optgroup label="Пользовательские">
							<?//Выводим список пользовательских словарей?>
							<?foreach($dictionaries->user as $dict){?>
								<option value="<?=$dict->uniqname?>"><?=$dict->name?> [<?=$dict->count?>]</option>
							<?}?>
						</optgroup>
						<optgroup label="Дефолтные">
							<?//Выводим список дефолтных словарей. Названия дефолтных словарей должны иметь префикс defaults*?>
							<?foreach($dictionaries->default as $dict){?>
							<option value="defaults*<?=$dict->uniqname?>"><?=$dict->name?> [<?=$dict->count?>]</option>
							<?}?>
						</optgroup>
					</select>
				</td>
			</tr>
		</table>
	</p>
	<p>
		<input type="submit" value="Обработать" />
	</p>
	</form>
	<?//Если произошла ошибка, выводим сообщение об этом?>
	<?if(!empty($error)):?>
		<font color="red"><b><?=$error?></b></font>
	<?else:?>
		<?//Выводим синонимизированный текст?>
		<?php if(!empty($data)):?>
		<br />
		<h3>Результат:</h3>
		<textarea rows="14" cols="120"><?=$data->text?></textarea>
		<?endif;?>
	<?endif;?>
</body>
</html>