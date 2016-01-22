<?php

class SiteController extends Controller
{
    public $description = '';
    public $keywords = '';
    public $title = '';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');

	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
                echo $model->email;
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                // Дополнительные заголовки
                $headers .= 'Reply-To: Mary <mary@example.com>' . "\r\n";
                $headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
                $headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
                $headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";


                mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */

	public function actionLogin()
	{   
		if($_GET['key'] != '2a9c1f246de5724b02d782586b098a68'): 
		 header('HTTP/1.1 404 Not Found');     
		 die();
		endif;
		session_start();

        $model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['LoginForm']))
		{
			   $model->attributes = $_POST['LoginForm'];
			   if($model->validate()){

                  $_SESSION['LoginForm'] = $_POST['LoginForm'];

                  // создаем проверочный код
                  $_SESSION['code'] = rand(1000, 5000);
                  // получаем email 
                  $password = md5(md5($_POST['LoginForm']['password']));
                  //$login    = $_POST['LoginForm']['username'];

                  preg_match("%\d+%", $_POST['LoginForm']['username'],$matches);
                  $login = $matches[0];

                  $emailSend = Yii::app()->app->emailData($password, $login);

                   $model->attributes = $_SESSION['LoginForm'];
                   if($model->validate() && $model->login()){
                       $interval =  Yii::app()->app->public_ads_count($password, $login);

                       ($interval) ? $ival = $interval : $ival = 2;
                       setcookie ("intVal",$ival,time()+3600000,'/');
                       $redirect = explode(';',$_COOKIE['path']);
                       ($redirect[0]) ? $redirect = $redirect[0] : $redirect = '/index.php?r=publication/index';
                       $this->redirect($redirect);

                   }
                  /* не работает смс
                  if($emailSend['status'] == 0){

                       $mess =  "Код подтверждения: ".$_SESSION['code'];
                       $_SESSION['id'] = $emailSend['id'];
                       include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/smsaero.php');

                       $sms = new Smsaero('serega569256@bk.ru', 's89048512165', 'INFORM');
                       $sms->send($emailSend['phone'],$mess);

                      $this->render('intensification',array('code'=>$_SESSION['code'],'phone'=>$emailSend['phone']));
                  }else{
                       $model->attributes = $_SESSION['LoginForm'];
                       if($model->validate() && $model->login()){
                           $redirect = explode(';',$_COOKIE['path']);
                           ($redirect[0]) ? $redirect = $redirect[0] : $redirect = '/nedvizhimost_v_penze.html';
                            $this->redirect($redirect);

                       }
                  }
                  */
                  
                 // $emailSend = Yii::app()->app->emailData($password, $login);

                      /*
                      $title = 'Код подтверждения rlpnz.ru';
                      $mess =  "Код подтверждения: ".$_SESSION['code'];
				      // $to - кому отправляем 
				      $to = trim($emailSend['email']);
	                  // $from - от кого
                      // 'From:'.$from
                      $headers  = "Content-Type: text/plain; charset=utf-8 \r\n";
                      $headers .= "From: =?utf-8?b?" . base64_encode('Недвижимость Пензы') . "?= <admin@rlpnz.ru.ru>\r\n";
                      $headers .= "Bcc: admin@rlpnz.ru\r\n";

                   mail($to, $title, $mess, $headers);

                   $mess =  "Код подтверждения: ".$_SESSION['code'];

                   include_once($_SERVER['DOCUMENT_ROOT'].'/pars/cfg/smsaero.php');

                   $sms = new Smsaero('serega569256@bk.ru', 's89048512165', 'INFORM');
                   $sms->send(trim($emailSend['phone']),$mess);

                  $this->render('check',array('email'=>$emailSend['email'],'phone'=>$emailSend['phone']));
                  */
                   // убрали подтверждение входа на сайт
                   //$model->attributes = $_SESSION['LoginForm'];
                   //if($model->validate() && $model->login()){
                   //    $this->redirect(array('/realtyObject/index')); //Yii::app()->user->returnUrl
                   //}

               }else if(!$_SESSION['LoginForm']){   // если форма не прошла валидацию
               	  $this->render('login',array('model'=>$model));
               }			
		}

		if(isset($_POST['code'])){

			if($_POST['code'] == $_SESSION['code']){

               User::model()->updateByPk($_SESSION['id'], array('status' => 1));

               $model->attributes = $_SESSION['LoginForm'];
               if($model->validate() && $model->login()){
			      $this->redirect(Yii::app()->user->returnUrl);
			   }
			}else{
			   $this->render('errorChek');
			   session_destroy();
			}
		}


		if(!isset($_POST['LoginForm']) and !isset($_POST['code'])){
		   $this->render('login',array('model'=>$model));
		}
		
	}

    // забыли пароль
    public function actionRestore(){

        $user = new User;

    if($_POST['email']){
        if($user->model()->count("email = :email", array(':email' => trim($_POST['email'])))){

            $criteria = new CDbCriteria();
            $criteria->addCondition("email LIKE '%".trim($_POST['email'])."%'");
            $models = User::model()->findAll($criteria);

            $newPass = rand(1000000,2000000);

            User::model()->updateByPk($models[0]['id'], array('password' => md5(md5($newPass))));

            $email = Yii::app()->email;

            $email->to = trim($_POST['email']);

            $email->from = 'admin@rlpnz.ru';

            $email->subject = 'Ваш новый пароль';

            $email->message = '<p>Новый пароль: '.$newPass.'</p>';

            $email->send();

            $model = '<p>На электронную почту <b>'.$_POST['email'].'</b> был выслан новый пароль.</p>';

        }else{
            $model = 'Такого пользователя не существует. Возможно вы ошиблись!';
        }
            $this->render('restore',array('model'=>$model));
    }else{
    $this->render('restore');
    }
    }


	public function actionCheck(){
		//$this->render('check');
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}