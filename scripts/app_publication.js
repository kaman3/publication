// публикатор
// выбор категорий
/*
$(document).ready(function(){
  
  $('#catChange_1').live('change',function(){
     var select_1 = $(this).find("option:selected").val();
     $("#catChange_2 option").css({"display":"block"});
     $("#catChange_2 [value='0']").attr("selected", "selected");

     $("#publication_idCat").attr('value',select_1);
     
     if(select_1 && select_1!=2 && select_1!=23){
        $('#catChild').css({"display":"block"});
        $("#catChange_2 [item!='"+select_1+"']").css({"display":"none"});
     }else{
        $('#catChild').css({"display":"none"});
        $("#catChange_2 [value='0']").attr("selected", "selected");
     }

  })

  $('#catChange_2').live('change',function(){
      var select_2 = $(this).find("option:selected").val();
      $("#publication_idCat").attr('value',select_2);

      if(parseInt(select_2) == parseInt(9)){
         $('#publication_deadlineRent').attr('value',1);
      }else if(parseInt(select_2) == parseInt(10)){
         $('#publication_deadlineRent').attr('value',2);
      }else{
         $('#publication_deadlineRent').attr('value',0);
      }
  });
  
})
// формируем селект для созданных объявлений с категориями
$(document).ready(function(){
  var val = $("#publication_idCat").attr('value');

  $('#catChange_2 option').each(function(){
     //console.log(this.value);
     if(val == this.value){
        $('#catChild').css({"display":"block"});
        var item = $("#catChange_2 option[value="+val+"]").attr('item');
        $("#catChange_2 [item!='"+item+"']").css({"display":"none"});
        
        $("#catChange_1 [value='"+item+"']").attr("selected", "selected");
        $("#catChange_2 [value='"+val+"']").attr("selected", "selected");

     }else{
        $("#catChange_1 [value='"+val+"']").attr("selected", "selected");
     }
  });
});
*/
// выбор города и района для пензы
$(document).ready(function(){
  // если редактируем
  var select = $('#publication_city').find("option:selected").val();
  if(select == 2){
            $('#showDistrict').css({"display":"block"});
            $('#showMicrodistrict').css({"display":"block"});
         }else{
            $('#showDistrict').css({"display":"none"});
            $('#showMicrodistrict').css({"display":"none"});
         }
  // если создаем новый 
  $('#publication_city').live('change',function(){
     var select = $(this).find("option:selected").val();
         if(select == 2){
            $('#showDistrict').css({"display":"block"});
            $('#showMicrodistrict').css({"display":"block"});
         }else{
            $('#showDistrict').css({"display":"none"});
            $('#showMicrodistrict').css({"display":"none"});
         }
  });

});

// удаление картинок
$(document).ready(function(){
  $('.del_img').live('click',function(){
     var str = $(this).parent().parent().attr('id');
     var delCache = $(this).attr('id')

     var res = str.split("/");
     //console.log(res);

     $.ajax({
            type:'GET',
            dataType: "html",
            url: "/scripts/ajaxupload/php/upload-delete.php",
            data:{userId:res[0],idTmp:res[1],name:res[2],delCache:delCache}, // поисковая фраза},
            
            success: function(data){
                if(data == 1){
                   $('li[id="'+str+'"]').remove();
                }
              }
          })
     
  });
});
// сделать картинку главной
$(document).ready(function(){
  $('.general').live('click',function(){
    var str = $(this).parent().parent().attr('id');
    var idCache = $('.del_img').attr('id');

    $('.general').attr('move',0).css({"background":"url(/scripts/ajaxupload/img/noCheck.png)"});
    $(this).attr('move',1).css({"background":"url(/scripts/ajaxupload/img/yesCheck.png)"});


    var res = str.split("/");
    if( res[2].search('_1') != -1 ){
        var clear = res[2].split("_");
        var ext = clear[1].replace("1", "");
        var name = clear[0]+ext;
    }else{
        name = res[2];
    }
      //console.log(name);



    $.ajax({
        type:'GET',
        dataType: "html",
        url: "/scripts/ajaxupload/php/upload-img-general.php",
        data:{userId:res[0],idTmp:res[1],name:name,idCache:idCache}, // поисковая фраза},

        success: function(data){
            //alert(data);
        }
    })

  });
  // делаем выбранной
    $(".general").each(function(indx,element){
       if($(element).attr('move') == 1){
           $(element).css({"background":"url(/scripts/ajaxupload/img/yesCheck.png)"});
       }
    });
    //console.log(heights);
});
// удаление объявлений
$(document).ready(function(){
  $('#delItem').live('click',function(){
     var id = $(this).attr('item');
     var redirect = $(this).attr('redirect');
     var active = $(this).attr('active');
     
     dhtmlx.confirm({
     type:"confirm-warning",
     text: "<p>Удалить объявление!</p>",
     ok:'Да',
     cancel:'Нет',
     
     callback: function(result){
          // если да
  
          if(result == true){
             document.location.href = "/index.php?r=publication/delete&id="+id+"&active="+active+"&page="+redirect;
             //location.reload();
          }           
        } 
    })

  });
});
// удаление контактов
$('#delContacts').live('click',function(){
    var id = $(this).attr('item');

    dhtmlx.confirm({
        type:"confirm-warning",
        text: "<p>Удалить контакт!</p>",
        ok:'Да',
        cancel:'Нет',

        callback: function(result){
            // если да

            if(result == true){
                document.location.href = "/index.php?r=publication/delcontacts&id="+id;
                //location.reload();
            }
        }
    })

});

