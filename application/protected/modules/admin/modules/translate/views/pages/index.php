<? if(Yii::app()->user->hasFlash('success')): ?>
    <div class="note note-success mb30">
        <div class="note-close"></div>
         <?=Yii::app()->user->getFlash('success');?>
    </div>
<? endif; ?>

<? if(empty($models)) : ?>

    <div class="note note-info">
        <?=Yii::t('app', 'У вас ещё не создано ни одной страницы. Вы можете')?> <a href="<?=$this->createUrl('pages/create')?>" class="medium"><?=Yii::t('app', 'создать страницу')?></a>
    </div>

<? else : ?>

    <table class="table table-hover">
        <thead>
            <tr>
                <th><i class="flag flag-smaller _ru mr5"></i> Заголовок</th>
                <th><i class="flag flag-smaller _es mr5"></i> Título</th>
                <th><i class="flag flag-smaller _en mr5"></i> Title</th>
                <th class="w150">Действия</th>
            </tr>
        </thead>
        <tbody>
        <? foreach($models as $model) : ?>
            <tr>
                <td class="item-title"><?=$model->getTitleByLang('ru');?></td>
                <td class="item-title"><?=$model->getTitleByLang('es');?></td>
                <td class="item-title"><?=$model->getTitleByLang('en');?></td>
                <td class="w175">
                    <a href="<?=$this->createUrl('pages/edit/id/'.$model->id)?>" class="btn btn-success btn-icon"><i class="fa fa-pencil"></i></a>  
                </td>
            </tr>
        <? endforeach ?>
        </tbody>
    </table>

    

<? endif; ?>