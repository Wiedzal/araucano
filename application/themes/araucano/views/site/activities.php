<div class="content-wrapper page-activities" id="page-activities">

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