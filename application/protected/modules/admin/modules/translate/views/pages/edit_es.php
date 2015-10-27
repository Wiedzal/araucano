<div class="row form-group">
	<div class="col-3 form-collabel">
		Название
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
		Заголовок h1
	</div>
	<div class="col-9">
		<?=$form->textField($modelLangEs,'[es]header', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLangEs,'[es]header');?>
        </div>
	</div>
</div>

<? if($model->alias == 'home') : ?>
    <div class="row form-group">
        <div class="col-3 form-collabel">
            Заголовок h3
        </div>
        <div class="col-9">
            <?=$form->textField($modelLangEs,'[es]header_add', array('class' => 'form-input')); ?>
            <div class="form-error">
                <?=$form->error($modelLangEs,'[es]header_add');?>
            </div>
        </div>
    </div>
<? endif ; ?>

<? foreach($contents as $content) : ?>
    <div class="row form-group">
        <div class="col-3 form-collabel">
            Блок <b><?=$content->alias;?></b>
            <br/>
            <?=CHtml::link('Удалить', "#", array(
                'submit' => $this->createUrl('pages/deleteContent', array('id' => $content->id)),
                'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                'confirm' => 'Удалить? Будут также удалены все имеющиеся переводы данного блока',
                'onclick' => 'onDeleteContent()'));
            ?>
        </div>
        <div class="col-9 form-collabel">
            <?php $this->widget('application.extensions.ckeditor.ECKEditor', array(
                'model'=>$content->lang_es,
                'attribute' => '['.$content->alias . '][es]text',
                'language' => 'ru',
                'editorTemplate' => 'full',
                'height' => '300px'));?>
            <div class="form-error">
                <?=$form->error($content->lang_es, '['.$content->alias . '][es]text');?>
            </div>
        </div>
    </div>
<? endforeach; ?>

<hr class="mt30 mb30" />

<div class="row form-group">
	<div class="col-3 form-collabel">
		Ключевые слова
	</div>
	<div class="col-9">
		<?=$form->textField($modelLangEs,'[es]meta_keywords', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLangEs,'[es]meta_keywords');?>
        </div>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Ключевое описание
	</div>
	<div class="col-9">
		<?=$form->textArea($modelLangEs,'[es]meta_description', array('class' => 'form-input', 'row' => 2)); ?>
        <div class="form-error">
            <?=$form->error($modelLangEs,'[es]meta_description');?>
        </div>
	</div>
</div>