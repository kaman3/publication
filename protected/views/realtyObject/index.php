<!-- сообщение о окончании тестового периода -->


<?php  //if(Yii::app()->app->testPeriod() == 0 and !Yii::app()->user->isGuest) :?>

      <?php //$this->widget('application.components.search'); ?>
      <!-- База не оплачена -->
     <!-- <div class = 'message mp'>
        В данный момент доступ к базе объектов ограничен! Пожалуйста <a href = '/index.php?r=realtyObject/OfficePayment'>пополните счет</a>.
      </div>-->
     <!-- База не оплачена -->

<? //else: ?>
      <? if(!Yii::app()->user->isGuest) : ?>
        <?
        $check_n_b = Yii::app()->app->checkElemNotebook();
        $a = array();
        for($i = 0; $i < count($check_n_b); $i++){
            $a['idAds'][] = $check_n_b[$i]['idAds'];
        }
        ?>
      <? endif; ?>

      <?php $this->widget('application.components.search'); ?>

      <div class = 'breadcrumbsRealty'>
	       <ul>
	          <? if(isset($_GET['cat'])) :?>
		         <li><a href = '/'>Главная</a></li>
	          <? echo Yii::app()->app->breadcrumbs(trim($_GET['cat'])); ?>
              <? endif;?>
           </ul>
      </div>

          <!--<div class="menu">-->
             <?php $this->widget('application.components.TypesMenu'); ?>
          <!-- </div> menu -->


      <div class = 'sellerBox'>
           <div class = 'seller'>
                <?php echo Yii::app()->app->dealerSort(); ?>
           </div>

           <div class = 'countSearchElements'>
               <? if($_GET['cat'] != '') : ?>
               Найдено объектов: <span><?=number_format($count,0,'',' ');?></span>
               <? endif; ?>
           </div>

          <div class = 'orderBy'>
              <select name = 'order' id = 'order'>
                  <option value = '1'>По дате</option>
                  <option value = '2'>Дешевле</option>
                  <option value = '3'>Дороже</option>
              </select>
          </div>
      </div>