$('#catChange').live('change',function(){
   var id = $(this).find("option:selected").val();

   // блокируем ненужные типы сделок
   if(id == 45 || id == 46){
      // квартиры комнаты
      $("#publication_transaction option[value='1']").prop( "disabled", true );
      $("#publication_transaction option[value='4']").prop( "disabled", true );

      $("#publication_transaction option[value='2']").prop( "disabled", false );
      $("#publication_transaction option[value='3']").prop( "disabled", false );
   }else if(id == 37 || id == 38){
      //
      $("#publication_transaction option[value='1']").prop( "disabled", false );
      $("#publication_transaction option[value='4']").prop( "disabled", false );

      $("#publication_transaction option[value='2']").prop( "disabled", true );
      $("#publication_transaction option[value='3']").prop( "disabled", true );
   }else{
      $("#publication_transaction option[value='1']").prop( "disabled", false );
      $("#publication_transaction option[value='4']").prop( "disabled", false );

      $("#publication_transaction option[value='2']").prop( "disabled", false );
      $("#publication_transaction option[value='3']").prop( "disabled", false );
   }
});
$('#catChange_1').ready(function(){
   var id = $(this).find("option:selected").val();
   // блокируем ненужные типы сделок
   if(id == 45 || id == 46){
      // квартиры комнаты
      $("#publication_transaction option[value='1']").prop( "disabled", true );
      $("#publication_transaction option[value='4']").prop( "disabled", true );

      $("#publication_transaction option[value='2']").prop( "disabled", false );
      $("#publication_transaction option[value='3']").prop( "disabled", false );
   }else if(id == 37 || id == 38){
      //
      $("#publication_transaction option[value='1']").prop( "disabled", false );
      $("#publication_transaction option[value='4']").prop( "disabled", false );

      $("#publication_transaction option[value='2']").prop( "disabled", true );
      $("#publication_transaction option[value='3']").prop( "disabled", true );
   }else{
      $("#publication_transaction option[value='1']").prop( "disabled", false );
      $("#publication_transaction option[value='4']").prop( "disabled", false );

      $("#publication_transaction option[value='2']").prop( "disabled", false );
      $("#publication_transaction option[value='3']").prop( "disabled", false );
   }
});

