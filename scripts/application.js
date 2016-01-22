// кнопка вверх
$(document).ready(function(){
    $("#back-top").hide();
    $(function () {
      $(window).scroll(function () {
        if($(window).width() > 1035){
           if ($(this).scrollTop() > 150) {
               $('#back-top').fadeIn();
           } else {
               $('#back-top').fadeOut();
           }
        }

      });
      $('#back-top a').click(function () {
        $('body,html').animate({
          scrollTop: 0
        }, 800);
        return false;
      });
    });
});
// всплывающее окно
$(document).ready(function() {
     $('#myButton').click(function(e) {
          e.preventDefault();
      $('#myModal').reveal();
     });
});
// количество выбраных районов
$(document).ready(function(){
  var t = $('.itemMCBox input:checked');
      if(t.length > 0){
         $('.countElementMdistr').css({"opacity":"1"});
         $('.countElementMdistr').text(t.length);
         $('.bottomMicrDis a').text('Микрорайонов выбранно').css({"color":"red"});
         // для публикатора
         $('.bottomMicrDisFilter a').text('Микрорайонов выбранно').css({"color":"red"});
      }else{
         $('.countElementMdistr').css({"opacity":"0"});
      }
      
      var selectedItems = [];
      $("input[name='microdistricts[]']:checked").each(function(){selectedItems.push($(this).val());});

      for(var i = 0; i < selectedItems.length; i++){
         $("input[name='microdistricts[]'][value="+selectedItems[i]+"]").parents(".itemMCBox").css({"background":"#ffae3a"});
      }
      
      
})
$('.close-reveal-modal').live('click',function(){
  var t = $('.itemMCBox input:checked');
      if(t.length > 0){
         $('.countElementMdistr').css({"opacity":"1"});
         $('.countElementMdistr').text(t.length);
         $('.bottomMicrDis a').text('Микрорайонов выбранно').css({"color":"red"});
          // для публикатора
         $('.bottomMicrDisFilter a').text('Микрорайонов выбранно').css({"color":"red"});
      }else{
         $('.countElementMdistr').css({"opacity":"0"});
         $('.bottomMicrDis a').text('Выбрать микрорайон').css({"color":"#a9a9a9"});
          // для публикатора
         $('.bottomMicrDisFilter a').text('Выбрать микрорайон').css({"color":"#a9a9a9"});
      }
  
});

$('.itemMCBox').live('click',function(){
   var t = $(this).find('input').attr('checked');
   var v = $(this).find('input').val();
   
   if(t == 'checked'){
      $("input[name='microdistricts[]'][value="+v+"]").parents(".itemMCBox").css({"background":"#ffae3a"});
   }else{
      $("input[name='microdistricts[]'][value="+v+"]").parents(".itemMCBox").css({"background":"none"});
   }
       
})

// плучаем get переменную
function parseGetParams() {
    var $_GET = {};
    var __GET = window.location.search.substring(1).split("&");
    for(var i=0; i<__GET.length; i++) {
        var getVar = __GET[i].split("=");
        $_GET[getVar[0]] = typeof(getVar[1])=="undefined" ? "" : getVar[1];
    }
    return $_GET;
}
// если расширенный поиск был использован

  $(document).ready(function(){
     // получаем get переменные
     //var GETArr = parseGetParams();
     var showInsidePage = $('.showSearscBlock').attr('data');
     //console.log(GETArr['id']);
     //if(GETArr['id']){
     if(showInsidePage != 1){
        if($.cookie("showSearch") == 1){
           $('.noneSearch').css({"display":"block"});
           $('#clickSearch').text('Скрыть');
        }else{
           $('.noneSearch').css({"display":"none"});
        }
     }else{
         $('.noneSearch').css({"display":"none"});
         $('#clickSearch').text('Расширенный поиск');
     }
     //}else{
     //      $('.noneSearch').css({"display":"block"});
     //      $('#clickSearch').text('Скрыть');
    // }

  });

$(document).ready(function(){
    var display = $('.noneSearch').css('display');
    if(display == 'block'){
       $('#clickSearch').text('Скрыть');
    }else{
       $('#clickSearch').text('Расширенный поиск');
    }
});
  // показываем/скрываем расширенный поиск
  $('#clickSearch').live('click',function(){
     var display = $('.noneSearch').css('display');
     if(display == 'none'){
         $('.noneSearch').slideDown(200);
         $(this).text('Скрыть');
         $.cookie("showSearch", 1, { path:'/'});
     }else{
         $('.noneSearch').slideUp(200);
         $(this).text('Расширенный поиск');
         $.cookie("showSearch", 0, { path:'/'});
     }
  });

  // число разделенное разрядами
  $('#mask').live('keyup',function(){
     var c = $(this).val();
     $(this).val(accounting.formatNumber(c,0, " "));
  })

  // сортировка по собственникам
   $(document).ready(function(){
     if(!$.cookie("seller")){
        $('.sortAgent[id = 0]').css({"background":"#c1c1c1"})
     }else{
        var id = $.cookie("seller");
        $('.sortAgent[id = '+id+']').css({"background":"#c1c1c1"});
     }
   })

   $('.sortAgent').live('click',function(){
      var id = $(this).attr('id');
      $('.sortAgent').css({'background':'#fff'});
      $(this).css({'background':'#c1c1c1'});
      location.reload();

      $.cookie("seller", id, { path:'/'}); 

   })

// определляем по сколько страниц показывать
$(document).ready(function(){
  if(!$.cookie("countPage")){
      $.cookie("countPage",20);
  }
      $("#countSP [value='"+$.cookie("countPage")+"']").attr("selected", "selected");
})

$('#countSP').live('change',function(){
  var option = $(this).find('option:selected').val();
  if($.cookie("countPage",option));
     document.location.reload(true);
})

