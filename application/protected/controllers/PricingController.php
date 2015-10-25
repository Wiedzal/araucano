<?php

class PricingController extends Controller
{
    public function init() 
    {
        parent::init();
    }

    public function actionIndex()
    {
        //$this->checkAccess('Admin');
        $this->layout = 'home';
        $this->pageTitle = Yii::t('app', 'Наши Тарифные Планы');

        $this->render('index');
    }
    
    public function actionFree()
    {
        //$this->checkAccess('Admin');
        $this->layout = 'home';
        $this->pageTitle = Yii::t('app', 'Наши Тарифные Планы');

        $this->render('free');
    }
    
    public function actionPremium()
    {
        //$this->checkAccess('Admin');
        $this->layout = 'home';
        $this->pageTitle = Yii::t('app', 'Премиум');

        $this->render('premium');
    }
    
    public function actionCloud()
    {
        //$this->checkAccess('Admin');
        $this->layout = 'home';
        $this->pageTitle = Yii::t('app', 'Свое облако');

        $this->render('cloud');
    }
    
    public function actionLocal()
    {
        //$this->checkAccess('Admin');
        $this->layout = 'home';
        $this->pageTitle = Yii::t('app', 'Локальный');

        $this->render('local');
    }
}