// выводим нужные поля для каждой категории и типа сдели
$(document).live('change ready',function(){
    var transaction  = $('#publication_transaction').find("option:selected").val();                  // тип сделки
    var idCat        = $('#publication_idCat').attr('value');                                        // id категрории

    if(idCat){
        // по умолчанию скрываем все дополнительные поля
        $('.showCat').css({"display":"none"});

        // квартиры, комнаты
        var appartments_rooms = [250,609,254];
        var key_app_rms = jQuery.inArray(parseInt(idCat), appartments_rooms);

        if(key_app_rms != -1){
           var mass = ['area','floor','floors','typeHouse','countRooms'];
           for(var i = 0; i < mass.length; i++){
               $('#publication_'+mass[i]+'').parent().css({"display":"block"});
           }
        }

        // аренда
        var rent = [543,593,592];
        var key_app_rent = jQuery.inArray(parseInt(idCat), rent);
        if(key_app_rent != -1){
            var mass = ['area','floor','floors','typeHouse','countRooms'];
            for(var i = 0; i < mass.length; i++){
                $('#publication_'+mass[i]+'').parent().css({"display":"block"});
                $('#lot').css({"display":"block"});
            }
        }

        // дома, дачи, коттеджи, таунхаусы
        var house = [249,679,681,680,676,677,678];
        var key_house = jQuery.inArray(parseInt(idCat), house);

        if(key_house != -1){
            //var mass = ['area','floors','wall_material','distance_to_town','land_area','location','deadlineRent'];
            // сдам
            if(transaction == 1){
               var mass = ['area','floors','wall_material','distance_to_town','land_area','deadlineRent'];
               // продам
            }
            else if(transaction == 2){
                 var mass = ['area','floors','wall_material','distance_to_town','land_area'];
            }
            // куплю
            else if(transaction == 3){
               var mass = ['location'];
            }
            // сниму
            else if(transaction == 4){
               var mass = ['location','deadlineRent'];
            }

        }
        // земельные участи
        var land = [563,576,575];
        var key_land = jQuery.inArray(parseInt(idCat), land);

        if(key_land != -1){
           // продам сдам
           if(transaction == 1 || transaction == 2){
               var mass = ['distance_to_town','land_area'];
           }
           // куплю сниму
           else if(transaction == 3 || transaction == 4){
                var mass = ['location'];
           }
        }
        // комерческая недвижимость
        var commercial_property = [268,669,269,270];
        var key_commercial_property = jQuery.inArray(parseInt(idCat), commercial_property);

        if(key_commercial_property != -1){
           if(transaction == 1 || transaction == 2){
               var mass = ['area','classroom_building'];
           }
           else if(transaction == 4){
               var mass = ['deadlineRent'];
           }
        }
        // гаражи стоянки
        var garages = [248];
        var key_garages = jQuery.inArray(parseInt(idCat), garages);

        if(key_garages != -1){
           if(transaction == 1 || transaction == 2){
              var mass = ['protection','area','type_garage'];
           }
        }
    //console.log(mass);
        if(mass.length > 0){
           // собираем условие, выводим результат
            for(var i = 0; i < mass.length; i++){
                $('#publication_'+mass[i]+'').parent().css({"display":"block"});
            }
        }
    }
});

// если расширенный поиск был использован
$(document).ready(function(){
    if($.cookie("showFilter") == 1){
        $('.hideFilter').css({"display":"block"});
        $('#showMe').text('Скрыть');
    }else{
        $('.hideFilter').css({"display":"none"});
    }
})
// показываем/скрываем расширенный поиск
$('#showMe').live('click',function(){
    var display = $('.hideFilter').css('display');
    if(display == 'none'){
        $('.hideFilter').slideDown(200);
        $(this).text('Скрыть');
        $.cookie("showFilter", 1);
    }else{
        $('.hideFilter').slideUp(200);
        $(this).text('Расширенный поиск');
        $.cookie("showFilter", 0);
    }
});

