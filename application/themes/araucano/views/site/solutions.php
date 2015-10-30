<div class="content-wrapper page-<?=$page->alias?>" id="page-<?=$page->alias?>">

    <? foreach($page->contents as $content) : ?>
        <?=$content->lang->text?>
    <? endforeach; ?>

</div>