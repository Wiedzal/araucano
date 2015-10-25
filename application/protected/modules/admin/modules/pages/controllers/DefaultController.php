<?php

class DefaultController extends AdminModuleController
{
	public function init() 
    {
        $this->breadcrumbs = array(Yii::t('app', 'Страницы') => $this->createUrl('index'));
        parent::init();
    }
    
    public function actionIndex()
	{
        $this->breadcrumbs = array_merge($this->breadcrumbs, array(Yii::t('app', 'Управление страницами')));
        $this->pageTitle = Yii::t('app', 'Управление страницами');
        
        $models = Pages::model()->findAll();

		$this->render('index', array(
            'models' => $models,
        ));
	}
    
    public function actionEdit($id)
    {
        $this->pageTitle = Yii::t('app', 'Редактирование страницы');

        $model = Pages::model()->findByPk($id);
        //var_dump(Yii::app()->language);
        //var_dump($model->lang);die;
        $content = new Contents();
        $contentLang = new ContentsLang();
        
        if($model == null)
        {
            throw new CHttpException(404, Yii::t('app', 'Страница не найдена'));
        }
        
        $modelLangRu = $model->getPagesLangModel('ru');
        $modelLangEs = $model->getPagesLangModel('es');
        $modelLangEn = $model->getPagesLangModel('en');

        $contents = Contents::model()->findAll('page_id=:page_id', array('page_id'=>$id));
        
        //var_dump($contents);die;
        //var_dump($modelLangRu);
        //var_dump($modelLangEs);
        //var_dump($modelLangEn);
        //die;

        if (!empty($_POST) && array_key_exists('PagesLang', $_POST))
        {
            //var_dump($_POST['ContentsLang']['home']['ru']);die;
            $model->attributes = $_POST['Pages'];
            
            $modelLangRu->attributes = $_POST['PagesLang']['ru'];
            $modelLangEs->attributes = $_POST['PagesLang']['es'];
            $modelLangEn->attributes = $_POST['PagesLang']['en'];

            $transaction = Yii::app()->db->beginTransaction();
            try 
            {
                if(!$model->save())
                {
                    throw new Exception('Ошибка при сохранении данных.');
                }
                
                if(!$modelLangRu->save())
                {
                    throw new Exception('Ошибка при сохранении данных.');
                }
                
                if(!$modelLangEs->save())
                {
                    throw new Exception('Ошибка при сохранении данных.');
                }
                
                if(!$modelLangEn->save())
                {
                    throw new Exception('Ошибка при сохранении данных.');
                }
                
                PagesLang::model()->updateAll(array('langs'=>'|ru|es|en|'), 'page_id=:page_id',array('page_id'=>$id));
                
                $contentsLang = Yii::app()->request->getPost('ContentsLang');
                
                if($contentsLang)
                {
                    foreach($contentsLang as $alias => $block)
                    {
                        $modelContents = Contents::model()->find('alias=:alias AND page_id=:page_id', array('page_id'=>$id, 'alias'=>$alias));

                        foreach($block as $lang => $content)
                        {
                            $relation = 'lang_'.$lang;

                            $modelContents->$relation->text = $content['text'];
                            if(!$modelContents->$relation->save())
                            {
                                throw new Exception('Ошибка при сохранении данных.');
                            }
                        }
                    }
                }

                

                $transaction->commit();
            }
            catch(Exception $e) 
            {
                $error = $e->getMessage();
                $transaction->rollBack();
            }
            
            Yii::app()->user->setFlash('success', Yii::t('app', 'Страница успешно отредактирована'));
            Yii::app()->request->redirect($this->createUrl('index'));
        }

        $this->render('edit', array(
            'model' => $model,
            'modelLangRu' => $modelLangRu,
            'modelLangEs' => $modelLangEs,
            'modelLangEn' => $modelLangEn,
            'contents' => $contents,
            'content' => $content,
            'contentLang' => $contentLang,
        ));
    }
    
    public function actionAddContent()
	{
        if (Yii::app()->request->isPostRequest)
        {
            var_dump($_POST);die;
            $model = new Contents();           
            $modelLang = new ContentsLang();  
           
            $model->attributes = $_POST['Contents'] ;
            $modelLang->attributes = $_POST['ContentsLang'] ;
            
            if(!$modelLang->validate())
            {
                echo CActiveForm::validate($modelLang);
                Yii::app()->end();
            }
           else
           {
            require_once(Yii::getPathOfAlias('application.extensions') . '/class.phpmailer.php');
                
                $mail = new PHPMailer(true);                 
                $mail->CharSet = 'utf-8';                
                $mail->AddAddress(trim(Yii::app()->controller->module->params->support_email));                
                $mail->SetFrom($model->email);                
                $mail->Subject = 'Поступила заявка на звонок';                
                $letter = $this->renderPartial('callback', array('model'=>$model), TRUE);                
                $mail->MsgHTML($letter);
                
                $mail2 = new PHPMailer(true);                 
                $mail2->CharSet = 'utf-8';                
                $mail2->AddAddress($model->email);                
                $mail2->SetFrom(trim(Yii::app()->controller->module->params->support_email));                
                $mail2->Subject = 'Ваша заявка на звонок принята';                
                $letter2 = $this->renderPartial('callback_user', array('model'=>$model), TRUE);                
                $mail2->MsgHTML($letter2);
                
                if(!$mail->Send() || !$mail2->Send())
                {
                    echo array('error' => 'ошибка отправки письма');
                    Yii::app()->end();
                }
                else
                {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
                }
       
           }
         
           
        }
        
        
        
        if(Yii::app()->request->isPostRequest)
        {            
            if ((isset($_POST['YII_CSRF_TOKEN'])) && ($_POST['YII_CSRF_TOKEN'] === Yii::app()->request->csrfToken))
            {
                $model = Pages::model()->findByPk($id);
                $model->imageBehavior->deleteFile();
                $model->image = null;
                $model->save();
                
                $this->redirect($this->createUrl('default/edit/id/' . $id));    
            }            
        }
        else
        {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
	}

    public function actionDeletePicture($id)
    {
        if(Yii::app()->request->isPostRequest)
        {            
            if ((isset($_POST['YII_CSRF_TOKEN'])) && ($_POST['YII_CSRF_TOKEN'] === Yii::app()->request->csrfToken))
            {
                $model = Pages::model()->findByPk($id);
                $model->imageBehavior->deleteFile();
                $model->image = null;
                $model->save();
                
                $this->redirect($this->createUrl('default/edit/id/' . $id));    
            }            
        }
        else
        {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }  
}