<div class = 'boxOffice'>
    <div class="newCollLeft">
        <?php $this->widget('menuOffice'); ?>
    </div>
    <div class="newCollRight">

          <div class = 'message mp'>
               Для публикации объявлений в раздел Аренда недвижимости вам нужно приобрести коды платного доступа, это можно сделать на этой странице.<br>
               Если же вы уже приобрели коды, вам нужно прикрепить полученые коды к своему аккаунту.<br>
               Это можно сделать воспользовавшись интерфейсом расположенном ниже.
          </div>

          <div class = 'buttomBuyCodes'>Купить коды платного доступа</div>

          <div class = 'buyCodesInterface' style = 'display: none;'>
              <div class="row formPublic">
                  <div class = 'accessRent'>

                      <div class = 'ar_box_input'>
                          <b>Получить код платного доступа</b><br><br>
                          Внимание! После покупки ключей доступа, необходимо прикрепить их к своему аккаунту!<br><br>
                      </div>

                      <div class = 'ar_box_input'>
                          <div class = 'arb_text'>Количество кодов</div>
                          <div class = 'arb_input'>
                              <select id = 'rentaccess'>
                                  <option value = '1'>1</option>
                                  <option value = '2'>2</option>
                                  <option value = '3'>3</option>
                                  <option value = '4'>4</option>
                                  <option value = '5'>5</option>
                                  <option value = '6'>6</option>
                                  <option value = '7'>7</option>
                                  <option value = '8'>8</option>
                                  <option value = '9'>9</option>
                                  <option value = '10'>10</option>
                                  <option value = '15'>15</option>
                                  <option value = '20'>20</option>
                              </select>
                          </div>
                      </div>

                      <div class = 'ar_box_input'>
                          <div class = 'arb_text'>Федеральный номер телефона куда прислать sms с кодами</div>
                          <div class = 'arb_input'>
                              <input id = 'phoneRent' value = ''>
                          </div>
                      </div>

                      <div class = 'ar_box_input'>
                          <div class = 'arb_text'>Почта, куда дополнительно продублировать письмо с кодами</div>
                          <div class = 'arb_input'>
                              <input id = 'emailRent' value = ''>
                          </div>
                      </div>

                      <div class = 'ar_box_input'>
                          <input type = 'button' value="Перейти к оплате" onclick="window.open('http://bazarpnz.ru/robokassa.php?type=pay&phone='+document.getElementById('phoneRent').value+'&email='+document.getElementById('emailRent').value+'&lot='+document.getElementById('rentaccess').value)">
                      </div>

                  </div>
              </div>
          </div>

          <div class = 'boxCreateCodes'>
               <div class = 'addCodes'>
                   <div class="form">
                       <?php $form=$this->beginWidget('CActiveForm', array(
                           'id'=>'option',
                           // Please note: When you enable ajax validation, make sure the corresponding
                           // controller action is handling ajax validation correctly.
                           // There is a call to performAjaxValidation() commented in generated controller code.
                           // See class documentation of CActiveForm for details on this.
                           'enableAjaxValidation'=>false,
                           'htmlOptions'=>array('enctype'=>'multipart/form-data'),
                       ));
                       ?>
                       <div class="row formPublic">
                           <?php echo $form->labelEx($model,'code'); ?>
                           <?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>250)); ?>
                           <?php echo $form->error($model,'code'); ?>
                       </div>

                       <div class="row buttons addads">
                           <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить'); ?>
                       </div>
                       <?php $this->endWidget(); ?>
                   </div>
               </div>
               <div class = 'yourCodes'>
                    <? if($count != 0) : ?>
                    <div class = 'headerCodesList'>Активные коды, осталось (<?=$count;?>)</div>
                    <div class = 'boxListCodes'>
                         <div class = 'td_codes_public'><b>Код</b></div>
                         <div class = 'td_codes_date'><b>Добавлен</b></div>
                         <? foreach($list as $key =>$value) : ?>
                            <div class = 'tr_codes_public'>
                                 <div class = 'td_codes_public'><?=$value['code'];?></div>
                                 <div class = 'td_codes_date'><?php echo Yii::app()->app->formatDate($value['createDate']);?></div>
                            </div>
                         <? endforeach; ?>
                    </div>
                   <div class = 'paginator'>
                       <?php $this->widget('CLinkPager', array('pages' => $pages,)) ?>
                   </div>
                   <? else : ?>
                        <div class = 'message mp'>Вы не добавили ни одного ключа. Если у вас нет ключей доступа, вам необходимо их <a href = '#' id = 'linkBuyText'>приобрести</a>.</div>
                   <? endif; ?>
               </div>

          </div>
    </div>
</div>