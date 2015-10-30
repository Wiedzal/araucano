<?php

class DefaultController extends Controller
{
	public function init() 
    {
        Yii::import('application.modules.admin.modules.navigation.models.*');
        Yii::import('application.modules.admin.modules.pages.models.*');
        parent::init();
    }
    
    public function actionShowpage()
	{
        
		$url = Yii::app()->request->requestUri;
        //var_dump($url);die;
        $currentUrl = Navigation::model()->find('url=:url', array(':url'=> $url));
        //var_dump($currentUrl);die;
        //var_dump($currentUrl->object_id);die;
        if ($currentUrl == NULL)
        {
            throw new CHttpException(404,Yii::t('yii','Unable to resolve the request "{route}".',
				array('{route}'=>$url===''?$this->defaultController:$url)));            
        }
        
        $page = Pages::model()->findByPk($currentUrl->object_id);
        
        if ($page == NULL)
        {
            throw new CHttpException(404,Yii::t('yii','Unable to resolve the request "{route}".',
				array('{route}'=>$url===''?$this->defaultController:$url)));  
        }
       
        //var_dump($page);die;
        $this->pageTitle = $page->lang->title;
        
        $this->data_global['page'] = $page;
        $this->layout = $this->layouts_path . $page->layout;
        
        $this->render('showpage', array('page'=>$page));
	}
}