<div class = 'rssBox'>
    <div class = 'rss_c'><a href = '/rss.xml'><img src = '/images/rss.png' width="50px"></a></div>
    <?
       // категория
       if($_GET['cat']){
           if($_GET['cat'] == 1 and $_GET['transaction']){
               $cat = "квартиру";
           }else if($_GET['cat'] == 2 and $_GET['transaction']){
               $cat = "комнату на общей кухне";
           }elseif($_GET['cat'] == 7 and $_GET['transaction']){
               $cat = "квартиру вторичное жилье";
           }elseif($_GET['cat'] == 7 and !$_GET['transaction'] and $_GET['CountRooms'][0]){
               $cat = "квартиру, вторичное жильё";
           }elseif($_GET['cat'] == 8 and !$_GET['transaction'] and $_GET['CountRooms'][0]){
               $cat = "квартиру в новостройке";
           }elseif($_GET['cat'] == 8 and $_GET['transaction']){
               $cat = "квартиру в новостройке";
           }else if($_GET['cat'] == 9){
               if($_GET['transaction']){
                  $cat = "квартиру на длительный срок без посредников";
               }else{
                  $cat = "аренда квартир на длительный срок без посредников";
               }
           }else if($_GET['cat'] == 10){
               $cat = "квартиру на сутки";
           }else if($_GET['cat'] == 11){
               $cat = "дом";
           }else if($_GET['cat'] == 12){
               if($_GET['transaction']){
                  $cat = "дачу";
               }else{
                  $cat = "дачи";
               }
           }else if($_GET['cat'] == 13 and $_GET['transaction']){
               $cat = "коттедж";
           }else if($_GET['cat'] == 14 and $_GET['transaction']){
               $cat = "таунхаус";
           }else if($_GET['cat'] == 23 and $_GET['transaction']){
               $cat = "гараж";
           }else{
               $cat = mb_strtolower(Yii::app()->app->getH1($_GET['cat']),'utf-8');
           }
       }else{
           $cat = "Недвижимость";
       }
       // тип сделки
       if($_GET['transaction']){
           if($_GET['transaction'] == 1 and $_GET['cat'] == 7 and $_GET['cat'] == 8 and $_GET['cat'] == 9 and $_GET['cat'] == 10){
               $transaction = 'сниму';
           }else if($_GET['transaction'] == 2){
               $transaction = 'купить';
           }else if($_GET['transaction'] == 3){
               $transaction = 'продам';
           }else if($_GET['transaction'] == 4){
               $transaction = 'сдам';
           }
           //$transaction = Yii::app()->app->getTransaction($_GET['transaction']);
       }
       // город
       if($_GET['city']){

           $city = 'в '.Yii::app()->app->getCity($_GET['city']);
       }else{
           $city = 'в Пензе';
       }
       // район
       if($_GET['districts']){
          $district = '- '.Yii::app()->app->getDistricts($_GET['districts']).' район';
       }
       if(count($_GET['microdistricts']) == 1){
          $microdistricts = '- '.Yii::app()->app->getMicrodistrict($_GET['microdistricts'][0]);
       }
       // количество комнат
       if(count($_GET['CountRooms']) == 1 and $_GET['cat'] != 13){
           if($_GET['CountRooms'][0] == 1){
               $countRooms = 'однокомнатную';
           }elseif($_GET['CountRooms'][0] == 2){
               $countRooms = 'двухкомнатную';
           }elseif($_GET['CountRooms'][0] == 3){
               $countRooms = 'трехкомнатную ';
           }elseif($_GET['CountRooms'][0] == 4){
               $countRooms = 'четырехкомнатную';
           }
       }

       $titleH1 = Yii::app()->app->mb_ucfirst($transaction." ".$countRooms." ".$cat." ".$city." ".$district." ". mb_strtolower($microdistricts,'utf-8')." - ".number_format($count,0,'',' ')." объектов ");
       $this->pageTitle = Yii::app()->app->mb_ucfirst(trim($titleH1));
       $this->title = Yii::app()->app->mb_ucfirst(trim($titleH1));
       $this->description = Yii::app()->app->mb_ucfirst(trim($titleH1).' мы собираем для вас только качественную базу и постоянно следим за ее актуальностью, сайт недвижимости Пензы и области');
       $this->keywords = str_replace(' ',', ',Yii::app()->app->mb_ucfirst(trim($titleH1))).' ,купить квартиру, продать, обменять, снять, коммерческая недвижимость, Пенза, дома, коттеджи, дачи, земельные участки, аренда, по суточно';
       //Yii::app()->clientScript->registerMetaTag($titleH1.' мы собираем для вас только качественную базу и постоянно следим за ее актуальностью, сайт недвижимости Пензы и области', 'description');
       //Yii::app()->clientScript->registerMetaTag('','keywords');
    ?>
    <div class = 'rss_c'><h1><?=$titleH1;?></h1></div>
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
<div class = 'boxRealty'>
        <?php $this->renderPartial('_view',array(
                 'data'=>$dataProvider,
                 'notebook'=>$notebook,
                 'check_n_b'=>$a,
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
<? //endif; ?>
   <div class = 'footer_object'>
      <?php $this->widget('application.components.bottomMenu'); ?>
   </div>
<!--
<div class = 'boxTextDesc'>
    <div class = 'textDescription'>
    <? //if($_GET['page'] == 1 or !$_GET['page']): ?>
        <strong>Недвижимость в Пензе</strong>
        <p>Лучшее электронное отображение недвижимости Пензы— это портал «Недвижимость Пензы». Ведь здесь наиболее полная картина, тут можно найти как жилые, так и коммерческие помещения, а также земельные участки. Здесь можно и продать, и купить, и сдать в аренду, и арендовать. В общем, портал «Недвижимость Пензы» станет надежным помощником всем участникам рынка, что бы им не требовалось. Мы решили создать онлайн-ресурс, который будет идеальным сосредоточением всей информации, которая только может понадобиться при любых операциях с недвижимостью. Таким образом, что бы вам ни понадобилось — квартиры, земельные участки, помещения сферы обслуживания, дачи  — смело заходите на наш портал с уверенностью, что отыщите необходимое помещение.</p>
    <? //endif; ?>
    <? ////if($_GET['page'] == 2): ?>
        <strong>Однокомнатная квартира в Пензе</strong>
        <p>Сектор рынка недвижимости, посвященный продаже однокомнатных квартир в Пензе, традиционно является подвижным. То есть таким, где прослеживается стабильно высокий спрос и постоянно присутствует значительное количество предложений по продаже квартир без посредников. В то же время, большая часть операций по продаже однокомнатных квартир в Пензе осуществляется довольно быстро, что объясняется их сравнительно невысокой стоимостью. Поэтому мы рекомендуем Вам не откладывать осмотр понравившейся квартиры – желающих может быть сразу несколько.</p>
        <p>Наш сайт предоставляет вам возможность продажи однокомнатной квартиры без посредников, что существенно удешевляет ее стоимость для покупателя. Мы постарались, чтобы все объявления максимально подробно описывали продаваемую квартиру. Даже бегло просматривая их, Вы можете убедиться в наличии множества различных предложений о продаже однокомнатных квартир в Пензе. Колеблются как общая площадь квартир на продажу, так и их техническое состояние и месторасположение относительно центра. Надеемся, мы поможем Вам легко решить свой квартирный вопрос!</p>
        <p>Наш сайт всегда предоставляет широкий выбор предложений по покупке однокомнатных квартир в Пензе. Ранее мы уже писали, что это очень востребованный в нашем городе сегмент рынка недвижимости. Люди, желающие купить однокомнатную квартиру в Пензе обычно исходят в своем выборе из потребности приобретения жилья за сравнительно невысокую цену. Покупка однокомнатной квартиры часто знаменует начало новой жизни для своих хозяев. Ведь чаще всего такое жилье приобретают приезжие в наш город из других регионов, а также молодожены, желающие отделиться от родителей. В любом случае, приобретение однокомнатной квартиры часто становится не конечной целью наших посетителей, а только началом, определенной вехой в их жизненной истории. Ведь зачастую человек при этом рассуждает примерно так: сегодня я куплю однокомнатную квартиру, а позже поменяю ее на более просторную. Поэтому мы верим, что большинство наших посетителей, купивших однокомнатную квартиру в Пензе при помощи нашего сайта, со временем вернется к нам снова с желанием обменять квартиру на большую!</p>

    <? //endif; ?>
    <? //if($_GET['page'] == 3): ?>
        <strong>Двухкомнатные квартиры Пенза</strong>
        <p>Приобрести сегодня двухкомнатную квартиру несложно. Выбор жилья достаточно большой. В зависимости от финансовых возможностей, можно купить двухкомнатную квартиру в Пензе на первичном или вторичном рынке.</p>
        <p>И тот и другой варианты имеют свои преимущества и недостатки. Однако дело даже не в этом. В зависимости от площади, инфраструктуры квартиры могут относиться к разному классу. Основными покупателями двухкомнатных квартир являются одинокие люди или семьи с детьми.</p>
        <p>С учетом того, что количество членов семьи может быть разным, стоит обращать внимание на качество инфраструктуры, а также от степени транспортной доступности. Очень важно, что в том районе, где вы планируете жить, была поликлиника, детский сад, школа, особенно, если у вас есть маленькие дети. При этом, следует отметить, что квартиры в центре города, будут стоить дороже, чем те которые находятся в спальных районах. При выборе квартиры, следует обращать внимание на качество ее постройки, виды материалов, которые использованы для ее отделки.</p>
        <p>В том случае, если вы желаете немного сэкономить, и приобрести квартиру в новостройке, то имеет смысл, приобрести ее на стадии строительства. Дело в том, что в таком случае квадратный метр такой квартиры будет стоить дешевле рыночного. Одним из недостатков приобретения квартиры на стадии строительства является то, что придется дожидаться окончания строительства. Современные квартиры, которые относятся к эконом-классу имеют удобную планировку, и достаточно удобные.</p>
    <?// endif; ?>
    </div>
</div>
-->

