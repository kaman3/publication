<form action="" id="example_group3">
	<div class = 'message mp'>
         Перед вами список телефонов которые пользователи посчитали агентскими. <br>
         Вы можете добавить эти номера в свою базу для обработки.<br>
	</div>
	<div class = 'boxPanelOption'>
		 <div class = 'PanelOption'>
              <div class = 'pOtd'>Все выделеные:</div>
              <div class = 'pOtd'>
                   <div class = 'bphone update' id = 'clickAgentCheck' action = '1'>Агенты</div>
              </div>
              <div class = 'pOtd'>
                   <div class = 'bphone error' id = 'clickAgentCheck' action = '2'>Нет</div>
              </div>
		 </div>
	</div>
	
	<div class = 'thboxPhoneAgent'>
         <div class = 'tdPaItem_0'><input type="checkbox" name="cbname3[]" value="14" id="example_maincb"></div>
         <div class = 'tdPaItem_1'>Номер телефона</div>
         <div class = 'tdPaItem_2'>Отмеченое объявление</div>
         <div class = 'tdPaItem_3'></div>
         <div class = 'tdPaItem_3'></div>
	</div>

	<div class = 'boxPhoneAgent'>
		<?php $this->renderPartial('application.views.realtyObject.phoneAgent._view',array(
		        'data'=>$data,
		));?>
	</div>
	
<div class = 'boxPaginator'>
  <div class = 'countShowPages'>
       <span>Показывать по:</span>
       <select name = 'countSP' id = 'countSP'>
            <option value = '20'>20</option>
            <option value = '50'>50</option>
            <option value = '100'>100</option>
       </select>
       <span>объектов</span>
  </div>
  <div class = 'paginator'>
    <?php $this->widget('CLinkPager', array('pages' => $pages,)) ?>
  </div>
</div>

</form>