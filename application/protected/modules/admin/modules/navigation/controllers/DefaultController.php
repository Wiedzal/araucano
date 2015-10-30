<?php

class DefaultController extends AdminModuleController
{
	public function init() 
    {
        $this->breadcrumbs = array('Управление навигацией' => $this->createUrl('index'));
        parent::init();
    }
    
    public function actionIndex()
	{
        $this->breadcrumbs = array_merge($this->breadcrumbs, array('Верхнее меню'));
        $this->pageTitle = 'Верхнее меню';
        
        $criteria = new CDbCriteria();
        $criteria->condition = 'location=:location';
        $criteria->params = array('location'=>'top');
        $criteria->order = 'sort_order';
        
        $models = Navigation::model()->findAll($criteria);

		$this->render('index', array(
            'models' => $models,
        ));
	}
    
    public function actionEdit($id)
    {
        $model = Navigation::model()->findByPk($id);

        if($model == null)
        {
            throw new CHttpException(404, Yii::t('app', 'Страница не найдена'));
        }
        
        $this->pageTitle = 'Редактирование пункта "' . $model->lang->title . '"';
        $this->breadcrumbs = array_merge($this->breadcrumbs, array('Редактирование'));
        
        $modelLangRu = $model->getNavigationLangModel('ru');
        $modelLangEs = $model->getNavigationLangModel('es');
        $modelLangEn = $model->getNavigationLangModel('en');

        if (!empty($_POST) && array_key_exists('Navigation', $_POST))
        {
            //var_dump($_POST);die;
            $transaction = Yii::app()->db->beginTransaction();
            try 
            {
                $modelLangRu->attributes = $_POST['NavigationLang']['ru'];
                $modelLangEs->attributes = $_POST['NavigationLang']['es'];
                $modelLangEn->attributes = $_POST['NavigationLang']['en'];
                
                $model->attributes = $_POST['Navigation'];
                $model->updatePosition(array('location'=>$model->location));
                
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
                
                NavigationLang::model()->updateAll(array('langs'=>'|ru|es|en|'), 'navigation_id=:navigation_id',array('navigation_id'=>$id));
                
                $transaction->commit();
                
                Yii::app()->user->setFlash('success', 'Пункт успешно отредактирован');
                if($model->location == 'footer')
                {
                    Yii::app()->request->redirect($this->createUrl('footer'));
                }
                Yii::app()->request->redirect($this->createUrl('index'));
            }
            catch(Exception $e) 
            {
                $error = $e->getMessage();
                $transaction->rollBack();
            }
        }
        
        $list = array(
            1 => 'Первым'
        );
		$neighborsItems = Navigation::model()->findAll();
		$count = Navigation::model()->count();
		for ($i = 0; $i < $count; $i ++)
        {
			if ($neighborsItems[$i]->sort_order != $model->sort_order) 
			{
				$list[$neighborsItems[$i]->sort_order + 1] = 'После '.$neighborsItems[$i]->lang->title;
			}
		}
        
        $pagesList = $model->getPossiblePages();
        $pagesList[0] = '<Отсутствует>';

        $this->render('edit', array(
            'model' => $model,
            'list' => $list,
            'pagesList' => $pagesList,
            'modelLangRu' => $modelLangRu,
            'modelLangEs' => $modelLangEs,
            'modelLangEn' => $modelLangEn,
        ));
    }
    
    
    public function actionFooter()
	{
        $this->breadcrumbs = array_merge($this->breadcrumbs, array('Нижнее меню'));
        $this->pageTitle = 'Нижнее меню';
        
        $criteria = new CDbCriteria();
        $criteria->condition = 'location=:location';
        $criteria->params = array('location'=>'footer');
        $criteria->order = 'sort_order';
        
        $models = Navigation::model()->findAll($criteria);

		$this->render('footer', array(
            'models' => $models,
        ));
	}
}