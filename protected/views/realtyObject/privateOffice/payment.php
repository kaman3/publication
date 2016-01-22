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



         <div class = 'PVConteiner'>

              <div class = 'rangeServices'>
                   <div class = 'rgTab1'>Выберите услугу</div>
                   <div class = 'rgTab2'>
                     <select name = 'rs' id = 'ranServ'>
                        <option value = '0'>----------</option>
                        <option value = '1'>Публикация объявлений</option>
                         <!--<option value = '2'>Доступ к базе объявлений</option>-->
                     </select>
                   </div>
               </div>

              <div class = 'hiddenformPay' style = 'display:none;'>
     	           <form action = 'ajax/payment/robokassa.php' method = 'post'>

                   <div class = 'boxTabs'>

                       <input type = 'hidden' name = 'user' value = '<? echo Yii::app()->user->id; ?>'>
                       <input type = 'hidden' name = 'summa' value = '1000'>
                       <input type = 'hidden' name = 'type' value = ''>

                       <div class = 'tab2PV'>
                            <select name = 'paymentPeriod' id = 'selectDayPayment'>
                              <!--<option value = '30'>1 месяц</option>-->
                            </select>
                       </div>

                       <div class = 'tab1PV'>
                            <div class = 'headerPayment'><?=number_format(1000,0,'',' ');?> руб.</div>
                       </div>

                       <div class = 'tab3PV'>
                            <input type = 'submit' value = 'Оплатить'>
                       </div>

                   </div>
               </form>
              <div class = 'payments_valuta'>
                   <img src = '/images/robokassa-valuta.jpg'>
              </div>
              </div>
          </div>
     </div>
</div>
</div>

<script>

 $('#ranServ').live('change',function(){

    var sel = $(this).val();

    if(sel == 1){
         var summaDefault = 100; // сумма по умолчанию (1 элемент массива)
         a = new Array([100,50,'50 штук'],[250,200,'200 штук'],[600,500,'500 штук'],[1000,1000,'1000 штук'],[5000,6000,'6000 штук']);  // цена . число дней . текст
     }
     else if(sel == 2){
         var summaDefault = 1000;
         a = new Array([1000,30,'1 месяц'],[2000,60,'2 месяца']);
     }
     else{
         var summaDefault = 0;
     }

    if(summaDefault){
        $('.hiddenformPay').css({"display":"block"});
        $('[name=summa]').val(summaDefault);   // сумма по умолчанию
        $('[name=type]').val(sel);             // выбранная услуга
        $('.headerPayment').text(summaDefault+' руб');
        // проверяем существует ли массив
        if(a){

            $("#selectDayPayment").empty();

            for(var i = 0; i < a.length; i++){
                $("#selectDayPayment").append( $('<option summa = "'+a[i][0]+'" value="'+a[i][1]+'">'+a[i][2]+'</option>'));
            }

            // теперь выберем нужный нам срок и сумму
            $('#selectDayPayment').live('change',function(){
                var summa  =  this.options[this.selectedIndex].getAttribute('summa');
                $('[name=summa]').val(summa);
                $('.headerPayment').text(summa+' руб');
            });
        }

    }else{
        $('.hiddenformPay').css({"display":"none"});
    }

 });


</script>