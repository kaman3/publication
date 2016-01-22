<div class = 'boxOffice'>
     <div class="newCollLeft">
         <?php $this->widget('menuOffice'); ?>
     </div>
     <div class="newCollRight">
         <? if(count($data) > 0): ?>
         <div class = 'c-sellect-all-box'>
             <div class = 'c-sellect-all'>
                  <input type="checkbox" name="cbname3[]" value="0" id="example_maincb">
             </div>
         </div>
         <? endif; ?>
         <div class = 'c-panel-rules'>
              <div class = 'cpr-box'>
                   <a id = 'c-dell-ads' href = '#'>Удалить выбранные</a>
              </div>
              <div class = 'cpr-box'>
                   <span>Опубликовать:</span>
                   <span><a class = 'cdel' id = '1' href = '#'>Да</a></span>
                   <span><a class = 'cdel' href = '#' id = '0'>Нет</a></span>
              </div>
         </div>
         <?php $this->renderPartial('application.views.realtyObject.privateOffice.listMyAds',array('data'=>$data, 'pages'=>$pages));?>
     </div>
</div>

