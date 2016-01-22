<div class = 'boxOffice'>
    <div class="newCollLeft">
        <?php $this->widget('menuOffice'); ?>
    </div>
<div class="newCollRight">
     <div class = 'privateOfficeConteiner'>
     <div class = 'paymentBox'>

     </div>
     <div class = 'headerPV'>
          <div class = 'menuPV'>
               <!--<div class = 'p'><a href = ''>Мой профиль</a></div>-->
               <div class = 'p'><a href = '/index.php?r=realtyObject/OfficePayment'>Оплата</a></div>
               <div class = 'p'><a href = '/index.php?r=realtyObject/OfficePaymentHistory'>История платежей</a></div>
          </div>
     </div>

     <div class = 'PVConteiner' style = 'padding-left:20px; padding-right:20px;'>

     	  <div class = 'tableHistoryPay'>
               <div class = 'tabBox'>
                   <div class="tab selTab" id = '1'>База</div>
                   <div class="tab" id = '2'>Публикация</div>
               </div>

               <div class = 'tabConteiner' id = '1' style = 'display: block'>
                  <? if(!empty($data)) : ?>
			      <div class = 'thThp'>
			   	      <div class = 'thThp_th'>№</div>
                      <div class = 'thThp_th'>Сумма</div>
                      <div class = 'thThp_th'>Дата оплаты</div>
                      <div class = 'thThp_th'>Оплачено до</div>
			      </div>
			      <ol>
			      <? foreach ($data as $key => $value) : ?>
			      <div class = 'tdThp'>
			   	      <div class = 'tdThp_td'><li></li></div>
                      <div class = 'tdThp_td'><?=number_format($value['summa'],0,'',' ');?> руб.</div>
                      <div class = 'tdThp_td'><?=Yii::app()->app->formatDate($value['createDate']);?></div>
                      <div class = 'tdThp_td'><?=Yii::app()->app->formatDate($value['payDate']);?></div>
			      </div>
			      <? endforeach;?>
			      </ol>
                  <? else :?>
                      <div class = 'message'>Вы не совершили ни одного платежа!</div>
                  <? endif; ?>
               </div>

               <div class = 'tabConteiner' id = '2' style = 'display: none;'>
                   <? if(!empty($pay_public)) : ?>
                   <div class = 'thThp'>
                       <div class = 'thThp_th'>№</div>
                       <div class = 'thThp_th'>Сумма</div>
                       <div class = 'thThp_th'>Дата оплаты</div>
                   </div>

                   <ol>
                       <? foreach ($pay_public as $key => $value) : ?>
                           <div class = 'tdThp'>
                               <div class = 'tdThp_td'><li></li></div>
                               <div class = 'tdThp_td'><?=number_format($value['summa'],0,'',' ');?> руб.</div>
                               <div class = 'tdThp_td'><?=Yii::app()->app->formatDate($value['payDate']);?></div>
                           </div>
                       <? endforeach;?>
                   </ol>
                   <? else :?>
                       <div class = 'message'>Вы не совершили ни одного платежа!</div>
                   <? endif; ?>
               </div>
		  </div>


     </div>

     </div>
</div>
</div>