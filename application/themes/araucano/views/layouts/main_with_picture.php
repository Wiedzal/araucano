<!DOCTYPE html>

<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->

<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->

<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->

<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->


    <? include 'control_head.php'; ?>

    <body class="body">

        <? include 'common_header.php'; ?>

        <div class="content-wrapper page-<?=$page->alias?>" id="page-<?=$page->alias?>">

            <div class="container-fluid section-banner bottom-align" 
                <? if($page->image) : ?>
                    style="background-image: url('<?=$page->imageUrl?>')"
                <? endif; ?>
            >

                <div class="row row-dh-2">

                    <div class="text-center">

                        <div class="hidden-xs">

                            <h1><?=$page->lang->header?></h1>

                        </div>

                        <div class="visible-xs">

                            <h2><?=$page->lang->header?></h2>

                        </div>

                    </div>

                </div>

            </div>

            <? foreach($page->contents as $content) : ?>
                <?=$content->lang->text?>
            <? endforeach; ?>

        </div>

        <? include 'common_footer.php'; ?>
        
    </body>
</html>


