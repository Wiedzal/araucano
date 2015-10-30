<div id="register">

    <div class="content-wrapper">
	    <? foreach($page->contents as $content) : ?>
            <?=$content->lang->text?>
        <? endforeach; ?>
    </div>
        
</div>

<script>
    $(function(){
        var free = "<?=Yii::app()->createUrl('/pricing/free')?>";
        var premium = "<?=Yii::app()->createUrl('/pricing/premium')?>";
        var cloud = "<?=Yii::app()->createUrl('/pricing/cloud')?>";
        var local = "<?=Yii::app()->createUrl('/pricing/local')?>";
        
        $("#free").attr('href', free);
        $("#premium").attr('href', premium);
        $("#cloud").attr('href', cloud);
        $("#local").attr('href', local);
        
    });
</script>