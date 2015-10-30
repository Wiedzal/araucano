<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'create-page-form',
    //'enableAjaxValidation' => true,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),

)); ?>

<div class="row form-group">
    <div class="col-3 form-collabel">
        Шаблон
    </div>
    <div class="col-9">
        <?=$form->listBox($model, 'layout', Pages::getAssocTemplates(), array('class'=>'form-input', 'size'=>0))?>
    </div>
</div>

<div class="row form-group">
    <div class="col-3 form-collabel">
        Название
    </div>
    <div class="col-9">
        <?=$form->textField($modelLang,'title', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLang,'title');?>
        </div>
    </div>
</div>

<div class="row form-group">
	<div class="col-3 form-collabel">
		Ключевые слова
	</div>
	<div class="col-9">
		<?=$form->textField($modelLang,'meta_keywords', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLang,'meta_keywords');?>
        </div>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Ключевое описание
	</div>
	<div class="col-9">
		<?=$form->textArea($modelLang,'meta_description', array('class' => 'form-input', 'row' => 2)); ?>
        <div class="form-error">
            <?=$form->error($modelLang,'meta_description');?>
        </div>
	</div>
</div>

<div class="form-actions">
    <?=CHtml::submitButton('Создать', array('class'=>'btn btn-success')); ?>
    <?=CHtml::link(Yii::t('app', 'Вернуться назад'), $this->createUrl('default/index'), array('class'=>'btn'))?>
</div>
<?php $this->endWidget(); ?>