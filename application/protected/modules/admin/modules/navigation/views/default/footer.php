<? if(Yii::app()->user->hasFlash('success')): ?>
    <div class="note note-success mb30">
        <div class="note-close"></div>
         <?=Yii::app()->user->getFlash('success');?>
    </div>
<? endif; ?>

<? if(empty($models)) : ?>

    <div class="note note-info">
        У вас ещё не создано ни одного пункта. Вы можете <a href="<?=$this->createUrl('default/create')?>" class="medium">создать пункт</a>
    </div>

<? else : ?>

    <table class="table table-hover">
        <thead>
            <tr>
                <th><i class="flag flag-smaller _ru mr5"></i> Заголовок</th>
                <th><i class="flag flag-smaller _es mr5"></i> Título</th>
                <th><i class="flag flag-smaller _en mr5"></i> Title</th>
                <th>Адрес</th>
                <th>Видимость</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <? foreach($models as $model) : ?>
            <? if($model->sort_order == 1) : ?>
                <tr>
                    <td class="item-title"><h2>Первые шаги</h2></td>
                </tr>
            <? elseif($model->sort_order == 6) : ?>
                <tr>
                    <td class="item-title"><h2>Компания</h2></td>
                </tr>
            <? elseif($model->sort_order == 11) : ?>
                <tr>
                    <td class="item-title"><h2>Инструменты</h2></td>
                </tr>
            <? elseif($model->sort_order == 16) : ?>
                <tr>
                    <td class="item-title"><h2>Помощь</h2></td>
                </tr>
            <? endif; ?>
            <tr>
                <td class="item-title"><?=$model->getTitleByLang('ru');?></td>
                <td class="item-title"><?=$model->getTitleByLang('es');?></td>
                <td class="item-title"><?=$model->getTitleByLang('en');?></td>
                <td class="item-title"><?=$model->url?></td>
                <td>
                    <?/*=CHtml::activeCheckBox($model, 'is_visible', array())*/?>
                    <?= $model->is_visible == (int)TRUE ? '<i class="fa fa-check-square-o"></i>' : '';?>
                    
                </td>
                <td class="w75">
                    <a href="<?=$this->createUrl('default/edit/id/'.$model->id)?>" class="btn btn-success btn-icon"><i class="fa fa-pencil"></i></a>  
                </td>
            </tr>
        <? endforeach ?>
        
        </tbody>
    </table>
    
<? endif; ?>