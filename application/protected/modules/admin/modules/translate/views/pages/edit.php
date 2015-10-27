<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'create-pages-form',
    //'enableAjaxValidation' => true,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'beforeValidate' => new CJavaScriptExpression('function(form) {
            for(var instanceName in CKEDITOR.instances) { 
                CKEDITOR.instances[instanceName].updateElement();
            }
            return true;
        }'),
    ),
    'stateful' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<div class="row mb30">
	<div class="col-3">Псевдоним</div>
	<div class="col-9"><?=$model->alias; ?></div>
</div>

<? if($model->is_background) : ?>
    <div class="row form-group">
        <div class="col-3 form-collabel">
            Фоновое изображение
            <h6 class="form-info text-gray"><?='Максимальный размер 5MB'?></h6>
        </div>
        <div class="col-9 form-collabel">
            <? if($model->imageUrl) : ?>
                <div class="mb20">
                    <?=CHtml::link(CHtml::image($model->imageThumbUrl, ''), $model->imageUrl); ?>
                    <br/>
                    <?=CHtml::link('Изменить', 'javascript:void(0)', array('id' => 'link-change'))?>
                    
                    <?=CHtml::link('Удалить', "#", array(
                        'submit' => $this->createUrl('pages/deletePicture', array('id' => $model->id)),
                        'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                        'confirm' => 'Удалить изображение?',
                        'onclick' => 'onPictureDelete()'));
                    ?>
                </div>
            <? else : ?>
                <div id="image-is-miss">
                    Отсутствует<br/>
                    <?=CHtml::link('Изменить', 'javascript:void(0)', array('id' => 'link-change'))?>
                </div>
            <? endif ; ?>
            <div class="input-file" style="display:none" id="form-block">
                <input id="image-field" type="text" class="form-input" placeholder="Файл не выбран" readonly />
                <button class="btn"><?=Yii::t('app', 'Обзор')?></button>
                <?=$form->fileField($model, 'image', array('class'=>'none'))?>
                <h6 class="form-info">
                    <?=CHtml::link('Отмена', 'javascript:void(0)', array('id'=>'link-cancel'))?>
                </h6>
            </div>
            <div class="form-error">
                <?=$form->error($model,'image',array('id'=>'image-error'));?>
            </div>
        </div>
    </div>
<? endif ; ?>

<ul class="acc">
	<li class="acc-item">
		<a href="javascript:void(0)" class="acc-title" data-target="#ru">
			<i class="flag flag-small _ru mr5"></i>
			Русский язык
		</a>
		<div class="acc-content">
			<? include 'edit_ru.php' ?>
		</div>
	</li>
	<li class="acc-item">
		<a href="javascript:void(0)" class="acc-title" data-target="#by">
			<i class="flag flag-small _es mr5"></i>
			Español
		</a>
		<div class="acc-content">
			<? include 'edit_es.php' ?>
		</div>
	</li>
	<li class="acc-item">
		<a href="javascript:void(0)" class="acc-title" data-target="#en">
			<i class="flag flag-small _en mr5"></i>
			English
		</a>
		<div class="acc-content">
			<? include 'edit_en.php' ?>
		</div>
	</li>
</ul>

<div class="form-actions">
    <?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'btn btn-success')); ?>
    <?=CHtml::link('Добавить текстовый блок', $this->createUrl('pages/addContent'), array('class'=>'btn add-btn'))?>
    <?=CHtml::link('Вернуться назад', $this->createUrl('pages/index'), array('class'=>'btn'))?>
</div>

<?php $this->endWidget(); ?>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>
				<div class="modal-title">Новый текстовый блок</div>
			</div>
			<?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'addForm',
            )); ?>
			<div class="modal-body">
				<div class="row form-group">
                    <div class="col-3 form-collabel">
                        Псевдоним
                    </div>
                    <div class="col-9">
                        <?=$form->textField($textBlock,'alias', array('class' => 'form-input')); ?>
                        <div class="form-error">
                            
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-3 form-collabel">
                        Текст
                    </div>
                    <div class="col-9 form-collabel">
                        <?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
                            'model'=>$textBlockLang,
                            'attribute' => 'text',
                            'language' => 'ru',
                            'editorTemplate' => 'full',
                            'height' => '300px'));?>
                        <div class="form-error">
                            
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-footer text-right">
				<?=CHtml::submitButton('Создать', array('class'=>'btn btn-success ajax-btn')); ?>
				<span class="btn btn-error" data-dismiss="modal">Отмена</span>
                <?=$form->hiddenField($model, 'id');?>
			</div>
			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>