$('.buttonPubCheck').live('click',function(){

    var selectedItems = [];
    var phone = [];

    var cron = $("select#cronCheck").val();

    $("input[name='cbname3[]']:checked").each(
        function(){
            if($(this).val() != 0){ // исключаем заголовок выбора
               selectedItems.push($(this).attr('userId')+':'+$(this).val()+':'+$(this).attr('userName')+':'+cron);
            }
        });
    console.log(selectedItems);

    dhtmlx.confirm({
        type:"confirm-warning",
        text: "<p>Вы уверены?</p>",
        ok:'Да',
        cancel:'Нет',

        callback: function(result){

            if(result == true){
                $('.load').css({"display":"block"});
                $.ajax({
                    type:'get',
                    dataType: "html",
                    url: "/index.php?r=publication/AllCron&param="+selectedItems,
                    //data:{param:selectedItems}, // поисковая фраза},

                    success: function(data){
                         if(data){
                            $('.load').css({"display":"none"});
                            location.reload();
                         }
                    }
                })
            }
        }
    });

});
// активировать если выбранны елементы
$('.example_check, #example_maincb').live('click', function(){
    var selectedItems = [];
    $("input[name='cbname3[]']:checked").each(function(){selectedItems.push($(this).val())});
    if(selectedItems.length > 0){
       $('.pCheckTable').slideDown(300);
    }else{
       $('.pCheckTable').slideUp(300);
    }
});
// удить все выбраные елементы
$('.buttonDelChange').live('click',function(){

    var selectedItems = [];

       $("input[name='cbname3[]']:checked").each(function(){
           if($(this).val() != 0){ // исключаем заголовок выбора
              selectedItems.push($(this).val())
           }
       });


    dhtmlx.confirm({
        type:"confirm-warning",
        text: "<p>Вы уверены?</p>",
        ok:'Да',
        cancel:'Нет',

        callback: function(result){

            if(result == true){
                $('.load').css({"display":"block"});
                $.ajax({
                    type:'get',
                    dataType: "html",
                    url: "/index.php?r=publication/DelChangeAds&param="+selectedItems,

                    success: function(data){
                        if(data){
                            $('.load').css({"display":"none"});
                            location.reload();
                            //alert(data);
                        }
                    }
                })
            }
        }
    })
});
// скрыть/показать все элементы
$('.sab_button').live('click', function(){

    var selectedItems = [];

    var  show = $(this).attr('id');

    $("input[name='cbname3[]']:checked").each(function(){
        if($(this).val() != 0){ // исключаем заголовок выбора
            selectedItems.push($(this).val())
        }
    });

    if(show == 1){
       var textButton = '<p>Публиковать отмеченные</p>';
    }else{
       var textButton = '<p>Снять с публикации</p>';
    }

    dhtmlx.confirm({
        type:"confirm-warning",
        text: textButton,
        ok:'Да',
        cancel:'Нет',

        callback: function(result){

            if(result == true){
                $.ajax({
                type:'get',
                dataType: "html",
                url: "/index.php?r=publication/ShowUp&show="+show+"&str="+selectedItems,

                success: function(data){
                    if(data){
                       location.reload();
                    }else{
                       alert('Ошибка');
                    }
                }
            })
        }
      }
    });

});

$('#catChange_2').live('focus', function(){
    $('#catChange_2').css({'border':'1px solid #bdbdbd'});
});


$('#pbsave input').click(function(){

    var cat1 = $("#catChange_1 option:selected").val();

    if(cat1 != 2 && cat1 != 23){
        var cat2 = $("#catChange_2 option:selected").val();

        if(cat2 == 0){
            dhtmlx.message({
                type: "alert-warning",
                text: "<p>Выберите подкатеогрию.</p>",
                callback: function(result){
                    // если да

                    if(result == true){
                        $('#catChange_2').css({'border':'1px solid red'});
                        $('body,html').animate({scrollTop: 0}, 100);
                    }
                }
            });
            return false;
        }
    }

    var r = '';

    $(".t-item").each(function(){
        r = r+$(this).attr('day')+"/"+$(this).attr('hours')+":";
    });

    if(r.length == 0){
        dhtmlx.message({
            type: "alert-warning",
            text: "<p>Вы не добавили время публикации.</p>",
            callback: function(result){
                // если да

                if(result == true){
                    $('body,html').animate({scrollTop: 0}, 100);
                }
            }
        });
        return false;
    }else{
        if(r){
           $('#publication_pDayHours').attr('value','');
           $('#publication_pDayHours').attr('value',r);
        //return false;
        }

    }



});

// отмечаем нужные нам дни
$('.boxCheckDay ul li').live('click', function(){
    if($(this).hasClass("cdays")){
        $(this).removeClass('cdays');
    }else{
        $(this).addClass('cdays');
    }
});

