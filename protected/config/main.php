<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Недвижимость в Пензе, купить квартиру, комнату, землю, коммерческую недвижимость, дома, дачи',
    'language'=>'ru',
    'defaultController' => 'guest',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
        'application.helpers.*',
		'application.models.*',
		'application.components.*',
        'application.extensions.app.*',
		'application.extensions.EAjaxUpload.*',
		'application.modules.srbac.controllers.SBaseController',
		//'application.modules.srbac.models.Assignments',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
        'User',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'629265',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array($_SERVER['REMOTE_ADDR']),
		),
		'srbac' => array(
            'userclass' => 'User',
            'userid' => 'id',
            'username' => 'username',
            'debug' => true,
            'delimeter'=>"@",
            'pageSize' => 10,
            'superUser' => 'Authority',
            'css' => 'srbac.css',
            'layout' => 'application.views.layouts.main',
            'notAuthorizedView' => 'srbac.views.authitem.unauthorized',
            //'alwaysAllowed'=>array(),
            'userActions' => array('show', 'View', 'List'),
            'listBoxNumberOfLines' => 15,
            'imagesPath' => 'srbac.images',
            'imagesPack' => 'tango',
            'iconText' => false,
            'header' => 'srbac.views.authitem.header',
            'footer' => 'srbac.views.authitem.footer',
            'showHeader' => true,
            'showFooter' => true,
            'alwaysAllowedPath' => 'srbac.components',
        ),


	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            //'class' => 'WebUser',
		),
        //'cache'=>array('class'=>'system.caching.CFileCache'),

        'cache'=>array(
            'class'=>'system.caching.CMemCache',
            //'useMemcached' => true,
            'servers'=>array(
                array('host'=>'127.0.0.1', 'port'=>11211),
            ),

        ),
        'image'=>array(
                'class'=>'application.extensions.image.CImageComponent',
                // GD or ImageMagick
                'driver'=>'GD',
                // ImageMagick setup path
                'params'=>array('directory'=>'/opt/local/bin'),
         ),


		'app'=>array(
			 'class' => 'application.extensions.app.app',
		),
		'clientScript' => array(
              'scriptMap' => array(
                    'jquery.js' => false,
              )
          ),
		 'email'=>array(
         'class'=>'application.extensions.email.Email',
         'delivery'=>'php', //Will use the php mailing function.  
        //May also be set to 'debug' to instead dump the contents of the email into the view
         ),

         /*
         'authManager' => array(
            'class' => 'srbac.components.SDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'items',
            'assignmentTable' => 'assignments',
            'itemChildTable' => 'itemchildren',
        ),
         */
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
        ),

		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
    'urlFormat' => 'path',
    'showScriptName'=>false,
    'urlSuffix' => '',
    'rules'=>array(
        'feed.xml' => array('post/feed', 'urlSuffix' => ''),
        '<controller:\w+>/<id:\d+>' => '<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    ),
),
		*/
        /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
       */
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=publishads',
			'emulatePrepare' => true,
			'username' => 'kaman62',
			'password' => '89048512165',
			'charset' => 'utf8',
            'schemaCachingDuration' => 1000,
		),


		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),


	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),

);