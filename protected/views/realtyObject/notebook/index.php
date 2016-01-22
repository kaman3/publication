<?php
/* @var $this RealtyObjectController */
/* @var $dataProvider CActiveDataProvider */
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/scripts/maskInput/mask.js"></script>

<? //$dataSearch = Yii::app()->app->dataSearch(); ?>
<? $this->pageTitle = 'Блокнот'; ?>
<?php //$this->widget('application.components.search'); ?>
  <div class = 'line_bar_top'></div>
  <?if($data == 1) : ?>
    <div class = 'message'>
         В ваш блокнот пока не добавленно не одного объекта.
    </div>
  <? endif; ?>

  <? //if($_COOKIE["notebook"]) : ?>
     <div class = 'optionNotebook'>
       <? if(!Yii::app()->user->isGuest) : ?>
          <div class = 'newCatBook' form = '2'>
               <div class = 'newButtonCatBook'>Новый блокнот</div>

                    <div class = 'boxNewCat' style = 'display: none;'>
                         <div class = 'inputBoxNewCat'>
                             <input type = 'text' name = 'newCat' placeholder = 'Введите название новой категории' autofocus>
                         </div>
                         <div class = 'buttonBoxNewCat'>
                              <div class = 'createNewCatB' user = '<?=Yii::app()->user->id;?>'>Создать</div>
                              <div class = 'closeNewCatB'>Отмена</div>
                         </div>
                    </div>

                    <div class = 'BoxloadExcel'>
                       <?($_GET['cat']) ? $display = 'display:block' : $display = 'display:none'; ?>
                       <div class = 'EmailButtonExel' style = '<?=$display;?>'>Сформировать exсel</div>
                        <? ($_GET['cat']) ? $cat = $_GET['cat'] : $cat = 0; ?>
                        <div class = 'formMailExel' style = 'display:none;'>
                        <div class = 'inputEmail'><input type = 'text' name = 'email' placeholder = 'Ваш Email'></div>
                        <div class = 'inputSeller'>
                             <input type = 'radio' id="r1" name = 'rieltor' value = '1' CHECKED ><label for="r1">Для агента</label>
                             <input type = 'radio' id="r2" name = 'rieltor' value = '2'><label for="r2">Для покупателя</label>
                        </div>
                        <div class = 'buttonExcel' act = '1' cat = '<?=$cat;?>' user = '<?=Yii::app()->user->id;?>'>Получить</div>
                       </div>
                    </div>

                   <div class = 'open_access_note'>
                       <?($_GET['cat']) ? $redirect = 1 : $redirect = 0; ?>
                       <div class = 'button_oan' redirect = '<?=$redirect;?>'>Предоставить доступ</div>
                   </div>
                   <div class = 'open_access_note'>
                       <div class = 'button_oan_close'>Отмена</div>
                   </div>
          </div>

          <div class = 'send_access_box'>
              <div class = 'message mp'>
                  Вам необходимо выбрать нужные вам элементы, затем в поле ввода ввести логин (номер сотового телефона) того кому вы хотите открыть доступ.
              </div>
               <div class = 'header_sab'>Разрешить доступ:</div>
               <div class = 'input_sab'><input type = 'text' id = 'User_phone' value = ''></div>
               <div class = 'button_sab'>
                   <div class = 'button_access'>Разрешить</div>
                   <div id = 'scan_phone' style = 'display: none;'></div>
               </div>
          </div>

       <? endif; ?>
       <? if(Yii::app()->user->isGuest) : ?>
       <div class = 'removeAllNotebook'>
          <div class = 'ranBottom'>Удалить все</div>
       </div>

       <div class = 'BoxloadExcel'>
            <div class = 'EmailButtonExel'>Сформировать exсel</div>

            <div class = 'formMailExel' style = 'display:none;'>
                 <div class = 'inputEmail'><input type = 'text' name = 'email' placeholder = 'Ваш Email'></div>
                 <div class = 'buttonExcel' act = '0'>Получить</div>
            </div>
       </div>

       <? endif; ?>

     </div>

  <? if(!Yii::app()->user->isGuest) : ?>
     <?php $this->widget('application.components.notebook_cat'); ?>
     <?php
          if(!$_GET['cat']) {
              $this->widget('application.components.n_access_cat');
          }
     ?>
     <div class = 'breadcrumbsRealty'>
          <ul>
              <? if(isset($_GET['cat'])) :?>
                  <li><a href = '/'>Главная</a></li>
                  <? echo Yii::app()->app->breadNoteBook(trim($_GET['cat'])); ?>
              <? endif;?>
          </ul>
     </div>
  <? endif; ?>

<div class = 'boxRealty'>
    <?php $this->renderPartial('application.views.realtyObject.notebook._view',array(
        'data'=>$dataProvider,
    ));?>
</div>
<? if($dataProvider) : ?>
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
<? endif; ?>
<script type="text/javascript">
    jQuery(function($){
        $("#User_phone").mask("+7 (999) 999-9999",{completed:function()
        {
            $('#scan_phone').text(this.val());
        }
        });
    });
</script>

