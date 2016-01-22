<?php
include('Ssh2_crontab_manager.php');
// Установка соединения
//$crontab = new Ssh2_crontab_manager('46.30.41.100', '22', 'root', 'iPhone5s');

// удаление пустых задач
//$crontab->remove_cronjob('/^$/');

// Получение списка задач
$cron_jobs = $crontab->get_cronjobs();

header('Content-type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');

$base = (dirname(__FILE__));
require($base .'/config.php');
$conn = new Connection();
$conn = $conn->config();

$parser_script = '/var/www/vh30193/data/www/xica58.ru/pac/parsers/parse.php';

$cities = $conn->query("SELECT id,name FROM city_list WHERE isarea = '0' AND isactive = '1'")->fetchAll();
$sources = $conn->query("SELECT id,url FROM sources")->fetchAll();

?>
<link type="text/css" rel="stylesheet" href="cron.css">

<title>Супер-пупер крон</title>
<h2>Создание новой задачи</h2>
<form class="cron-block" method="POST">
	<div class="sel-block">
		<label>Город:</label>
		<?php 
		echo "<select name='city'>
			<option value=''>- выберите город -</option>";
		foreach ($cities as $key => $value) {
			$selected = (isset($_REQUEST['city']) && $_REQUEST['city']==$value['id'])?'selected="selected"':'';
			echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
		}
		echo '</select>';
		?>
	</div>
	<div class="sel-block">
		<label>Источник:</label>
		<?php 
		echo "<select name='source'>
			<option value=''>- выберите источник -</option>";
		foreach ($sources as $key => $value) {
			$selected = (isset($_REQUEST['source']) && $_REQUEST['source']==$value['id'])?'selected="selected"':'';
			echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['url'].'</option>';
		}
		echo '</select>';
		?>
	</div>
	<div class="sel-block">
		<label>Период запуска:</label>
		<select name="cron">
			<option value="">- выберите период запуска -</option>
			<?php 
				$periods_arr = array(
					1=>array('5 минут','*/05 * * * *'),
					2=>array('10 минут','*/10 * * * *'),
					3=>array('20 минут','*/20 * * * *'),
					4=>array('30 минут','*/30 * * * *'),
					5=>array('1 час','* */01 * * *'),
					6=>array('2 часа','* */02 * * *'),
					7=>array('3 часа','* */03 * * *'),
					8=>array('6 часов','* */06 * * *'),
					9=>array('12 часов','* */12 * * *'),
					10=>array('1 день','* * */01 * *'),
					11=>array('2 дня','* * */02 * *'),
					12=>array('3 дня','* * */03 * *'),
					13=>array('5 дней','* * */05 * *'),
					14=>array('10 дней','* * */10 * *'),
					15=>array('15 дней','* * */15 * *'),
					16=>array('20 дней','* * */20 * *'),
					17=>array('1 месяц','* * * */01 *')
				);

				foreach ($periods_arr as $key => $value) {
					$selected = (isset($_REQUEST['cron']) && $_REQUEST['cron']==$key)?'selected="selected"':'';
					echo '<option value="'.$key.'" '.$selected.'>'.$value[0].'</option>';
				}
			?>
		</select>
	</div>
	<div><input type="submit" value="Создать"></div>
</form>

<?php 
if(isset($_REQUEST['cron']) && isset($_REQUEST['city']) && isset($_REQUEST['source'])){
	$cron_period = false;
	if(isset($periods_arr[$_REQUEST['cron']])) $cron_period = $periods_arr[$_REQUEST['cron']][1];


	// добавляем новую задачу
	if($cron_period && $_REQUEST['city'] != '' && $_REQUEST['source'] != ''){		
		$cron_str = $cron_period." /usr/bin/php ".$parser_script." city_id={$_REQUEST[city]} source_id={$_REQUEST[source]} >/dev/null 2>&1";

		$isset_cron = false;
		foreach ($cron_jobs as $key => $value) {
			if($value==$cron_str) $isset_cron = true;
		}

		if(!$isset_cron){
			$crontab->append_cronjob($cron_str);
		} else {
			echo '<pre style="color:#EE2711">ERROR: Такой Cron уже существует</pre>';
		}
	}else {
		if(!$cron_period) echo '<pre style="color:#EE2711">ERROR: Вы не выбрали период запуска</pre>';
		if($_REQUEST['city'] == '') echo '<pre style="color:#EE2711">ERROR: Вы не выбрали город</pre>';
		if($_REQUEST['source'] == '') echo '<pre style="color:#EE2711">ERROR: Вы не выбрали источник</pre>';
	}
}

if(isset($_POST['del'])){
	// Удаление одной задачи
	// if(preg_match('/source_id=([0-9]+)/', $cron_jobs[$_POST['del']-1]) && preg_match('/city_id=([0-9]+)/', $cron_jobs[$_POST['del']-1])) 
		$crontab->remove_cronjob_by_key($_POST['del']-1);
}

// Получение списка задач
$cron_jobs = $crontab->get_cronjobs();

echo '<h2>Список созданных задач</h2><table class="cron-table">';
echo '<tr><th>№</th><th>Cron</th><th>Город</th><th>Источник</th><th>Период запуска</th><th>Удаление</th></tr>';
if($cron_jobs) foreach ($cron_jobs as $key => $value) {
	$city = '';
	preg_match('/city_id=([0-9]+)/', $value, $matches);
	if(count($matches)) $city_id = $matches[1];
	foreach ($cities as $key2 => $value2) if($value2['id']==$city_id) $city = $value2['name'];
	
	$source = '';
	preg_match('/source_id=([0-9]+)/', $value, $matches);
	if(count($matches)) $source_id = $matches[1];
	foreach ($sources as $ke2y => $value2) if($value2['id']==$source_id) $source = $value2['url'];
	
	$time = '';
	foreach ($periods_arr as $key2 => $value2) {
		 if (mb_strpos(mb_strtolower($value,'UTF-8'), mb_strtolower($value2[1],'UTF-8'), 0, 'UTF-8')===0) $time = $value2[0];
	}

	// выводим только те задачи, в которых встречаются city_id и source_id, дабы не удалить что то другое
	if(preg_match('/source_id=([0-9]+)/', $value) && preg_match('/city_id=([0-9]+)/', $value)) 
		echo '<tr><td>'.($key+1).'&nbsp;</td><td>'.$value.'&nbsp;</td><td>'.$city.'&nbsp;</td><td>'.$source.'&nbsp;</td><td>'.$time.'&nbsp;</td><td><form method="POST"><input type="hidden" name="del" value="'.($key+1).'"><input type="submit" value="Удалить"></form></td></tr>';
}
echo '</table>';
?>