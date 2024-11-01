<style type="text/css">
	.tbpAdminMainLeftSide {
		width: 56%;
		float: left;
	}
	.tbpAdminMainRightSide {
		width: <?php echo (empty($this->optsDisplayOnMainPage) ? 100 : 40)?>%;
		float: left;
		text-align: center;
	}
	#tbpMainOccupancy {
		box-shadow: none !important;
	}
</style>
<section>
	<div class="supsystic-item supsystic-panel">
		<div id="containerWrapper">
			<?php _e('Main page Go here!!!!', TBP_LANG_CODE)?>
		</div>
		<div style="clear: both;"></div>
	</div>
</section>