<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'edit-navigation-form',
    //'enableAjaxValidation' => true,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

<div class="row form-group">
    <div class="col-3">
        Открывать в новой вкладке
    </div>
    <div class="col-8">
        <?=$form->checkBox($model, 'target'); ?>
    </div>
</div>

<div class="row form-group">
    <div class="col-3">
        Показывать в меню
    </div>
    <div class="col-8">
        <?=$form->checkBox($model, 'is_visible'); ?>
    </div>
</div>

<? if($model->location == 'top') : ?>
    <div class="row form-group">
        <div class="col-3 form-collabel">
            Порядок следования
        </div>
        <div class="col-9">
            <?=$form->listBox($model, 'sort_order', $list, array('class'=>'form-input', 'size'=>0))?>
        </div>
    </div>
<? endif; ?>

<div class="row form-group">
    <div class="col-3 form-collabel">
        Адрес
    </div>
    <div class="col-9">
        <?=$form->textField($model,'url', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($model,'url');?>
        </div>
    </div>
</div>

<div class="row form-group">
    <div class="col-3 form-collabel">
        Привязанная страница
    </div>
    <div class="col-9">
        <?=$form->listBox($model, 'object_id', $pagesList, array('class'=>'form-input', 'size'=>0))?>
    </div>
</div>

<hr class="mt30 mb30" />

<div class="row form-group">
	<div class="col-3 form-collabel">
		Название
	</div>
</div>

<div class="row form-group">
	<div class="col-3 form-collabel">
		<i class="flag flag-small _ru mr5"></i>
	</div>
	<div class="col-9">
        <?=$form->textField($modelLangRu,'[ru]title', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLangRu,'[ru]title');?>
        </div>
	</div>
</div>

<div class="row form-group">
	<div class="col-3 form-collabel">
		<i class="flag flag-small _es mr5"></i>
	</div>
	<div class="col-9">
        <?=$form->textField($modelLangEs,'[es]title', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLangEs,'[es]title');?>
        </div>
	</div>
</div>

<div class="row form-group">
	<div class="col-3 form-collabel">
		<i class="flag flag-small _en mr5"></i>
	</div>
	<div class="col-9">
        <?=$form->textField($modelLangEn,'[en]title', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLangEn,'[en]title');?>
        </div>
	</div>
</div>

<div class="form-actions">
    <?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'btn btn-success')); ?>
    <?=CHtml::link('Вернуться назад', $this->createUrl('default/index'), array('class'=>'btn'))?>
</div>

<?php $this->endWidget(); ?>