$(document).ready(function(){
    // отмечаем дни
    var pDay = $('#publication_pDay').val();
        if(pDay){
            pDayArr = pDay.split(',');
            if(pDayArr.length > 0){
                for(var i = 0; i < pDayArr.length; i++){
                  $('.boxCheckDay ul li[item='+pDayArr[i]+']').addClass('cdays');
                }
            }
         }
    // отмечаем часы
    var default_time = $('#publication_pHours').val();
    var default_witch = 38;
    var step = parseInt(default_time)*parseInt(default_witch);

    $(this).find('ul').css({'top':'-'+step+'px'});

});
// открыть закрыть оекно с назначением времени
$('.new-at, .reveal-modal-bg').live('click', function(){
    $('.VjCarouselLite').css({"opacity":"1"});
    $('.boxCheckDay ul li').removeClass('cdays');

    // применяется когда изменяем несолько элементо
});
// если выделенно несколько
$('.p-select-timer').live('click', function(){
    $('.VjCarouselLite').css({"opacity":"1"});
    $('.boxCheckDay ul li').removeClass('cdays');
    $('.list-atb').empty();
    $('.c-list-index').hide();
    $('.new-time-index').css({"display":"block"});
});

$('.reveal-modal-bg').live('click', function(){
    $('.VjCarouselLite').css({"opacity":"0"})
});

$('#clickTimeClose').live('click', function(){
   $('.reveal-modal-bg').click();
});

$('#clickTimeIndex').live('click', function(){

    $('.c-list-index').slideUp(300);
    $('.boxCheckDay ul li').removeClass('cdays');

});

$('#clickSaveAll').live('click', function(){
    var r = '';
    var ids = [];

    $(".t-item").each(function(){
        r = r+$(this).attr('day')+"/"+$(this).attr('hours')+":";
    });

    $("input[name='cbname3[]']:checked").each(
        function(){
            if($(this).val() != 0){ // исключаем заголовок выбора
                ids.push($(this).val());
            }
        });

    if(r.length == 0){
        dhtmlx.message({
            type: "alert-warning",
            text: "<p>Вы не назначили дату публикации.</p>",
            callback: function() {}
        });
        return false;
    }else{
        $('.load').css({"display":"block"});
        $('.reveal-modal-bg').click();
        $.ajax({
            type:'get',
            dataType: "html",
            url: "/index.php?r=publication/AllCron&elem="+r+'&ids='+ids,

            success: function(data){
                if(data){
                    $('.load').css({"display":"none"});
                    location.reload();
                }
            }
        })

    }
});

$('#clickTimeSave').live('click', function(){

    // редактируем созданный таймер
    var selectedItems = [];

    $(".boxCheckDay ul li").each(function(){
        if($(this).hasClass("cdays")){
            selectedItems.push($(this).attr('item'));
        }
    });

    var i = $('.VjCarouselLite').find('ul').css('top');
    var y = parseInt(i)/parseInt(38);
    if(y == -24){
        var tm = 0;
    }else if(y == -25){
        var tm = 1;
    }else{
        var tm =  parseInt(Math.abs(y));
    }

    if(selectedItems.length == 0){
        dhtmlx.message({
            type: "alert-warning",
            text: "<p>Вы не выбрали дни для публикации.</p>",
            callback: function() {}
        });
        return false;
    }else{

        $('.c-list-index').slideDown(400);
        // добавили
        days = ['no','Пн','Вт','Ср','Чт','Пт','Сб','Вс'];
        var d = '';

        for(var i = 0; i < days.length; i++){
            for(var t = 0; t < selectedItems.length;t++){
                if(parseInt(i) == parseInt(selectedItems[t])){
                    var d = d+'-'+days[i];
                }
            }
        }
        // дни в которые назначена публикация
        var dG = d.substr(1);
        var time = tm+':00 до '+(parseInt(tm)+parseInt(1))+':00';
        //console.log(time)

        $('.list-atb').prepend('<div class = "t-item"  day = "'+selectedItems+'" hours = "'+tm+'"><div class = "t-item-time"><div class = "b-days"><div class = "b-dt-td1">Дни недели:</div><div class = "b-dt-td2">'+dG+'</div></div><div class = "b-time"><div class = "b-dt-td1">В интервале:</div><div class = "b-dt-td2">'+time+'</div></div></div><div class = "t-item-remove"><img src="/publish/resources/images/basket.png"></div></div>');
        $('.t-item:eq(0)').animate({opacity:1},1800);

        if($('.t-item').length > 3){
            $('.new-time-index').css({"display":"none"});
        }

    }
});

