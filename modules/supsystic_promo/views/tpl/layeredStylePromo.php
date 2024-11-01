<div class="tbpPopupOptRow">
	<label>
		<a target="_blank" href="<?php echo $this->promoLink?>" class="sup-promolink-input">
			<?php echo htmlTbp::checkbox('layered_style_promo', array(
				'checked' => 1,
				//'attrs' => 'disabled="disabled"',
			))?>
			<?php _e('Enable Layered PopUp Style', TBP_LANG_CODE)?>
		</a>
		<a target="_blank" class="button" style="margin-top: -8px;" href="<?php echo $this->promoLink?>"><?php _e('Available in PRO', TBP_LANG_CODE)?></a>
	</label>
	<div class="description"><?php _e('By default all PopUps have modal style: it appears on user screen over the whole site. Layered style allows you to show your PopUp - on selected position: top, bottom, etc. and not over your site - but right near your content.', TBP_LANG_CODE)?></div>
</div>
<span>
	<div class="tbpPopupOptRow">
		<span class="tbpOptLabel"><?php _e('Select position for your PopUp', TBP_LANG_CODE)?></span>
		<br style="clear: both;" />
		<div id="tbpLayeredSelectPosShell">
			<div class="tbpLayeredPosCell" style="width: 30%;" data-pos="top_left"><span class="tbpLayeredPosCellContent"><?php _e('Top Left', TBP_LANG_CODE)?></span></div>
			<div class="tbpLayeredPosCell" style="width: 40%;" data-pos="top"><span class="tbpLayeredPosCellContent"><?php _e('Top', TBP_LANG_CODE)?></span></div>
			<div class="tbpLayeredPosCell" style="width: 30%;" data-pos="top_right"><span class="tbpLayeredPosCellContent"><?php _e('Top Right', TBP_LANG_CODE)?></span></div>
			<br style="clear: both;"/>
			<div class="tbpLayeredPosCell" style="width: 30%;" data-pos="center_left"><span class="tbpLayeredPosCellContent"><?php _e('Center Left', TBP_LANG_CODE)?></span></div>
			<div class="tbpLayeredPosCell" style="width: 40%;" data-pos="center"><span class="tbpLayeredPosCellContent"><?php _e('Center', TBP_LANG_CODE)?></span></div>
			<div class="tbpLayeredPosCell" style="width: 30%;" data-pos="center_right"><span class="tbpLayeredPosCellContent"><?php _e('Center Right', TBP_LANG_CODE)?></span></div>
			<br style="clear: both;"/>
			<div class="tbpLayeredPosCell" style="width: 30%;" data-pos="bottom_left"><span class="tbpLayeredPosCellContent"><?php _e('Bottom Left', TBP_LANG_CODE)?></span></div>
			<div class="tbpLayeredPosCell" style="width: 40%;" data-pos="bottom"><span class="tbpLayeredPosCellContent"><?php _e('Bottom', TBP_LANG_CODE)?></span></div>
			<div class="tbpLayeredPosCell" style="width: 30%;" data-pos="bottom_right"><span class="tbpLayeredPosCellContent"><?php _e('Bottom Right', TBP_LANG_CODE)?></span></div>
			<br style="clear: both;"/>
		</div>
		<?php echo htmlTbp::hidden('params[tpl][layered_pos]')?>
	</div>
</span>
<style type="text/css">
	#tbpLayeredSelectPosShell {
		max-width: 560px;
		height: 380px;
	}
	.tbpLayeredPosCell {
		float: left;
		cursor: pointer;
		height: 33.33%;
		text-align: center;
		vertical-align: middle;
		line-height: 110px;
	}
	.tbpLayeredPosCellContent {
		border: 1px solid #a5b6b2;
		margin: 5px;
		display: block;
		font-weight: bold;
		box-shadow: -3px -3px 6px #a5b6b2 inset;
		color: #739b92;
	}
	.tbpLayeredPosCellContent:hover, .tbpLayeredPosCell.active .tbpLayeredPosCellContent {
		background-color: #e7f5f6; /*rgba(165, 182, 178, 0.3);*/
		color: #00575d;
	}
</style>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var proExplainContent = jQuery('#tbpLayeredProExplainWnd').dialog({
			modal:    true
		,	autoOpen: false
		,	width: 460
		,	height: 180
		});
		jQuery('.tbpLayeredPosCell').click(function(){
			proExplainContent.dialog('open');
		});
	});
</script>
<!--PRO explanation Wnd-->
<div id="tbpLayeredProExplainWnd" style="display: none;" title="<?php _e('Improve Free version', TBP_LANG_CODE)?>">
	<p>
		<?php printf(__('This functionality and more - is available in PRO version. <a class="button button-primary" target="_blank" href="%s">Get it</a> today for 29$', TBP_LANG_CODE), $this->promoLink)?>
	</p>
</div>