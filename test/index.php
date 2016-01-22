<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8"/>
<style type="text/css">
*{line-height: 21px;font-size: 14px; font-family: Calibri;}
.clearfix:before,  .clearfix:after {content: " "; display: table;}
.clearfix:after {clear: both; visibility: hidden; line-height: 0; height: 0;}
.clearfix {*zoom: 1;}
.clear{clear: both;}
.form{width: 800px; margin: 50px auto;border: 1px solid #ccc; padding: 10px;background: #f5f5f5}
.row{margin-bottom: 15px;}
label{width: 200px; float: left;margin-right: 30px; text-align: right;}
.field{width: 550px; float: left;}
textarea,select,input[type="text"],input[type="file"]{width: 100%; border: 1px solid #ccc; margin-bottom: 5px;}
textarea{height: 100px;}
span{color: red}
</style>
<title>Супер-пупер публикатор</title>
</head>
<body>
	<div class="form">
		<form action = 'new.php' enctype="multipart/form-data" method="post">
			<div class="row clearfix">
				<label><span>*</span> Заголовок</label><div class="field"><input type="text" name="title" value="Продам 1к квартиру"></div>
			</div>
			<div class="row clearfix">
				<label><span>*</span> Текст</label><div class="field"><textarea name="text">Квартира в отличном состоянии, вложений не требует.Общая площадь-127кв.м, жилая-60, кухня-30, пласт.окно, ламинат, кафель, трубы и батареи новые, натяжной потолок, кондиционер, балкон застеклен пластокно и утеплен.</textarea></div>
			</div>
			<div class="row clearfix">
				<label><span>*</span> Телефон</label><div class="field"><input type="text" name="phone" value="89374443437"></div>
			</div>
			<div class="row clearfix">
				<label><span>*</span> Email</label><div class="field"><input type="text" name="email" value="serega569256@bk.ru"></div>
			</div>
			<div class="row clearfix">
				<label><span>*</span> Рубрика</label><div class="field">
					<select name="rub">
						<option value="609">Квартиры и комнаты (вторичный рынок)</option>
					</select>
				</div>
			</div>
			<div class="row clearfix">
				<label><span>*</span> Кол-во комнат</label><div class="field">
					<select name="rooms">
						<option value="1">ОК</option>
						<option value="2" selected>1</option>
						<option value="3">2</option>
						<option value="4">3</option>
						<option value="5">4 и более</option>
					</select>
				</div>
			</div>
			<div class="row clearfix">
				<label>Цена, руб.</label><div class="field"><input type="text" name="price" value="3000000"></div>
			</div>
			<div class="row clearfix">
				<label><span>*</span> Тип объявления</label><div class="field">
					<select name="type">
						<option value="1">Продам</option>
					</select>
				</div>
			</div>
			<div class="row clearfix">
				<label><span>*</span> Срок размещения</label><div class="field">
					<select name="period">
						<option value="5">1 день</option>
						<option value="6">3 дня</option>
						<option value="1">1 неделя</option>
						<option value="2">2 недели</option>
						<option value="3">3 недели</option>
						<option value="4">1 месяц</option>
					</select>
				</div>
			</div>
			<div class="row clearfix">
				<label>Изображение</label><div class="field"><input type="file" name="images[]"><input type="file" name="images[]"><input type="file" name="images[]"></div>
			</div>
			<div class="row clearfix">
				<label>&nbsp;</label><div class="field"><input type="submit" value=" Отправить "></div>
			</div>
		</form>
	</div>
</body>
</html>