//// все заново ////
$('#click-ts-el').live('click', function(){
    // редактируем созданный таймер
    var removeIndex = $(this).attr('index');

    if(removeIndex != ''){
       $('.t-item:eq('+removeIndex+')').remove();
       $(this).attr('index',''); // в конце удаляем индефикатор
    }
    // редактируем созданный таймер
    var selectedItems = [];

    $(".boxCheckDay ul li").each(function(){
        if($(this).hasClass("cdays")){
            selectedItems.push($(this).attr('item'));
        }
    });


    var i = $('.VjCarouselLite').find('ul').css('top');
    var y = parseInt(i)/parseInt(38);
    if(y == -24){
        var tm = 0;
    }else if(y == -25){
        var tm = 1;
    }else{
        var tm =  parseInt(Math.abs(y));
    }

    if(selectedItems.length == 0){
        dhtmlx.message({
            type: "alert-warning",
            text: "<p>Вы не выбрали дни для публикации.</p>",
            callback: function() {}
        });
        return false;
    }else{
       // Math.abs(y)
       // добавили
        days = ['no','Пн','Вт','Ср','Чт','Пт','Сб','Вс'];
        var d = '';

        for(var i = 0; i < days.length; i++){
            for(var t = 0; t < selectedItems.length;t++){
                if(parseInt(i) == parseInt(selectedItems[t])){
                   var d = d+'-'+days[i];
                }
            }
        }
        // дни в которые назначена публикация
        var dG = d.substr(1);
        var time = tm+':00 до '+(parseInt(tm)+parseInt(1))+':00';
        console.log(time)

        $('.list-atb').prepend('<div class = "t-item"  day = "'+selectedItems+'" hours = "'+tm+'"><div class = "t-item-time"><div class = "b-days"><div class = "b-dt-td1">Дни недели:</div><div class = "b-dt-td2">'+dG+'</div></div><div class = "b-time"><div class = "b-dt-td1">В интервале:</div><div class = "b-dt-td2">'+time+'</div></div></div><div class = "t-item-remove"><img src="/publish/resources/images/basket.png"></div></div>');
        $('.t-item:eq(0)').animate({opacity:1},1800);
        // закрываем
        $('.reveal-modal-bg').click();

        if($.cookie("intVal")){
           $timerCount = $.cookie("intVal");
        }else{
           $timerCount = 1;
        }

        if($('.t-item').length > $timerCount){
           $('.new-at').css({"display":"none"})
        }
    }
});
// удаляем таймер
$('.t-item-remove').live('click', function(){

    if($.cookie("intVal")){
        $timerCount = $.cookie("intVal");
    }else{
        $timerCount = 1;
    }

    $(this).parents('.t-item').remove();
    if($('.t-item').length <= $timerCount){
          $('.new-at').css({"display":"block"});
          $('.new-time-index').css({"display":"block"});
    }

});
// редактируем таймер\
$('.t-item-time').live('click', function(){
    var day = $(this).parents('.t-item').attr('day');
    var hours = $(this).parents('.t-item').attr('hours');

    var index = $(this).parents('.t-item').index();


    var arr = day.split(',');

    if(arr.length > 0){
       // устанвливаем индекс элемента необходимо для релактирования
       $('#click-ts-el').attr('index',index);
       // вызываем окно для редактирования
       $('.new-at a').click();

       // устанавливаем дни
       for(var i = 0; i < arr.length; i++){
           $('.boxCheckDay ul li[item='+arr[i]+']').addClass('cdays');
       }

       // устанавливам времмя
       var default_witch = 38;
       var step = parseInt(hours)*parseInt(default_witch);

       $('.VjCarouselLite').find('ul').css({'top':'-'+step+'px'});
       $.cookie("timer", hours, { path:'/'});

    }
});
// редактирование таймера
$(document).ready(function(){
    if($.cookie("intVal")){
        $timerCount = $.cookie("intVal");
    }else{
        $timerCount = 1;
    }
    $('.t-item').css({"opacity":"1"});
    if($('.t-item').length > $timerCount){
       $('.new-at').css({"display":"none"});
    }
});
//
$('#catChange').live('change',function(){

    var id = $(this).find("option:selected").val();
    var select_id = $(this).find("option:selected").attr('selid');
    var bid = $(this).find("option:selected").attr('bid');

    var next_sel = parseInt(select_id)+1;
    var hide_sel = parseInt(select_id)+2;
    $('.loadCatGif').css({"display":"block"});
    // если первую збрасываем в ноль
    if(select_id == 1 && id == 9999){
        $('#publication_idCat').attr('value','');
        for(var i = 2; i < 10; i++){
            $('[name=catChange_'+i+']').html('');
            $('[name=catChange_'+i+']').parent().css({"display":"none"});
        }
    }

    // очищаем следующие категории
    for(var i = hide_sel; i < 10; i++){
        $('[name=catChange_'+i+']').html('');
        $('[name=catChange_'+i+']').parent().css({"display":"none"});
    }

    $.ajax({
        type:'get',
        dataType: "html",
        url: "/index.php?r=publication/GetCat",
        data:{id:id,selid:select_id},

        success: function(data){

            if(data){
                $('[name=catChange_'+next_sel+']').parent().css({"display":"block"});
                $('[name=catChange_'+next_sel+']').html('');
                $('[name=catChange_'+next_sel+']').html(data);
                $('.loadCatGif').css({"display":"none"});
            }else{
                $('[name=catChange_'+next_sel+']').parent().css({"display":"none"});
                $('[name=catChange_'+next_sel+']').html('');
                $('.loadCatGif').css({"display":"none"});

            }
        }
    })

    //alert(bid)
    $('#publication_idCat').attr('value',bid);
});
// скрвть показать выбор категорий
$('.amendCat').live('click', function(){
    var disp = $('.catBoxPublic').css("display");

    if(disp == 'none'){
       $('.catBoxPublic').slideDown(300);
       $(this).text('Нет, не надо');
    }else{
       $('.catBoxPublic').slideUp(300);
       $(this).text('Изменить');
    }

});
// делаем фиксированное меню
$(document).ready(function(){
    $(function () {
        $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('.fixedPMtnu').addClass('addFiixedMenu');
                } else {
                    $('.fixedPMtnu').removeClass('addFiixedMenu');
                }


        });

    });
});
// показать скрыть таймер времени

