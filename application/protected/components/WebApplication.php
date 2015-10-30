<?php

class WebApplication extends CWebApplication
{
    public function __construct($config = null) 
    {
        parent::__construct($config);
    }
    
    public function init() 
    {
        parent::init();
    }
    
        
    public function runController($route)
	{
        Yii::app()->session->open();

		if((($ca=$this->createController($route))!==null) && ((!empty($route))))
		{
			list($controller,$actionID)=$ca;
			$oldController=$this->getController();
            $this->setController($controller);
			$controller->init();
			$controller->run($actionID);
            $this->setController($oldController);
		}		
		
		elseif (($ca=$this->createController('page/default/showpage')) !== NULL)
		{
            
			list($controller,$actionID)=$ca;
			$oldController=$this->getController();
            $this->setController($controller);
			$controller->init();
			$controller->run($actionID);
            $this->setController($oldController);
		} 
		
		else
			throw new CHttpException(404,Yii::t('yii','Unable to resolve the request "{route}".',
				array('{route}'=>$route===''?$this->defaultController:$route)));
	}
}
