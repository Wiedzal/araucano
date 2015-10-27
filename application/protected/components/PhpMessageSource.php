<?php

class PhpMessageSource extends CPhpMessageSource
{
    public $_messages=array();

	public function translate($category, $message, $language = null, $context = '')
	{
		if($language === null)
        {
            $language=Yii::app()->getLanguage();
        }
			
		if($this->forceTranslation || $language!==$this->getLanguage())
        {
            return $this->translateMessage($category, $message, $language, $context);
        }
			
		else
        {
            return $message;
        }
			
	}    
    
	protected function translateMessage($category, $message, $language, $context = '')
	{
        Yii::import('application.modules.admin.modules.translate.components.*');
        Yii::import('application.modules.admin.modules.translate.models.*');
        
		$key = $language . '.' . $category;
        $keyDefault = Yii::app()->sourceLanguage . '.' . $category;
        
        $this->_messages[$key] = $this->loadMessages($category, $language);
        $this->_messages[$keyDefault] = $this->loadMessages($category, Yii::app()->sourceLanguage);

		if(!isset($this->_messages[$key]))
        {
            $this->_messages[$key] = $this->loadMessages($category, $language);
        }
        if(!isset($this->_messages[$keyDefault]))
        {
            $this->_messages[$keyDefault] = $this->loadMessages($category, Yii::app()->sourceLanguage);
        }
        
        $keyMessage = sha1($message . $context);
        
		if(isset($this->_messages[$key][$keyMessage]) && $this->_messages[$key][$keyMessage]!=='')
        {
            return $this->_messages[$key][$keyMessage];
        }
        elseif(isset($this->_messages[$keyDefault][$keyMessage]) && $this->_messages[$keyDefault][$keyMessage]!=='')
        {
            return $this->_messages[$keyDefault][$keyMessage];
        }
        
		elseif($this->hasEventHandler('onMissingTranslation'))
		{
			$event = new MissingTranslationEvent($this, $category, $message, $language, $context);
			$this->onMissingTranslation($event);
			return $event->message;
		}
		else
			return $message;
	}	
}