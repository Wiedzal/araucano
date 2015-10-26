<div class="container-fluid homepage">
    <div class="row row-dh-4 banner" 
        <? if($page->image) : ?>
            style="background-image: url('<?=$page->imageUrl?>')"
        <? endif; ?>
    >
        <div class="col-md-5">
            <div class="hidden-xs">
                <h1><?=$page->lang->header?></h1>
            </div>
            <div class="visible-xs">
                <h2><?=$page->lang->header?></h2>
            </div>
            <div class="hidden-xs">
                <h3 class="light"><?=$page->lang->header_add?></h3>
            </div>
            <div class="visible-xs">
                <h4 class="light"><?=$page->lang->header_add?></h4>
            </div>
            <a href="javascript:void(0)" class="btn btn-orange mt10"><?=Yii::t('app', 'Зарегистрироваться')?></a>
        </div>
        <div class="col-md-7"></div>
    </div>
</div>

<? foreach($page->contents as $content) : ?>
    <?=$content->lang->text?>
<? endforeach; ?>