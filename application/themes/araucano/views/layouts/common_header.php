
<header>

    <div class="container-fluid">

        <div class="row">

            <div class="brand left hidden-xs">

                <div class="logo ">

                    <a href="<?=Yii::app()->createUrl('/')?>"><img src="<?=Yii::app()->theme->baseUrl ?>/public/site/img/logo.png"></a>

                </div>

            </div>

            <div class="nav-toggle left ml20">

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

            </div>

            <nav class="nav left">

                <?php $this->widget('NavigationWidget', array('template' => 'index'));?>

            </nav>

            

            <div class="right">

                <?php $this->widget('LanguageSwitcherWidget'); ?>

            </div>

        </div>

    </div>

</header>