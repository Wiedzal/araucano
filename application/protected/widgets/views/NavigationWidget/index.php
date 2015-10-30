<ul class="nav-list">

    <? foreach($navigations as $navigation) : ?>
        <li class="nav-item"><a target="<?if($navigation->target):?>_blank<?else:?>_self<?endif;?>" href="<?=Yii::app()->createUrl($navigation->url)?>" class="nav-link"><?=$navigation->lang->title?></a></li>
    <? endforeach; ?>
    
</ul>