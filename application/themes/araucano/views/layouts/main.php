<!DOCTYPE html>

<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->

<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->

<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->

<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->


    <? include 'control_head.php'; ?>

    <body class="body">

        <? include 'common_header.php'; ?>

        <div id="register">

            <div class="content-wrapper">
                <? foreach($page->contents as $content) : ?>
                    <?=$content->lang->text?>
                <? endforeach; ?>
            </div>

        </div>

        <? include 'common_footer.php'; ?>
        
    </body>
</html>


