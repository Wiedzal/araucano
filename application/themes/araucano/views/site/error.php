<? if($code == '404') : ?>
    <? $message = '<h4>'. Yii::t('app', 'Извините, раздел находится в разработке. Вы можете получить интересующие Вас данные обратившись с запросом по адресу') . '<a href="mailto:support@araucano.org" style="color: rgb(0,154,223)">support@araucano.org</a></h4>'; ?>
<? endif; ?>


<div class="content-wrapper">

	<div class="content">

		<div class="container">

            <div>
                <?/*=$code*/?>
            </div>
        
			<div class="text-center mt250">

				<?=$message?>

			</div>

		</div>

	</div>

</div>