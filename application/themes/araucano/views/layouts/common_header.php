
<header>

    <div class="container-fluid">

        <div class="row">

            <div class="brand left hidden-xs">

                <div class="logo ">

                    <a href="<?=Yii::app()->createUrl('/site/index')?>"><img src="<?=Yii::app()->theme->baseUrl ?>/public/site/img/logo.png"></a>

                </div>

            </div>

            <div class="nav-toggle left ml20">

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

            </div>

            <nav class="nav left">

                <ul class="nav-list">

                    <li class="nav-item"><a href="<?=Yii::app()->createUrl('/site/index')?>" class="nav-link"><?=Yii::t('app', 'Домой')?></a></li>

                    <li class="nav-item"><a href="<?=Yii::app()->createUrl('/site/about')?>" class="nav-link"><?=Yii::t('app', 'Наша история')?></a></li>

                    <li class="nav-item"><a href="<?=Yii::app()->createUrl('/site/activities')?>" class="nav-link"><?=Yii::t('app', 'Активности')?></a></li>

                    <li class="nav-item"><a href="<?=Yii::app()->createUrl('/pricing')?>" class="nav-link"><?=Yii::t('app', 'Версии и стоимость')?></a></li>

                    <li class="nav-item"><a href="<?=Yii::app()->createUrl('/site/solutions')?>" class="nav-link"><?=Yii::t('app', 'Решения')?></a></li>

                    <li class="nav-item"><a href="<?=Yii::app()->createUrl('/site/technologies')?>" class="nav-link"><?=Yii::t('app', 'Технологии')?></a></li>

                </ul>

                

            </nav>

            

            <div class="right">

                <?php $this->widget('LanguageSwitcherWidget'); ?>

            </div>

        </div>

    </div>

</header>