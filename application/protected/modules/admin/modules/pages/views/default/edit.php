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

<div class="row form-group">
    <div class="col-3 form-collabel">
        Фоновое изображение
        <h6 class="form-info text-gray"><?=Yii::t('app', 'Максимальный размер 5MB')?></h6>
    </div>
    <div class="col-9 form-collabel">
        <? if($model->imageUrl) : ?>
            <div class="mb20">
                <?=CHtml::link(CHtml::image($model->imageThumbUrl, ''), $model->imageUrl); ?>
                <br/>
                <?=CHtml::link(Yii::t('app', 'Изменить'), 'javascript:void(0)', array('id' => 'link-change'))?>
                
                <?=CHtml::link(Yii::t('app', 'Удалить'), "#", array(
                    'submit' => $this->createUrl('default/deletePicture', array('id' => $model->id)),
                    'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                    'confirm' => Yii::t('app', 'Удалить изображение?'),
                    'onclick' => 'onPictureDelete()'));
                ?>
            </div>
        <? else : ?>
            <div id="image-is-miss">
                <?=Yii::t('app', 'Отсутствует')?><br/>
                <?=CHtml::link(Yii::t('app', 'Изменить'), 'javascript:void(0)', array('id' => 'link-change'))?>
            </div>
        <? endif ; ?>
        <div class="input-file" style="display:none" id="form-block">
            <input id="image-field" type="text" class="form-input" placeholder="<?=Yii::t('app', 'Файл не выбран')?>" readonly />
            <button class="btn"><?=Yii::t('app', 'Обзор')?></button>
            <?=$form->fileField($model, 'image', array('class'=>'none'))?>
            <h6 class="form-info">
                <?=CHtml::link(Yii::t('app', 'Отмена'), 'javascript:void(0)', array('id'=>'link-cancel'))?>
            </h6>
        </div>
        <div class="form-error">
            <?=$form->error($model,'image',array('id'=>'image-error'));?>
        </div>
    </div>
</div>

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
    <?=CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Создать') : Yii::t('app', 'Сохранить'), array('class'=>'btn btn-success')); ?>
    <?=CHtml::link(Yii::t('app', 'Добавить текстовый блок'), $this->createUrl('default/addContent'), array('class'=>'btn add-btn'))?>
    <?=CHtml::link(Yii::t('app', 'Вернуться назад'), $this->createUrl('default/index'), array('class'=>'btn'))?>
</div>

<?php $this->endWidget(); ?>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog w500">
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
                        <?=$form->textField($content,'alias', array('class' => 'form-input')); ?>
                        <div class="form-error">
                            <?=$form->error($content,'alias');?>
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-footer text-right">
				<?php echo CHtml::ajaxSubmitButton('Отправить запрос',
                        CHtml::normalizeUrl(array('/admin/pages/default/addContent')), 
                        array('success'=>'function(json){'
                            . 'if(!jQuery.isEmptyObject(json)) {
                                $(".text-error").html("");
                                $.each(json, function(arrayID,el) {
                                    $("#"+arrayID).next(".text-error").html("Ошибка! "+el[0]);
                                    
                                    });
                                 
                                }
                            else {$("#popup").modal("hide"); $("#popup2").modal("show");}}', 'fail' => 'function(){alert("error") }'),
                        array('name' => 'callback', 'class' => 'btn btn-red')
                ); ?>
				<span class="btn btn-error" data-dismiss="modal">Отмена</span>
				<input type="hidden" name="delete" value="delete" />
                <?=$form->hiddenField($model, 'id');?>
			</div>
			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>