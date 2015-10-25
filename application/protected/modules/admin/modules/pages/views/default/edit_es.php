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
		Заголовок
	</div>
	<div class="col-9">
		<?=$form->textField($modelLangEs,'[es]header', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLangEs,'[es]header');?>
        </div>
	</div>
</div>

<? foreach($contents as $content) : ?>
    <div class="row form-group">
        <div class="col-3 form-collabel">
            Блок <?=$content->alias;?>
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