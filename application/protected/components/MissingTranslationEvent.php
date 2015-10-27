<?php

class MissingTranslationEvent extends CMissingTranslationEvent
{
	public $context;

	public function __construct($sender, $category, $message, $language, $context = '')
	{
		parent::__construct($sender, $category, $message, $language);
		$this->message  = $message;
		$this->category = $category;
		$this->language = $language;
        $this->context  = $context;
	}
    
}
