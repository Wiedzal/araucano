<div class="row form-group">
	<div class="col-3 form-collabel">
		Название
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
		Заголовок h1
	</div>
	<div class="col-9">
		<?=$form->textField($modelLangRu,'[ru]header', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLangRu,'[ru]header');?>
        </div>
	</div>
</div>

<div class="row form-group">
	<div class="col-3 form-collabel">
		Заголовок h3
	</div>
	<div class="col-9">
		<?=$form->textField($modelLangRu,'[ru]header_add', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLangRu,'[ru]header_add');?>
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
                'model'=>$content->lang_ru,
                'attribute' => '['.$content->alias . '][ru]text',
                'language' => 'ru',
                'editorTemplate' => 'full',
                'height' => '300px'));?>
            <div class="form-error">
                <?=$form->error($content->lang_ru, '['.$content->alias . '][ru]text');?>
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
		<?=$form->textField($modelLangRu,'[ru]meta_keywords', array('class' => 'form-input')); ?>
        <div class="form-error">
            <?=$form->error($modelLangRu,'[ru]meta_keywords');?>
        </div>
	</div>
</div>
<div class="row form-group">
	<div class="col-3 form-collabel">
		Ключевое описание
	</div>
	<div class="col-9">
		<?=$form->textArea($modelLangRu,'[ru]meta_description', array('class' => 'form-input', 'row' => 2)); ?>
        <div class="form-error">
            <?=$form->error($modelLangRu,'[ru]meta_description');?>
        </div>
	</div>
</div>