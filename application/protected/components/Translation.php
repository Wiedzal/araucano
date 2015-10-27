<?php

class Translation extends CApplicationComponent
{
    public static function handleMissingTranslation($event)
    {
        $translate      = new Translate();
        $translateLang  = new TranslateLang();
    
        $translate->text        = $event->message;
        $translate->category    = $event->category;
        $translate->context     = $event->context;
        $translate->guid        = Translate::setNewGuid($translate->text, $translate->category, $translate->context);
        $translate->object_type = Translate::OBJECT_TYPE_STATIC_PHP;
        
        if (!$translate->save())
        {
            Yii::trace('LANGS COLLECTION ERROR. CODE#1: ' . var_export($translate->getErrors(), TRUE));
        }
        
        $translateLang->translate__id   = $translate->id;
        $translateLang->lang            = Yii::app()->sourceLanguage;
        $translateLang->translate       = $event->message;
        
        if (!$translateLang->save())
        {
            Yii::trace('LANGS COLLECTION ERROR. CODE#2: ' . var_export($translateLang->getErrors(), TRUE));
        }
        
        Translate::fileRegenerate();
    }
    
}