// сортировка по цене
$('#order').live('change',function(){
    var option = $(this).find('option:selected').val();
    if($.cookie("order",option));
    document.location.reload(true);
})
$(document).ready(function(){
    if(!$.cookie("order")){
        $.cookie("order",1);
    }
    $("#order [value='"+$.cookie("order")+"']").attr("selected", "selected");
})
// сортировка по цене конец
 $("a.gallery").fancybox();
 // инициализируем кнопку 
 $(document).ready(function(){
  var agent = $('#agent').attr('data');
    if(agent == 2){
      $('.buttonAgent').css({"display":"none"})
    }else{
      $('.buttonAgent').css({"display":"block"})  
    }
 })

 $('.buttonAgent').live('click',function(){
     var phone = $('#phoneButton').text();
     var objectId = $("#agent").attr('data-id');

     dhtmlx.confirm({
     type:"confirm-warning",
     text: "<p>Вы уверены что это агент!</p>",
     ok:'Да',
     cancel:'Нет',
     
     callback: function(result){
          // если да
  
          if(result == true){
             $.ajax({
                  type:'GET',
                  dataType: "html",
                  url: "/ajax/thisAgent.php",
                  data:{phone:phone,objectid:objectId}, // поисковая фраза},
                  
                  success: function(data){

                           dhtmlx.message({
                           type: 'error',
                           text: "Вы добавили номер в базу",
                           expire:1000,
                           });

                    }
                })
            }           
        } 
    })
})

$(document).ready(function(){

  if($.cookie("looked")){
     var look = $.cookie("looked");
     var mass = look.split(',');

     for (var i = 0; i < mass.length; i++) {
          $('.BoxRealtyObject[item='+mass[i]+'][views=1]').css({"background":"#ffded6"});
          $('.BoxRealtyObject[item='+mass[i]+'][views=1] .browse').css({"display":"block"});
     }
  }
})
// просмотрен или не просмотрен объект
$('.urlTd a, .hiddenImg a').live('click',function(){

    if($.cookie("looked")){
       var look = $.cookie("looked");
    }else{
       var look = '';
    }

    var id = $(this).attr('item');


    var pos = look.indexOf(id);
    
    if(pos > -1) {
    }else{
      look = look + id+',';
    }

    $.cookie("looked",look,{ path:'/'});

    $('.BoxRealtyObject[item='+id+']').css({"background":"#ffded6"});
    $('.BoxRealtyObject[item='+id+'] .browse').css({"display":"block"});
    

});
  // админка для агентов
  // чекбоксы 
    $(document).ready( function() {
       $("#example_maincb").click( function() { // при клике по главному чекбоксу
            if($('#example_maincb').attr('checked')){ // проверяем его значение
                $('.example_check:enabled').attr('checked', true); // если чекбокс отмечен, отмечаем все чекбоксы
            } else {
                $('.example_check:enabled').attr('checked', false); // если чекбокс не отмечен, снимаем отметку со всех чекбоксов
            }
       });
    });
