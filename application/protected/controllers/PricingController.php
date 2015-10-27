<?php

class PricingController extends Controller
{
    public function init() 
    {
        Yii::import('application.modules.admin.modules.translate.models.*');
        parent::init();
    }

    public function actionIndex()
    {
        //$this->checkAccess('Admin');
        $page = Pages::model()->find('alias=:alias', array('alias'=>'pricing'));
        
        $this->pageTitle = $page->lang->title ? $page->lang->title : Yii::t('app', 'Версии и стоимость');
        
        $this->pageDescription = $page->lang->meta_description;
        $this->pageKeywords = $page->lang->meta_keywords;
        
        $this->layout = 'home';
        
        $this->render('index', array('page'=>$page));
    }
    
    public function actionFree()
    {
        //$this->checkAccess('Admin');

        $page = Pages::model()->find('alias=:alias', array('alias'=>'free'));
        
        $this->pageTitle = $page->lang->title ? $page->lang->title : Yii::t('app', 'Наши Тарифные Планы');
        
        $this->pageDescription = $page->lang->meta_description;
        $this->pageKeywords = $page->lang->meta_keywords;
        
        $this->layout = 'home';

        $this->render('free', array('page'=>$page));
    }
    
    public function actionPremium()
    {
        //$this->checkAccess('Admin');

        $page = Pages::model()->find('alias=:alias', array('alias'=>'premium'));
        
        $this->pageTitle = $page->lang->title ? $page->lang->title : Yii::t('app', 'Премиум');
        
        $this->pageDescription = $page->lang->meta_description;
        $this->pageKeywords = $page->lang->meta_keywords;
        
        $this->layout = 'home';
        
        $this->render('premium', array('page'=>$page));
    }
    
    public function actionCloud()
    {
        //$this->checkAccess('Admin');

        $page = Pages::model()->find('alias=:alias', array('alias'=>'cloud'));
        
        $this->pageTitle = $page->lang->title ? $page->lang->title : Yii::t('app', 'Свое облако');
        
        $this->pageDescription = $page->lang->meta_description;
        $this->pageKeywords = $page->lang->meta_keywords;
        
        $this->layout = 'home';
        
        $this->render('cloud', array('page'=>$page));
    }
    
    public function actionLocal()
    {
        //$this->checkAccess('Admin');

        $page = Pages::model()->find('alias=:alias', array('alias'=>'local'));
        
        $this->pageTitle = $page->lang->title ? $page->lang->title : Yii::t('app', 'Локальный сервер');
        
        $this->pageDescription = $page->lang->meta_description;
        $this->pageKeywords = $page->lang->meta_keywords;
        
        $this->layout = 'home';

        $this->render('local', array('page'=>$page));
    }
}