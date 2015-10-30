

<div class="col-sm-3 col-xs-6">

    <ul class="footer-nav">
    
        <? foreach($navigations as $navigation) : ?>
            
            <? if($navigation->sort_order == 1) : ?>
                <li class="bold uppercase"><?=Yii::t('app', 'Первые шаги')?></li>
            <? elseif($navigation->sort_order == 6) : ?>
                </ul>
                </div>
                <div class="col-sm-3 col-xs-6">
                <ul class="footer-nav">
                <li class="bold uppercase"><?=Yii::t('app', 'Компания')?></li>
            <? elseif($navigation->sort_order == 11) : ?>
                </ul>
                </div>
                <div class="col-sm-3 col-xs-6">
                <ul class="footer-nav">
                <li class="bold uppercase"><?=Yii::t('app', 'Инструменты')?></li>
            <? elseif($navigation->sort_order == 16) : ?>
                </ul>
                </div>
                <div class="col-sm-3 col-xs-6">
                <ul class="footer-nav">
                <li class="bold uppercase"><?=Yii::t('app', 'Помощь')?></li>
            <? endif; ?>
            
            <li><a  target="<?if($navigation->target):?>_blank<?else:?>_self<?endif;?>" href="<?=Yii::app()->createUrl($navigation->url)?>"><?=$navigation->lang->title?></a></li>
        
        <? endforeach; ?>
        
    </ul>

</div>