// активировать если выбранны елементы
$('.example_check, #example_maincb').live('click', function(){
    var selectedItems = [];
    $("input[name='cbname3[]']:checked").each(function(){selectedItems.push($(this).val())});
    if(selectedItems.length > 0){
        $('.c-panel-rules').slideDown(300);
    }else{
        $('.c-panel-rules').slideUp(300);
    }
});
// удаяляем выделенные елементы (объявления)
$('#c-dell-ads').live('click', function(){
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
                $.ajax({
                    type:'get',
                    dataType: "html",
                    url: "/index.php?r=realtyObject/delCheckedAds&param="+selectedItems,

                    success: function(data){
                        if(data){
                            location.reload();
                            //alert(data);
                        }
                    }
                })
            }
        }
    });
});
$('.cdel').live('click', function(){

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
                    url: "/index.php?r=realtyObject/ShowCheckedAds&show="+show+"&str="+selectedItems,

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
    
    // агент или нет/ по одному
    $('#clickAgent').live('click',function(){
      var action = $(this).attr('action');
      var id = $(this).parents(".PhoneAgentItem").attr('item');
      var phone = $(this).parents(".PhoneAgentItem").find('.tdPaItem_1').text();

         dhtmlx.confirm({
       type:"confirm-warning",
       text: "Вы уверены?",
       ok:'Да',
       cancel:'Нет',
       
       callback: function(result){

        if(result == true){
        
                $.ajax({
                  type:'GET',
                  dataType: "html",
                  url: "/ajax/agentPhone/phoneAgentButton.php",
                  data:{action:action,id:id,phone:phone}, // поисковая фраза},
                  
                  success: function(data){
                      $(".PhoneAgentItem[item="+id+"]").slideUp(200);     
                           
                    }
                })
              }
            }
         })
      
    })
    // агент или нет все вместе
    $('#clickAgentCheck').live('click',function(){

        var action = $(this).attr('action');
         
          var selectedItems = [];
          var phone = [];
        
        $("input[name='cbname3[]']:checked").each(function(){selectedItems.push($(this).val());});

        if(selectedItems.length > 0){

          for(var i = 0; i < selectedItems.length; i++){
              phone[i] = $('.PhoneAgentItem[item='+selectedItems[i]+']').find('.tdPaItem_1').text();
          }

         dhtmlx.confirm({
         type:"confirm-warning",
         text: "Вы уверены?",
         ok:'Да',
         cancel:'Нет',
         
         callback: function(result){

          if(result == true){
          
                  $.ajax({
                    type:'GET',
                    dataType: "html",
                    url: "/ajax/agentPhone/phoneAgentCheck.php",
                    data:{action:action,phone:phone}, // поисковая фраза},
                    
                    success: function(data){
                        
                          for(var i = 0; i < selectedItems.length; i++){
                                $('.PhoneAgentItem[item='+selectedItems[i]+']').slideUp(200);
                            }    
                             
                      }
                  })
                }
              }
           })

          //console.log(phone);
        }else{
          dhtmlx.alert("Ни чего не выбрано!");
        }
    });
// создание новой категории в блокноте
// выпадашка
$('.newButtonCatBook, .closeNewCatB').live('click',function(){
    var display = $('.boxNewCat').css('display');
    // очищаем поле при созданиии новой
    $('.inputBoxNewCat [name=newCat]').val('');

        if(display == 'none'){
            $('.boxNewCat').css({"display":"block"});
            $('.newButtonCatBook').css({"opacity":"0.7"});
        }else{
            $('.boxNewCat').css({"display":"none"});
            $('.newButtonCatBook').css({"opacity":"1"});
        }
});
// создать кнопка
$('.createNewCatB').live('click',function(){
   var form = $(this).parent().parent().parent(".newCatBook").attr('form');
   var name = $('.newCatBook[form='+form+'] .boxNewCat .inputBoxNewCat input').val();
   var user = $(this).attr('user');

       if(name.length > 0){
           $.ajax({
               type:'POST',
               dataType: "html",
               url: "/ajax/notebook/create.php",
               data:{name:name,user:user}, // поисковая фраза},

               success: function(data){
                  if(data){
                     if(form == 1){
                        $('.notebookList ul').append('<li item = '+data+'><img src="/images/notebook/li_img.png">'+name+'</li>');
                        $('.newButtonCatBook').css({"opacity":"1"});
                        $('.boxNewCat').css({"display":"none"});
                        $('[name=newCat]').val('');
                     }else{
                        document.location.reload(true);
                     }

                  }else{
                     dhtmlx.alert("Ошибка");
                  }


               }
           });
       }else{
         dhtmlx.alert("Вы не ввели название категории");
       }
});
// подсветка елементов блокнота
$('.ul_bcnb, .item_gcn').hover(
    function(){
        $(this).css({"border-color":"#ccc"});
        $(this).find('.li_upd_bcnb, .li_remove_bcnb').css({"opacity":"1"});
    },
    function(){
        $(this).css({"border-color":"#ececec"});
        $(this).find('.li_upd_bcnb, .li_remove_bcnb').css({"opacity":"0.2"});
    }
);
// удалить категорию из блокнота
$('.li_remove_bcnb').live('click',function(){
    var remove = $(this).parents(".ul_bcnb").attr('id');
    if(remove){
        dhtmlx.confirm({
            type:"confirm-warning",
            text: "<p>Удалить?</p>",
            ok:'Да',
            cancel:'Нет',

            callback: function(result){
                if(result == true){
                 $.ajax({
                   type:'POST',
                   dataType: "html",
                   url: "/ajax/notebook/remove.php",
                   data:{id:remove}, // поисковая фраза},

                   success: function(data){
                      if(data == 1){
                         document.location.reload(true);
                      }else{
                         dhtmlx.alert("Ошибка");
                      }
                 }
            });
          }
        }
    });
    }
});
// изменить элемент блокнота
$('.li_upd_bcnb').live('click', function(){
  var read = $(this).attr('read');
  var id =  $(this).parents(".ul_bcnb").attr('id');
      if(read == 0){

         $(this).attr('read',1); // делаем отметку что редактируем

         $(this).prev('.li_name_bcnb').find('a').css({"display":"none"});
         $(this).prev('.li_name_bcnb').find('#up_input_title').css({"display":"block"});

         $(this).find('img').attr('src','/images/notebook/up_end.png')

      }
      // редактируем заголовок
      else if(read == 1){
          var title = $(this).prev('.li_name_bcnb').find('#up_input_title').val();
          if(title.length > 0){
               $.ajax({
                   type:'POST',
                   dataType: "html",
                   url: "/ajax/notebook/update.php",
                   data:{id:id,title:title}, // поисковая фраза},

                   success: function(data){
                       //if(data == 1){
                         if(title.length > 25){
                            var title_subst = title.substr(0, 25);
                         }else{
                            var title_subst = title;
                         }
                         // убираем инпут где редактировали
                         $('.ul_bcnb[id='+id+']').find('#up_input_title').css({"display":"none"});
                         // показываем отредактированный текст
                         $('.ul_bcnb[id='+id+'] .li_name_bcnb').find('a').text(title_subst);
                         $('.ul_bcnb[id='+id+'] .li_name_bcnb').find('a').css({"display":"block"});

                         // делаем элемент вновь доступным для редактирования
                           $('.ul_bcnb[id='+id+'] .li_upd_bcnb').attr('read',0);
                           $('.ul_bcnb[id='+id+'] .li_upd_bcnb').find('img').attr('src','/images/notebook/up_notebook.png')

                      // }
                   }
               });
           }
      }
});

// блокнот
$(document).ready(function(){
  if($.cookie("notebook")){
     var notebook = $.cookie("notebook");
     var mass = notebook.split(',');

     for (var i = 0; i < mass.length; i++) {
          $('.BoxRealtyObject[item='+mass[i]+'] .notebook img').attr('src','/images/noteadd.png');
          //$('.addNotebook[item='+mass[i]+']').attr('add',1);
          //console.log(mass[i]);
     }
  }
});
// добавление из списка 
$('.notebook, .addNotebook').live('click',function(){

    // сотрим зарегистирован пользователь или нет
    var reg = $(this).attr('reg');
    var add = $(this).attr('add');
    var id  = $(this).parents('.BoxRealtyObject').attr('item');
    var location = $(this).attr('location');

    if(id === undefined){
       var id =  $(this).attr('item');
    }else{
       id = id;
    }

    if(reg == 0){

        if($.cookie("notebook")){
           var notebook = $.cookie("notebook");
        }else{
           var notebook = '';
        }

        var pos = notebook.indexOf(id);
    
        if(pos > -1) {
        }else{
           notebook = notebook + id+',';

           dhtmlx.message({
           type: 'error',
           text: "<p>Добавлено в блокнот</p>",
           expire:1000
           });

           $('.BoxRealtyObject[item='+id+'] .notebook img').attr('src','/images/noteadd.png');
           //$('.addNotebook').css({"display":"none"});
        }

        $.cookie("notebook",notebook,{ path:'/'});
    }else{
        if(add == 0){
            $('.notebookList').attr('ads','').attr('ads',id);
            $('.nb_box').css({'display':'block'});
        }else{
            if(location == 1){

                dhtmlx.confirm({
                    type:"confirm-warning",
                    text: "<p>Этот объект уже был добавлен в один из блокнотов. Добавить его еще раз.</p>",
                    ok:'Да',
                    cancel:'Нет',

                    callback: function(result){
                        if(result == true){
                           $('.nb_box').css({'display':'block'});
                        }
                    }
                })

            }else{
                var href = $('.BoxRealtyObject[item='+id+']').find('.urlTd a').attr('href');
                dhtmlx.alert({
                    text: "<p>Для повторного добавления вам необходимо <a href = "+href+">открыть объявление.</a></p>",
                    ok:'Отмена',
                    callback: function() {}
                });
            }

        }
    }
});
// закрыть окео выбор блокнота
$('.ntb_close, .nb_backg').click(function(){
    $('.nb_box').css({'display':'none'});
});
// выбор элемента в блокнот
$('.notebookList ul li').live('click',function(){



    var item = $(this).attr('item');                           // id категории
    var id   = $('.notebookList').attr('ads');                 // id элемента

    if(item == 0){
        $('.newButtonCatBook').click()
    }else{

    if(id === undefined){
       id = $('.BoxAddNotebook .addNotebook').attr('item');
    }

    $.ajax({
        type:'POST',
        dataType: "html",
        url: "/index.php?r=realtyObject/AddNotebook&idCat="+item+"&id="+id,

        success: function(data){
          if(data == 1){
             //$('.addNotebook').css({'display':'none'});     // в полном описаниии
             $('.nb_box').css({'display':'none'});

             $('.BoxRealtyObject[item='+id+'] .notebook img').attr('src','/images/noteadd.png');
             $('.BoxRealtyObject[item='+id+'] .notebook').attr('add',1);
             $('.BoxRealtyObject[item='+id+'] .notebook span').attr('data-hint','Для повторного добавления откройте объявление');
             $('.addNotebook').attr('add',1);


              dhtmlx.message({
                  type: 'error',
                  text: "<p>Добавлено в блокнот</p>",
                  expire:1000
              });
          }
        }
    });
    }

});
// добавление из объекта
/*
$('.addNotebook').live('click',function(){
    var id =  $(this).attr('item');
    var reg = $(this).attr('reg');
    var add = $(this).attr('add');


   if(reg == 0){

       if($.cookie("notebook")){
          var notebook = $.cookie("notebook");
       }else{
          var notebook = '';
       }

       var pos = notebook.indexOf(id);

       if(pos > -1) {
       }else{
         notebook = notebook + id+',';

            dhtmlx.message({
            type: 'error',
            text: "Добавлено в блокнот",
            expire:1000,
            position:"bootom",
            });

            $(this).css({"display":"none"});

        }
        $.cookie("notebook",notebook,{ path:'/'});

   }else{
       if(add == 0){
           $('.notebookList').attr('ads','').attr('ads',id);
           $('.nb_box').css({'display':'block'});
       }
   }

});
*/
// удаление из блокнота
$('.notebookRemove').live('click',function(){

    var reg = $(this).attr('reg');
    var id = $(this).parents('.BoxRealtyObject').attr('item');
    var cat = $(this).parents('.BoxRealtyObject').attr('cat');

    if(reg == 0){

         if($.cookie("notebook")){
           var notebook = $.cookie("notebook");
         }
    
         var pos = notebook.indexOf(id);

         if(pos > -1) {
      
              dhtmlx.confirm({
              type:"confirm-warning",
              text: "<p>Удалить запись из блокнота?</p>",
              ok:'Да',
              cancel:'Нет',
         
              callback: function(result){

              if(result == true){

                 var idZ = id+',';
                 notebook = notebook.replace(idZ,'');
                 $.cookie("notebook",notebook,{ path:'/'});
                 $('.BoxRealtyObject[item='+id+']').slideUp(400);

              }
             }
           })
          }
    }else{
        dhtmlx.confirm({
            type:"confirm-warning",
            text: "<p>Удалить запись из блокнота?</p>",
            ok:'Да',
            cancel:'Нет',

            callback: function(result){

                if(result == true){
                    $.ajax({
                        type:'POST',
                        dataType: "html",
                        url: "/ajax/notebook/removeElement.php",
                        data:{id:id,cat:cat}, // поисковая фраза},

                        success: function(data){
                             if(data == 1){
                                $('.BoxRealtyObject[item='+id+']').slideUp(400);
                             }
                        }
                    });
                }
            }
        })
    }
   
});
// удалить все из блокнота
$('.ranBottom').live('click',function(){
 
         dhtmlx.confirm({
         type:"confirm-warning",
         text: "<p>Очистить блокнот?</p>",
         ok:'Да',
         cancel:'Нет',
         
         callback: function(result){

           if(result == true){
               $.cookie("notebook",'',{ path:'/'});
               document.location.reload(true);
           }
          }
         })
})
// формуруем excel файл
$('.EmailButtonExel').live('click',function(){
   $(this).css({"display":"none"});
   $('.formMailExel').css({"display":"block"});
})
$('.buttonExcel').live('click',function(){
        
    var email = $('.inputEmail input').val();

    var act = $(this).attr('act');
    var cat = $(this).attr('cat');
    var user = $(this).attr('user');

    var seller = $('input[name=rieltor]:checked').val();

    if(!email){
      dhtmlx.alert("Вы не ввели Email");
      return;
    }

    var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
    
    if(!pattern.test(email)){
       dhtmlx.alert("Email введен не корректно");
       return;         
    }


    if(act == 1){
        var arr = 0;

    }else{
        var list = $.cookie("notebook");
        var user = 0;
        var cat = 0;
    }


    //if(list){

         dhtmlx.confirm({
         type:"confirm-warning",
         text: "<p>Сформировать Excel файл ?</p>",
         ok:'Да',
         cancel:'Нет',
         
         callback: function(result){

         if(result == true){

                $.ajax({
                    type:'GET',
                    dataType: "html",
                    url: "/phpExcel/read.php",
                    data:{arr:list,email:email,act:act,user:user,cat:cat,seller:seller}, // поисковая фраза},
                    
                    success: function(data){
                        dhtmlx.alert("<p>Файл был отправлен вам на почту</p>");
                        $('.formMailExel').css({"display":"none"});
                        $('.EmailButtonExel').css({"display":"block"});
                             
                      }
                  })
                }
              }
           })
          //}

})

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// поиск по карте
// Как только будет загружен API и готов DOM, выполняем инициализацию

/////////////////////////////////////////////////////// поиск по карте /////////////////////////////////////////////////////////
// панель юзера (управление)
// если панель показана
$('.stikPanelUser').live('click',function(){
    $('.boxPanelUser').css({'display':'none'});
    $('.showPanelUser').css({'display':'block'});
    $.cookie('showPanelUser',1,{ path:'/'});
});
// если нет
$('.showPanelUser').live('click',function(){
    $('.boxPanelUser').css({'display':'block'});
    $('.showPanelUser').css({'display':'none'});
    $.cookie('showPanelUser',0,{ path:'/'});
});
// проверяем показывать панель или нет
$(document).ready(function(){
  var show = $.cookie('showPanelUser');
    if(show == 1){
       $('.boxPanelUser').css({'display':'none'});
       $('.showPanelUser').css({'display':'block'});
    }else if(show == 0){
       $('.boxPanelUser').css({'display':'block'});
       $('.showPanelUser').css({'display':'none'});
    }
})
// таймер обратного отсчета
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($('[name=idsesesion]').val() == 1){
var t = setInterval (function ()
   {
   function f (x) {return (x / 100).toFixed (2).substr (2)}
   var o = document.getElementById ('timer'), w = 60, y = o.innerHTML.split (':'),
   v = y [0] * w + (y [1] - 1), s = v % w, m = (v - s) / w; if (s < 0)
   var v = o.getAttribute ('long').split (':'), m = v [0], s = v [1];
   
   console.log(s);

   if(m == 0 && s == 0){
      $('input[name=code]').attr('disabled','disabled');
      $('.timer').text('Время вышло, для успешной авторизации вам необходимо получить новый код');
   }else{
      o.innerHTML = [f (m), f (s)].join (':');
   }

   }, 1000);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// критерии поиска  (если выбранны город, район, микрорайон)
$('.maps_select').live('click',function(){
    
    var city =     $("#city option:selected").val();
    var district = $("#district option:selected").val();

    var check = $('.check').is(':checked');

    if(city != 0 || district != 0 || check != 0){
       $('#myModal_maps').css('display','none');
       $('.reveal-modal-bg').css('display','none');
       //dhtmlx.alert("Нельзя пользоваться картой если вы уже выбрали город, район или микрорайон");

       dhtmlx.confirm({
       type:"confirm-warning",
       text: "<p>Что бы воспользоваться картой нужно очистить форму</p>",
       ok:'Да, очистить',
       cancel:'Нет',
       
       callback: function(result){
            // если да
    
            if(result == true){
                $("#district [value='0']").attr("selected", "selected");
                $("#city [value='0']").attr("selected", "selected");
                
                // это все для чекбоксов
                $(".check").removeAttr("checked");
                $(".itemMCBox").css({"background":"none"});
                $(".countElementMdistr").css({"opacity":"0"});
                $('.bottomMicrDis a').text('Выбрать микрорайон').css({"color":"#a9a9a9"});
                // запускаем карту
                $('#myModal_maps').css('display','block');
                $('.reveal-modal-bg').css('display','block');
                $('#myModal_maps').css('top','-100px');
            }         
          } 
      })

    }else{
       $('#myModal_maps').css('display','block');
       $('#myModal_maps').css('top','-100px');
       //$('.reveal-modal-bg').css('display','block');
    }
});
// критерии поиска (если уже выбранна карта) для селектов
$('#district, #city').live('change',function(){
  var poligon = $.cookie('poligon');
  if(poligon){
     //dhtmlx.alert("Зона поиска уже заданна, что бы воспользоваться фильтром очистите карту"); 
     
     dhtmlx.confirm({
     type:"confirm-warning",
     text: "<p>Зона поиска уже заданна, что бы воспользоваться фильтром очистите карту</p>.",
     ok:'Нет, не нужно',
     cancel:'Да очистить',
     
     callback: function(result){
          // если да
  
          if(result == true){
              $("#district [value='0']").attr("selected", "selected");
              $("#city [value='0']").attr("selected", "selected");
          }else{
              $('#removePoligon').click();
          }          
        } 
    })
  }
});
// критерии поиска (если уже выбранна карта) для checkbox
$('.bottomMicrDis').live('click',function(){
    var poligon = $.cookie('poligon');
    if(poligon){

      $('.reveal-modal').css('display','none');
      $('.reveal-modal-bg').css('display','none');

      dhtmlx.confirm({
       type:"confirm-warning",
       text: "<p>Зона поиска уже заданна, что бы воспользоваться фильтром очистите карту</p>",
       ok:'Нет, не нужно',
       cancel:'Да очистить',
       
       callback: function(result){
            // если да
    
            if(result == true){
                $("#district [value='0']").attr("selected", "selected");
                $("#city [value='0']").attr("selected", "selected");
            }else{
                $('#removePoligon').click();
                // показать форму выбора района
                $('.reveal-modal-bg').css('display','block');
                $('.reveal-modal').css('display','block');
                $('.reveal-modal').css('top','-100px');

            }          
          } 
      })

       //dhtmlx.alert("Зона поиска уже заданна, что бы воспользоваться фильтром очистите карту"); 
    }else{
       
    }
});
// поиск фиксируем

$(document).ready(function(){
  $(window).scroll(function(){
     if($(this).scrollTop() > 230){
        $('.searchBox').css({"position":"fixed","z-index":"9","top":"0px"});
        $('.noneSearch').css({"display":"none"});
     }else{
        $('.searchBox').css({"position":"relative","z-index":"9","top":"0px"});
        if($.cookie('showSearch') == 1){
           $('.noneSearch').css({"display":"block"});
        }else{
           $('.noneSearch').css({"display":"none"});
        }
     }
  })
})

// почему нет телефона
$('#phoneButton a').live('click',function(){
    //dhtmlx.alert("<p>Что бы увидеть номер, </p> <p>необходимо <a href = '/index.php?r=User/default/registration'>зарегистрироваться</a></p><p>либо <a href = '/index.php?r=site/login'>войти</a> на сайт</p>");
    dhtmlx.confirm({
        type:"confirm-warning",
        text: "<p>Что бы увидеть номер, </p> <p>необходимо <a href = '/index.php?r=User/default/registration'>зарегистрироваться</a></p><p>либо <a href = '/index.php?r=site/login'>войти</a> на сайт</p>",
        ok:'Регистрация',
        cancel:'Отмена',

        callback: function(result){
            // если да

            if(result == true){
               document.location.href = '/index.php?r=User/default/registration';
            }
        }
    });
});

// итория оплаты табы
$('.tab').live('click',function(){
    var idTab = $(this).attr('id');

        $('.tab').removeClass('selTab')
        $(this).addClass('selTab');

        $('.tabConteiner').css({"display":"none"});
        $('.tabConteiner[id='+idTab+']').css({"display":"block"});

});

// смотрим какой select выбран
$('#catAdsChange_1').live('change', function(){

    var sel  = $(this).find('option:selected').val();
    $('#ajax-load-cat').show();
    transaction(sel);
    var DviCac2 = $("#catAdsChange_2");
    var rlIdCat = $('#realtyObject_idCat');
    // обнуляем при новом выборе
    rlIdCat.attr('value','');

    $.ajax({
        type:'POST',
        dataType: "html",
        url: "/index.php?r=realtyObject/SelCatChange",
        data:{select:sel},

        success: function(data){
            if(data){

                DviCac2.css({'display':'block'});
                DviCac2.empty();
                DviCac2.append( $('<option value=""> Выберите подкатегорию </option>')).focus().css({"color":"red"});

                JSON.parse(data, function(k, v) {
                    if(k){DviCac2.append( $('<option value="'+k+'">'+v+'</option>'));}
                });
                // берем значение подкатегории
                DviCac2.live('change click', function(){
                    DviCac2.css({'color':'#000'});
                    DviCac2.find(":first").text('-----------');
                    var sel2  = $(this).find('option:selected').val();
                    if(sel2){rlIdCat.attr('value',sel2);}
                })

            }else{
                DviCac2.css({'display':'none'});
                rlIdCat.attr('value',sel);
            }
            $('#ajax-load-cat').hide();

        }

    });
    add_fields(sel);



});

$(document).live('ready', function(){
    var idCat   = $('#realtyObject_idCat').val();
    var DviCac2 = $("#catAdsChange_2");



    if(idCat){
        $.ajax({
           type:'POST',
           dataType: "html",
           url: "/index.php?r=realtyObject/SelCatChange",
           data:{idCat:idCat},

           success: function(data){
               count = [];
               JSON.parse(data, function(k, v) {
                   if(k) count.push(v);
               });
               // собираем первый селект
               $("#catAdsChange_1 [value='"+count[0]+"']").attr("selected", "selected");
               //add_fields(count[0]);
               // если есть подкатегория собираем второй
               //alert(count.length)
               if(count.length > 1){
                   $.ajax({
                       type:'POST',
                       dataType: "html",
                       url: "/index.php?r=realtyObject/SelCatChange",
                       data:{select:count[0]},

                       success: function(res){
                           DviCac2.css({'display':'block'});
                           DviCac2.empty();

                           JSON.parse(res, function(k, v) {
                               if(k){DviCac2.append( $('<option value="'+k+'">'+v+'</option>'));}
                           });

                           $("#catAdsChange_2 [value='"+count[1]+"']").attr("selected", "selected");

                       }})
               }
               add_fields(count[0]);

           }
        });
    }


});

// показать район и микрорайон
$('#realtyObject_city').live('change',function(){
   var sel  = $(this).find('option:selected').val();
   if(sel == 2){
      $('#microdistrict').css({'display':'block'});
   }else{
      $('#microdistrict').css({'display':'none'});
   }
});

function add_fields(sel){

    $('.showCat').css({"display":"none"});

    var add_fields_appartmens = [1,2,3];
    var key_app = jQuery.inArray(parseInt(sel), add_fields_appartmens);
    if(key_app != -1){
        var mass = ['floor','floors','typeHouse','countRooms'];
    }

    var add_fields_house = [4];
    var key_house = jQuery.inArray(parseInt(sel), add_fields_house);
    if(key_house != -1){
        var mass = ['floors','typeHouse','countRooms']
    }

    if(mass.length > 0){
        // собираем условие, выводим результат
        for(var i = 0; i < mass.length; i++){
            $('#realtyObject_'+mass[i]+'').parent().css({"display":"block"});
        }
    }

}

function transaction(id){
        // блокируем ненужные типы сделок
        if(id == 1 || id == 2){
            // квартиры комнаты
            $("#realtyObject_transaction option[value='1']").prop( "disabled", true );
            $("#realtyObject_transaction option[value='4']").prop( "disabled", true );

            $("#realtyObject_transaction option[value='2']").prop( "disabled", false );
            $("#realtyObject_transaction option[value='3']").prop( "disabled", false );
        }else if(id == 3){
            //
            $("#realtyObject_transaction option[value='1']").prop( "disabled", false );
            $("#realtyObject_transaction option[value='4']").prop( "disabled", false );

            $("#realtyObject_transaction option[value='2']").prop( "disabled", true );
            $("#realtyObject_transaction option[value='3']").prop( "disabled", true );
        }else{
            $("#realtyObject_transaction option[value='1']").prop( "disabled", false );
            $("#realtyObject_transaction option[value='4']").prop( "disabled", false );

            $("#realtyObject_transaction option[value='2']").prop( "disabled", false );
            $("#realtyObject_transaction option[value='3']").prop( "disabled", false );
        }

}

$(document).ready(function(){
    // смотрим можно еще загружать фото или нет ( при редактировании объявления)
    if($('.boxUploadFiles li').length > 3){
        $('.boxButtonFiles').css({"display":'none'});
    }

    $('.del_img_ads').live('click',function(){
        var str = $(this).parent().parent().attr('id');
        var delCache = $(this).attr('id');

        var res = str.split("/");
        //console.log(str);

        $.ajax({
            type:'GET',
            dataType: "html",
            url: "/scripts/ajaxupload/php/uploadRealtyObject_delete.php",
            data:{userId:res[0],idTmp:res[1],name:res[2],delCache:delCache}, // поисковая фраза},

            success: function(data){
                if(data == 1){
                    $('li[id="'+str+'"]').remove();
                    if($('.boxUploadFiles li').length < 4){
                       $('.boxButtonFiles').css({"display":'table-cell'});
                    }
                }
            }
        })

    });
});

// показываем нужные поля в фильтре
$('#realtyCat').live('change', function(){
   var sel = $(this).find(':selected').val();
   var land = [5,15,16,17];
   var fieldBlock = ['houseTypes','floor_start','floor_end','street','title','phone'];

       var key_land = jQuery.inArray(parseInt(sel), land);

       if(key_land != -1){
           for(var t = 0; t < fieldBlock.length; t++){
              $('[name='+fieldBlock[t]+']').prop('disabled', true).css({"opacity":"0.5"});
           }

           $('input#group_cr').prop('disabled', true).css({"opacity":"0.5"});
           $('.blockS_3').css({"display":"none"});
           $('.bottomMicrDis a').attr('data-reveal-id','');
           $('.bottomMicrDis').css({"opacity":"0.5"});
       }else{
           for(var t = 0; t < fieldBlock.length; t++){
               $('[name='+fieldBlock[t]+']').prop('disabled', false).css({"opacity":"1"});
           }
           $('input#group_cr').prop('disabled', false).css({"opacity":"1"});
           $('.blockS_3').css({"display":"inline-block"});
           $('.bottomMicrDis a').attr('data-reveal-id','myModal');
           $('.bottomMicrDis').css({"opacity":"0.5"}).css({"opacity":"1"});

       }

});

// удаляем объявление
$('#remove_edit').live('click', function(){
    var id = $(this).attr('idAds');

    dhtmlx.confirm({
        type:"confirm-warning",
        text: "<p>Удалить объявление?</p>",
        ok:'Да',
        cancel:'Нет',

        callback: function(result){

            if(result == true){
                $.ajax({
                    type:'GET',
                    dataType: "html",
                    url: "/index.php?r=realtyObject/deleteAds",
                    data:{idAds:id}, // поисковая фраза},

                    success: function(data){
                             location.reload();
                    }
                })
            }
        }
    });

});
// удаляем элементы из открытых нам дргими пользвателями блокнотов
$('#rgn').live('click', function(){
   var user = $(this).attr('user');
   var id   = $(this).attr('cat');

    dhtmlx.confirm({
        type:"confirm-warning",
        text: "<p>Удалить из списка?</p>",
        ok:'Да',
        cancel:'Нет',

        callback: function(result){

            if(result == true){
                $.ajax({
                    type:'GET',
                    dataType: "html",
                    url: "/index.php?r=realtyObject/delGuestNote",
                    data:{user:user, id:id}, // поисковая фраза},

                    success: function(data){
                        location.reload();
                    }
                })
            }
        }
    });


});

// выделение элементов
$('.button_oan').live('click', function(){

    var redirect = $(this).attr('redirect');

    if(redirect == 1){
        dhtmlx.confirm({
            type:"confirm-warning",
            text: "<p>Для выполнения данного действия необходимо перейти в корневую папку.</p>",
            ok:'Перейти',
            cancel:'Отмена',

            callback: function(result){
                if(result == true){
                   window.location.href = '/index.php?r=realtyObject/notebook';
                }
            }})

    }else{

    dhtmlx.confirm({
        type:"confirm-warning",
        text: "<p>Выберите блокноты к которым вы хотите открыть доступ</p>",
        ok:'ОК',
        cancel:'Назад',

        callback: function(result){

            if(result == true){
               $('.learn_access, .boxNewHeader').css({'opacity':'0.2'});
               $('.newButtonCatBook, .EmailButtonExel, .button_oan').css({'opacity':'0.2'});
               $('.button_oan_close').css({'display':'inline-block'});
               $('.cheked_item_note, .send_access_box').show();


               // на всякий ставим фон по умолчанию
               $('.cheked_item_note').css({'background':'#fffc1d'});

               $.cookie("cheked_note",null,{ path:'/'});

            }
        }
    });
    }

});
// отмена
$('.button_oan_close').live('click', function(){
    $('.learn_access, .boxNewHeader').css({'opacity':'1'});
    $('.newButtonCatBook, .EmailButtonExel, .button_oan').css({'opacity':'1'});
    $('.button_oan_close').css({'display':'none'});
    $('.cheked_item_note, .send_access_box').hide();
    $('.cheked_item_note').css({'background':'#fffc1d'});
});
// выбираем элементы
$('.cheked_item_note').live('click', function(){


    if($.cookie("cheked_note")){
        var look = $.cookie("cheked_note");
    }else{
        var look = '';
    }

    var id = $(this).parents('.ul_bcnb').attr('id');

    var pos = look.indexOf(id);

    if(pos > -1) {
        look = look.replace(id+',', "");
        $(this).parents('.ul_bcnb[id = '+id+']').find('.cheked_item_note').css({'background':'#fffc1d','opacity':'0,4'});
    }else{
        look = look + id+',';
        $(this).parents('.ul_bcnb[id = '+id+']').find('.cheked_item_note').css({'background':'red','opacity':'0,4'});
    }

    $.cookie("cheked_note",look,{ path:'/'});
});
// последний шаг открыаем доступ
$('.button_access').live('click', function(){
    var login = $('#scan_phone').text();

    if(!login){
        dhtmlx.alert("<p>Вы не ввели номер телефона</p>");
    }

    if(!$.cookie("cheked_note")){
        dhtmlx.alert("<p>Вы не выбрали ни одного элемента</p>");
    }

    if(login && $.cookie("cheked_note")){
        $.ajax({
            type:'GET',
            dataType: "html",
            url: "/index.php?r=realtyObject/AccessOpenNote",
            data:{phone:login}, // поисковая фраза},

            success: function(data){
                    if(data == 0){
                       dhtmlx.alert("<p>Пользователя с таким логином не существует.</p>");
                    }else if(data == 1){
                       location.reload();
                    }else if(data == 2){
                       dhtmlx.alert("<p>Ошибка, это ваш номер, нельзя открыть доступ самому себе.</p>");
                    }

            }

        })
    }


});

$('.buttomBuyCodes, #linkBuyText').live('click', function(){

    var display = $('.buyCodesInterface').css("display");

    if(display == 'none'){
        $('.buyCodesInterface').slideDown(300);
        $('.buttomBuyCodes').text('Нет, не нужно');
    }else{
        $('.buyCodesInterface').slideUp(300);
        $('.buttomBuyCodes').text('Купить коды платного доступа');
    }
});
// отмеить объект как проданный
$('.addSold').live('click',function(){
    var id = $(this).attr('id');

    dhtmlx.confirm({
        type:"confirm-warning",
        text: "<p>Вы уверены что объект продан?</p>",
        ok:'Да',
        cancel:'Нет',

        callback: function(result){

            if(result == true){
                $.ajax({
                    type:'GET',
                    dataType: "html",
                    url: "/index.php?r=realtyObject/Sold",
                    data:{id:id}, // поисковая фраза},

                    success: function(data){
                       //$('.addSold').css({'display':'none'});
                       location.reload();
                    }
                })
            }
        }
    });
});
$('.delAdsAdmin').live('click',function(){
    var id = $(this).attr('id');
    dhtmlx.confirm({
        type:"confirm-warning",
        text: "<p>Удалить объявление</p>",
        ok:'Да',
        cancel:'Нет',

        callback: function(result){

            if(result == true){
                $.ajax({
                    type:'GET',
                    dataType: "html",
                    url: "/index.php?r=realtyObject/DelAdsAdmin",
                    data:{id:id}, // поисковая фраза},

                    success: function(data){
                        document.location.href = 'http://rlpnz.ru/index.php?r=realtyObject/';
                    }
                })
            }
        }
    });
});
// добавить комментарий
$('.ctb').live('click', function(){
    var id = $(this).attr('id');
    var text = $('[name=text]').val();

    $.ajax({
        type:'GET',
        dataType: "html",
        url: "/index.php?r=realtyObject/AddComments",
        data:{id:id,text:text}, // поисковая фраза},

        success: function(data){
            location.reload();
        }
    })

});
// удалить комментарий
$('.delComNote').live('click',function(){
    var id = $(this).attr('id');

    dhtmlx.confirm({
        type:"confirm-warning",
        text: "<p>Удалить комментарий</p>",
        ok:'Да',
        cancel:'Нет',

        callback: function(result){

            if(result == true){
                $.ajax({
                    type:'GET',
                    dataType: "html",
                    url: "/index.php?r=realtyObject/DelComments",
                    data:{id:id}, // поисковая фраза},

                    success: function(data){
                        location.reload();
                    }
                })
            }
        }
    });
});
// отпракаа почты

$('#getMail').submit(function(){

      var name = $('[name=name]').val();
      var email = $('[name=email]').val();
      var phone = $('[name=phone]').val();
      var description = $('#textDescr').val();

      if(description){
         if(description.length > 250){
            dhtmlx.alert("<p>Вопрос не может быть длинее 250 символов</p>");
         }else{
             $.ajax({
                 type:'post',
                 dataType: "html",
                 url: "/index.php?r=realtyObject/GetMail",
                 data:{name:name,email:email,phone:phone,description:description}, // поисковая фраза},

                 success: function(data){
                     dhtmlx.alert("<p>Ваше сообщение успешно отправленно</p>");
                 }
             })
         }
      }else{
         dhtmlx.alert("<p>Вы не задали вопрос</p>");
      }


      return false;


});
// отправить ссылку другу
$('#sendfriend').submit(function(){
    var email = $('[name=friend_email]').val();
    var mainMail = $('[name=main_email]').val();

    if(email || mainMail){
       var link = window.location.href;
        $.ajax({
            type:'post',
            dataType: "html",
            url: "/index.php?r=realtyObject/SendLink",
            data:{link:link,email:email,mainMail:mainMail}, // поисковая фраза},

            success: function(data){
                $('.classWindow').click();
                dhtmlx.alert("<p>Ваше сообщение успешно отправленно</p>");
            }
        })
    }else{
       dhtmlx.alert("<p>Вы не введи email</p>");
    }
   return false;
});
// скрываем меню микрорайоны
$('.hideMicrodistricts').live('click', function(){
    var display = $('.boxSortMiscrodist').css('display');
    if(display == 'none'){
        $('.boxSortMiscrodist').slideDown(200);
        $(this).text('Скрыть микрорайоны');
        $.cookie("showMicrodistricts", 1, { path:'/'});
    }else{
        $('.boxSortMiscrodist').slideUp(200);
        $(this).text('Показать микрорайоны');
        $.cookie("showMicrodistricts", 0, { path:'/'});
    }
});


$(document).ready(function(){
    var display = $('.boxSortMiscrodist').css('display');
    if(display == 'block'){
        $('.hideMicrodistricts').text('Скрыть микрорайоны');
    }else{
        $('.hideMicrodistricts').text('Показать микрорайоны');
    }
});
$(document).ready(function(){
    var disp = $.cookie("showMicrodistricts");
    if(disp == 1){
       $('.boxSortMiscrodist').css({'display':'block'});
       $('.hideMicrodistricts').text('Скрыть микрорайоны');
    }else if(disp == 0){
       $('.boxSortMiscrodist').css({'display':'none'});
       $('.hideMicrodistricts').text('Показать микрорайоны');
    }
});


//$(document).ready(function(){
/*
function viewBlocMaps(){
    $('.gSobBox').animate({top:'140px',left:'-30px',opacity:'0.9'},1000);
    $('.gRieltorBox').animate({top:'55px',left:'510px',opacity:'0.9'},1000);
}

setTimeout(viewBlocMaps,1000);

 $(document).ready(function(){
 // получаем get переменные
 //var GETArr = parseGetParams();
 var showInsidePage = $('.showSearscBlock').attr('data');
 //console.log(GETArr['id']);
 //if(GETArr['id']){
 if(showInsidePage != 1){
 if($.cookie("showSearch") == 1){
 $('.boxSortMiscrodist').css({"display":"block"});
 $('#clickSearch').text('Скрыть');
 }else{
 $('.noneSearch').css({"display":"none"});
 }
 }else{
 $('.noneSearch').css({"display":"none"});
 $('#clickSearch').text('Расширенный поиск');
 }
 //}else{
 //      $('.noneSearch').css({"display":"block"});
 //      $('#clickSearch').text('Скрыть');
 // }

 });
*/


//});















