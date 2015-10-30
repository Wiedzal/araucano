<link rel="stylesheet" href="<?=Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('application.modules.admin.modules.translate.css'))?>/css/admintranslate.css" type="text/css" media="screen, projection" />

<table id="langs" class="table table-hover">
    
    <thead>
        <tr>
            <th>№</th>
            <th>Оригинальный текст</th>
            <? foreach ($langs as $lang) : ?>
                <th class="photo table-lang table-lang-<?=$lang->alias?>">
                    <?=CHtml::encode($lang->lang->title)?>
                </th>
            <? endforeach; ?>
            <th class="w150">Действия</th>
        </tr>
    </thead>

    <tbody>

        <? if(empty($translates)) :?>
            <tr>
                <td colspan="<?=count($langs) + 4?>">Не найдено ни одного текста</td>
            </tr>
        <? else : ?>   
            <?php $i = ((array_key_exists('page', $_GET) ? $_GET['page'] : (int)TRUE) - 1) * TRANSLATES_PER_PAGE + 1; ?>
            <? foreach($translates as $key => $translate) :?>  
                <tr>
                    <td>
                        <?=$i++?>
                    </td>
                    <td id="orig-text-table-<?=$translate->id?>" style="text-align: left; padding-left: 15px;">
                        <?=CHtml::encode($translate->text)?>
                    </td>
                    <? foreach ($langs as $lang) : ?>
                        <td id="orig-switch-table-<?=$translate->id?>-<?=$lang->alias?>" class="photo table-lang table-lang-<?=$lang->alias?>"">
                            <? if ((array_key_exists($translate->id, $translatesLang)) && (array_key_exists($lang->alias, $translatesLang[$translate->id])) && (empty($translatesLang[$translate->id][$lang->alias]))) : ?>
                                <span class="no-translate"></span>
                                <span id="translate-text-<?=$translate->id?>_<?=$lang->alias?>" langalias=<?=$lang->alias?> translateId = <?=$translate->id?> class="translate-text"></span>
                            <? elseif ((array_key_exists($translate->id, $translatesLang)) && (array_key_exists($lang->alias, $translatesLang[$translate->id])) && (!empty($translatesLang[$translate->id][$lang->alias]))) : ?>
                                <span class="translate"></span>
                                <span id="translate-text-<?=$translate->id?>_<?=$lang->alias?>" langalias=<?=$lang->alias?> translateId = <?=$translate->id?> class="translate-text"><?=CHtml::encode($translatesLang[$translate->id][$lang->alias])?></span>
                            <? endif; ?>
                        </th>
                    <? endforeach; ?>                    
                    <td>
                        <?=CHtml::link('Перевести', 'javascript: void(0)', array('onClick' => 'editTranslate(' . $translate->id . ')'));  ?>
                    </td>
                </tr>
            <? endforeach; ?> 
        <? endif; ?>
    </tbody>
</table>

<div class="modal fade" id="translateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-close" data-dismiss="modal" aria-label="Close"></div>
				<div class="modal-title">Перевод текста</div>
			</div>

            <?=CHtml::beginForm($this->createUrl('translate'), 'POST', array('id' => 'translate-from'))?>
            <div class="modal-body">
            
                <div class="row form-group">
                    <div class="col-3 form-collabel">
                        Оригинальный текст
                    </div>
                    <div class="col-9 form-collabel">
                        <div id="original-text"></div>
                    </div>
                </div>
            
                <ul class="acc">
                    <? foreach ($langs as $lang) : ?>
                        <li class="acc-item">
                            <a href="javascript:void(0)" class="acc-title" data-target="#ru">
                                <i class="flag flag-small _<?=$lang->alias?> mr5"></i>
                                <?=CHtml::encode($lang->lang->title)?>
                            </a>
                            <div class="acc-content">
                                <?=CHtml::textArea('form[text_translate][' . $lang->alias . ']', '', array('cols' => 79, 'rows' => 5, 'id' => 'translate-form-' . $lang->alias))?>
                            </div>
                        </li>
                    <? endforeach ?>
                </ul>
			</div>
			<div class="modal-footer text-right">
				<?=CHtml::submitButton('Перевести', array('class'=>'btn btn-success ajax-btn')); ?>
				<span class="btn btn-error" data-dismiss="modal">Отмена</span>
                <?=CHtml::hiddenField('form[text_id]', (int)FALSE, array('id' => 'text_id'))?>
			</div>
			<?=CHtml::endForm()?>
		</div>
	</div>
</div>