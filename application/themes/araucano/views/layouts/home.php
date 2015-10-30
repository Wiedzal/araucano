<!DOCTYPE html>

<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->

<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->

<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->

<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->


    <? include 'control_head.php'; ?>

    <body class="body">

        <? include 'common_header.php'; ?>

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
                <? if($page->reg_url && $page->lang->reg_title) : ?>
                    <a target="_blank" href="<?=$page->reg_url?>" class="btn btn-orange mt10"><?=$page->lang->reg_title?></a>
                <? endif; ?>
            </div>
            <div class="col-md-7"></div>
        </div>
    </div>

    <? foreach($page->contents as $content) : ?>
        <?=$content->lang->text?>
    <? endforeach; ?>

        <? include 'common_footer.php'; ?>
        
    </body>
</html>


