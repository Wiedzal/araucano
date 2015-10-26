<?php

class SiteController extends Controller
{
    public function init() 
    {
        Yii::import('application.modules.admin.modules.pages.models.*');
        parent::init();
    }
    
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
        //$this->pageTitle = Yii::t('app', 'Главная');
        
        $page = Pages::model()->find('alias=:alias', array('alias'=>'home'));
        //var_dump($page->lang);die;
        $this->pageTitle = $page->lang->title ? $page->lang->title : Yii::t('app', 'Главная');
        
        $this->pageDescription = $page->lang->meta_description;
        $this->pageKeywords = $page->lang->meta_keywords;

        $this->layout = 'home';
        $this->render('index', array('page'=>$page));
    }
    
    public function actionAbout()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $page = Pages::model()->find('alias=:alias', array('alias'=>'about'));
        
        $this->pageTitle = $page->lang->title ? $page->lang->title : Yii::t('app', 'Наша история');
        
        $this->pageDescription = $page->lang->meta_description;
        $this->pageKeywords = $page->lang->meta_keywords;

        $this->layout = 'home';
        $this->render('about', array('page'=>$page));
    }
    
    public function actionActivities()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $page = Pages::model()->find('alias=:alias', array('alias'=>'activities'));
        
        $this->pageTitle = $page->lang->title ? $page->lang->title : Yii::t('app', 'Активности');
        
        $this->pageDescription = $page->lang->meta_description;
        $this->pageKeywords = $page->lang->meta_keywords;
        
        $this->layout = 'home';
        $this->render('activities', array('page'=>$page));
    }
    
    public function actionSolutions()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $page = Pages::model()->find('alias=:alias', array('alias'=>'solitions'));
        
        $this->pageTitle = $page->lang->title ? $page->lang->title : Yii::t('app', 'Решения');
        
        $this->pageDescription = $page->lang->meta_description;
        $this->pageKeywords = $page->lang->meta_keywords;
        
        $this->layout = 'home';
        $this->render('solutions', array('page'=>$page));
    }

    public function actionTechnologies()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $page = Pages::model()->find('alias=:alias', array('alias'=>'technologies'));
        
        $this->pageTitle = $page->lang->title ? $page->lang->title : Yii::t('app', 'Технологии');
        
        $this->pageDescription = $page->lang->meta_description;
        $this->pageKeywords = $page->lang->meta_keywords;
        
        $this->layout = 'home';
        $this->render('technologies', array('page'=>$page));
    }
    
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        $this->layout = 'home';
        if($error = Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                echo $error['message'];
            }
            else
            {
                $this->render('error', $error);
            }
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
                $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
                $subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                $headers="From: $name <{$model->email}>\r\n".
                    "Reply-To: {$model->email}\r\n".
                    "MIME-Version: 1.0\r\n".
                    "Content-Type: text/plain; charset=UTF-8";

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
        $this->layout = 'main';
        $this->pageTitle = 'Авторизация';
        
        $model = new LoginForm;

        if(isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];
            
            if($model->validate() && $model->login())
            {
                if (Yii::app()->user->username == Yii::app()->params['adminUsername'])
                {
                    $this->redirect('/admin');
                }
                $this->redirect(Yii::app()->homeUrl);
            }
        }

        $this->render('login', array('model' => $model));
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