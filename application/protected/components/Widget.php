<?php

class Widget extends CWidget
{
    public $data = array();
    public $data_global = array();
    
    public $base_uri;
    
    /**
	 * @var array view paths for different types of widgets
	 */
	private static $_viewPaths;
    
    public function init()
    {
        parent::init();
    }
    
    public function assign($name, $value)
    {
        if (strpos($name, '_') === 0)
        {
            trigger_error("Имя $name не подходит" . ' Не используйте знак подчеркивания в начале имени 
                переменной. Для определения глобальной переменной есть метод assign_global', E_USER_ERROR);
        }

        $this->data[$name] = $value;
    }

    public function assign_global($name, $value)
    {
        $name = '_' . $name;
        $this->data_global[$name] = $value;
    }

    public function render($view, $vars = null, $return = false)
    {
        if (is_array($vars))
        {
            foreach($vars as $name => $value)
            {
                $this->assign($name, $value);
            }            
        }

        $data = array_merge($this->data_global, $this->data);
        
        if(($viewFile=$this->getViewFile($view))!==false)
			return $this->renderFile($viewFile,$data,$return);
		else
			throw new CException(Yii::t('yii','{widget} cannot find the view "{view}".',
				array('{widget}'=>get_class($this), '{view}'=>$view)));
        
    }
    
    public function getViewPath($checkTheme=false)
	{
		$className=get_class($this);
		
		if($checkTheme && ($theme=Yii::app()->getTheme())!==null)
		{
			$path=$theme->getViewPath().DIRECTORY_SEPARATOR;
			
			$path = dirname($path) . DIRECTORY_SEPARATOR . 'views_widgets';
			
			if(strpos($className,'\\')!==false) // namespaced class
				$path.=str_replace('\\','_',ltrim($className,'\\'));
			else
				$path.= DIRECTORY_SEPARATOR . $className;
			if(is_dir($path))
				return self::$_viewPaths[$className]=$path;
		}
		
		if(isset(self::$_viewPaths[$className]))
			return self::$_viewPaths[$className];
		else
		{
			$class=new ReflectionClass($className);
			return self::$_viewPaths[$className]=dirname($class->getFileName()).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$className;
		}
	}
 
}