$('.timerPublicNew').hover(
    function(){
        $(this).find('.hideTimerItem').css({"display":"block"});
    },
    function(){
        $(this).find('.hideTimerItem').css({"display":"none"});
    }
);
// показать свою сортировку для каждого раздела
$('#changeCat').live('change',function(){
    var select_1 = $(this).find("option:selected").val();
    // если выбранна недвижимость подключаем фильтр для нее
    if(select_1 == 1 ){
       $('#rielt').slideDown(300);
    }else{
       $('#rielt').slideUp(300);
    }
});
$(document).ready(function(){
    var select_1 = $('#changeCat').find("option:selected").val();
    // если выбранна недвижимость подключаем фильтр для нее
    if(select_1 == 1 ){
        $('#rielt').slideDown(300);
    }else{
        $('#rielt').slideUp(300);
    }
});
// дополнительная форма для автомобилей
$('#catChange').live('change',function(){
    var select_1 = $(this).find("option:selected").attr('bid');
    //alert(select_1)
    if(select_1 == 121 || select_1 == 120){
       $('.avtoForm').slideDown(300);
    }else{
       $('.avtoForm').slideUp(300);
    }
});
$(document).ready(function(){
    var select_1 = $('#publication_idCat').val();
    //alert(select_1)
    if(select_1){
       if(select_1 == 121 || select_1 == 120){
           $('.avtoForm').css({"display":"block"});
        }else{
           $('.avtoForm').css({"display":"none"});
       }
    }

});
// ajax загрузка модели по бренду
$('#brendGet').live('change', function(){
    var select_1 = $(this).find("option:selected").attr('id');
    if(select_1){
        $.ajax({
            type:'get',
            dataType: "html",
            url: "/index.php?r=publication/GetModelAvto",
            data:{id:select_1},

            success: function(data){
                if(data){
                   $('#modelAvto select').html('');
                   $('#modelAvto').css({"display":"block"});
                   $('#modelAvto select').html(data);
                }
            }
        })
    }
});

