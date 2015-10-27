<?php

class StaticController extends AdminModuleController
{
	public function init() 
    {
        $this->breadcrumbs = array('Статичные тексты' => $this->createUrl('index'));
        parent::init();
    }
    
    public function actionIndex()
	{
        $this->pageTitle = 'Управление переводом';
        
        $criteria           = new CDbCriteria();
        $criteria->with     = array();
        
        $criteria->order    = 't.created_at DESC';
        
        $filter             = array();

        $checkBoxDefaultOn  = TRUE;

        
        $count              = Translate::model()->count($criteria);
        $pages              = new CPagination($count);
        $pages->pageSize    = TRANSLATES_PER_PAGE;
        $pages->applyLimit($criteria);
        $translates         = Translate::model()->findAll($criteria);

        $langs              = Langs::model()->findAll();
        
        $translatesLang = array();
        foreach ($translates as $translate)
        {
            $translatesLang[$translate->id] = array();
            foreach ($translate->langs as $translateLang)
            {
                foreach ($langs as $lang)
                {
                    if (!array_key_exists($lang->alias, $translatesLang[$translate->id]))
                    {
                        $translatesLang[$translate->id][$lang->alias] = '';
                    }
                    
                    if ($translateLang->lang == $lang->alias)
                    {
                        $translatesLang[$translate->id][$lang->alias] = $translateLang->translate;
                    }
                    
                }
            }
        }
        
        $model      = new Translate();
        $modelLang  = new TranslateLang(); 

        $this->include_jquery_form();

        CHtml::asset(Yii::getPathOfAlias('application.modules.admin.modules.translate.css'));

        $this->render('index', array(
            'translates'        => $translates, 
            'pages'             => $pages,
            'model'             => $model,
            'modelLang'         => $modelLang,
            'langs'             => $langs,
            'translatesLang'    => $translatesLang,
            'filter'            => $filter,
            'checkBoxDefaultOn' => $checkBoxDefaultOn
        ));
	}
    
    public function actionTranslate()
    {
        if (!Yii::app()->request->isPostRequest)
        {
            throw new CHttpException(403, 'Forbidden');
        }
        if ((empty($_POST)) || (!array_key_exists('form', $_POST)) || (!array_key_exists('text_id', $_POST['form'])) || (!array_key_exists('text_translate', $_POST['form'])) || (!is_array($_POST['form']['text_translate'])))
        {
            throw new CHttpException(403, 'Forbidden');
        }

        $text = Translate::model()->findByPk($_POST['form']['text_id']);
        
        if ($text == NULL)
        {
            throw new CHttpException(403, 'Forbidden');
        }
        
        $isChange       = FALSE;
        
        $textTranslated = $_POST['form']['text_translate'];
        
        $langs          = Langs::model()->findAll();
        
        foreach ($langs as $lang)
        {
            if (array_key_exists($lang->alias, $textTranslated))
            {
                $translateLang = TranslateLang::model()->find('translate__id=:translate__id AND lang=:lang', array(':translate__id' => $text->id, ':lang' => $lang->alias));
                
                if ($translateLang == NULL)
                {
                    $translateLang                  = new TranslateLang();
                    $translateLang->translate__id   = $text->id;
                    $translateLang->lang            = $lang->alias;
                }
                
                if ($translateLang->translate != $textTranslated[$translateLang->lang])
                {
                    $isChange = TRUE;
                    $translateLang->translate = $textTranslated[$translateLang->lang];
                    if (!$translateLang->save())
                    {
                        Yii::trace('TRANSLATE EDIT SAVE FATAL ERROR. CODE#1: ' . var_export($translateLang->getErrors(), TRUE));
                        throw new CException('Ошибка сохранения перевода', E_USER_ERROR);
                    }                
                }
            }
        }
        
        if ((bool)$isChange)
        {
            if ($text->object_type == Translate::OBJECT_TYPE_STATIC_JAVASCRIPT)
            {
                Translate::fileRegenerateJavascript();
            }
            else
            {
                Translate::fileRegenerate();
            }
        }
        
        echo CJSON::encode(array('result' => $isChange, 'texts' => $textTranslated));
        
    }
    
    public function include_jquery_form()
    {
        $ScriptFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'jquery.form';

        if (file_exists($ScriptFile)) 
        {
            $path = Yii::app()->assetManager->publish($ScriptFile) . '/';
      
			Yii::app()->clientScript->registerCssFile(
                $path . 'css/smoothness/jquery-ui-1.8.24.custom.css', 'screen'
			);

            Yii::app()->clientScript->registerScriptFile(
					$path . 'jquery.form.js', CClientScript::POS_HEAD
			);          
        }
    }   
}