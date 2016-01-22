<?php

class DefaultController extends Controller
{
    public $description = '';
    public $keywords = '';
    public $title = '';
    

	public function actionIndex()
	{
		$this->render('index');
	}
	
	/*
    * Регистрация
    *
    * @param
    * @return
    */
    public function actionRegistration() {
        if (Yii::app()->user->isGuest) {
  
            $user = new User;
  
            /*
            * Ajax валидация
            */
            $this->performAjaxValidation($user);
 
            if(empty($_POST['User'])) {
                /*
                * Если форма не отправленна, то выводим форму
                */
                $this->render('registration', array('model' => $user));
 
            } else {
                /*
                * Форма получена
                */
                $user->attributes = $_POST['User'];
 
                /*
                * Валидация данных
                */
                if($user->validate('reg')) {
                    /*
                    * Если проверка пройдена, проверяем на уникальность имя
                    * пользователя и e-mail
                    */

                    $pattern = array('(',')','+','-',' ');
                    $user->phone = str_replace($pattern,'',$user->phone);

                    if($user->model()->count("phone = :phone",
                        array(':phone' => $user->phone))) {

                        $user->addError('phone', 'Пользователь с таким номером существует');
                        $this->render("registration", array('model' => $user));

                    }
                    else if($user->model()->count("email = :email",
                        array(':email' => $user->email))) {
 
                        $user->addError('email', 'E-mail уже занят');
                        $this->render("registration", array('model' => $user));
 
                    } /*else if($user->model()->count("username = :username",
                        array(':username' => $user->username))) {
 
                        $user->addError('username', 'Имя пользователя уже занято');
                        $this->render("registration", array('model' => $user));

                    }*/
                    else {
                        /*
                        * Если проверки пройдены шифруем пароль, генерируем код
                        * активации аккаунта, а также устанавливаем время регистрации
                        * и роль по умолчанию для пользователя
                        */
                        $pattern = array('(',')','+','-',' ');
                        $user->phone = str_replace($pattern,'',$user->phone);
                        $user->username      = $user->phone;
                        $user->emailPass     = $user->password;
                        $user->password      = md5(md5($user->password));
                        $user->activationKey = substr(md5(uniqid(rand(), true)), 0, rand(10, 15));
                        $user->status        = '0';
                        $user->test          = $_POST['User']['test'];


                        // если тестовый период даем потестить недельку
                        if($_POST['User']['test'] == 1){
                           $user->datePayment   = date('Y-m-d H:i:s',strtotime("+7 day"));
                        }else{
                           $user->datePayment   = date('Y-m-d H:i:s');
                        }

                        // пробный период
                        $user->countPay = 20;
                        $user->residPublic = 20;

                        /*
                        * Проверяем если добавление пользователя прошло успешно
                        * устанавливаем ему права.
                        */
                        if($user->save()) {
                                /*
                                * Если роль успешно добавилась, выводим сообщение
                                * об успешной регистрации и отправляем код активации аккаунта
                                */
                                $this->render("registrationOk");
 
                                $this->activationKey($user);
                        } else {
                            throw new CHttpException(403, 'Ошибка добавления в базу данных.');
                        }
                    }
                } else {
                    /*
                    * Не прошел валидацию
                    */
                    $this->render('registration', array('model' => $user));
                }
            }
        } else {
            /*
            * Если пользователь залогинен редиректим обратно
            */
            $this->redirect(Yii::app()->user->returnUrl);
        }
    }

    protected function performAjaxValidation($model) {
       if(isset($_POST['ajax']) && $_POST['ajax']==='user-form') {
           echo CActiveForm::validate($model);
           Yii::app()->end();
       }
    }
 
   /*
   * Отправление кода активации
   *
   * @param model $model
   * @return bolean
   */
   protected function activationKey($model) {
       $email = Yii::app()->email;
 
       $email->to = $model->email;

       $email->from = 'admin@rlpnz.ru';
 
       $email->subject = 'Вы успешно зарегистрированны на сайте Недвижимость в Пензе';
 
       $email->message = '<p>Ваш логин: +'.$model->username.'</p>
                          <p>Ваш пароль: '.$model->emailPass.'</p>
                          <p>Чтобы войти на сайт перейдите по <a href = "http://rlpnz.ru/index.php?r=site/login">ссылке</a></p>';
     
       $email->send();
   }

   function actions() {
        return array('captcha'=>array(
            'class'=>'MyCCaptchaAction',
            'backColor'=>0xFFFFFF,
                        )
        );
    }


}