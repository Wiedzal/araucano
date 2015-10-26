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
        if($id == 6)
        {
            die('В разработке');
        }
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
            if (array_key_exists('Pages', $_POST))
            {
                $model->attributes = $_POST['Pages'];
            }
            
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
            'textBlock' => $content,
            'textBlockLang' => $contentLang,
        ));
    }
    
    public function actionAddContent()
	{
        $langs = Yii::app()->params['translatedLanguages'];
        //var_dump($langs);die;
        
        if (Yii::app()->request->isPostRequest)
        {
            //var_dump($_POST);die;
            
            $page_id = Yii::app()->request->getPost('page_id');
            $text = Yii::app()->request->getPost('text');
            $alias = Yii::app()->request->getPost('alias');
             
            if(!$page_id || !$alias)
            {
                echo CJSON::encode(array('error'=>'Ошибка запроса. Обновите страницу и попробуйте ещё раз.'));
                Yii::app()->end();
            }
            
            $model = new Contents();  
            
            $model->alias = $alias;
            $model->page_id = $page_id;

            if(!$model->validate())
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            else
            {
                $transaction = Yii::app()->db->beginTransaction();
                
                try 
                {
                    if(!$model->save())
                    {
                        throw new Exception('Ошибка при сохранении данных.');
                    }
                    
                    foreach($langs as $lang => $value)
                    {
                        $modelLang = new ContentsLang();
                        
                        $modelLang->text = $text;
                        $modelLang->lang = $lang;
                        $modelLang->content_id = $model->id;
                        
                        if(!$modelLang->save())
                        {
                            throw new Exception('Ошибка при сохранении данных.');
                        }
                    }

                    $transaction->commit();
                }
                catch(Exception $e) 
                {
                    $transaction->rollBack();
                    echo CJSON::encode(array('error'=>$e->getMessage()));
                    Yii::app()->end();
                }
            }
            
            echo CJSON::encode(array());
            Yii::app()->end();
        }
        
	}

    public function actionDeleteContent($id)
    {
        if(Yii::app()->request->isPostRequest)
        {            
            if ((isset($_POST['YII_CSRF_TOKEN'])) && ($_POST['YII_CSRF_TOKEN'] === Yii::app()->request->csrfToken))
            {
                $model = Contents::model()->findByPk($id);
                
                $page_id = $model->page_id;
                
                $transaction = Yii::app()->db->beginTransaction();
                try 
                {
                    if(!$model->delete())
                    {
                        throw new Exception('Ошибка при сохранении данных.');
                    }
                    
                    $criteria = new CDbCriteria;
                    $criteria->condition = 'content_id=:content_id';
                    $criteria->params = array(
                        'content_id' => $id, 
                    );

                    $builder = new CDbCommandBuilder(Yii::app()->db->getSchema());
                    $command = $builder->createDeleteCommand('contents_lang', $criteria);

                    if($command->execute() === false)
                    {
                        throw new Exception('Ошибка при сохранении данных.');
                    }

                    $transaction->commit();
                }
                catch(Exception $e) 
                {
                    $transaction->rollBack();
                    echo CJSON::encode(array('error'=>$e->getMessage()));
                    Yii::app()->end();
                }
                
                $this->redirect($this->createUrl('default/edit/id/' . $page_id));
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