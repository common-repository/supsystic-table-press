<style type="text/css">
	.tbpDeactivateDescShell {
		display: none;
		margin-left: 25px;
		margin-top: 5px;
	}
	.tbpDeactivateReasonShell {
		display: block;
		margin-bottom: 10px;
	}
	#tbpDeactivateWnd input[type="text"],
	#tbpDeactivateWnd textarea {
		width: 100%;
	}
	#tbpDeactivateWnd h4 {
		line-height: 1.53em;
	}
	#tbpDeactivateWnd + .ui-dialog-buttonpane .ui-dialog-buttonset {
		float: none;
	}
	.tbpDeactivateSkipDataBtn {
		float: right;
		margin-top: 15px;
		text-decoration: none;
		color: #777 !important;
	}
</style>
<div id="tbpDeactivateWnd" style="display: none;" title="<?php _e('Your Feedback', TBP_LANG_CODE)?>">
	<h4><?php printf(__('If you have a moment, please share why you are deactivating %s', TBP_LANG_CODE), TBP_WP_PLUGIN_NAME)?></h4>
	<form id="tbpDeactivateForm">
		<label class="tbpDeactivateReasonShell">
			<?php echo htmlTbp::radiobutton('deactivate_reason', array(
				'value' => 'not_working',
			))?>
			<?php _e('Couldn\'t get the plugin to work', TBP_LANG_CODE)?>
			<div class="tbpDeactivateDescShell">
				<?php printf(__('If you have a question, <a href="%s" target="_blank">contact us</a> and will do our best to help you'), 'https://pareslider.com/contact-us/?utm_source=plugin&utm_medium=deactivated_contact&utm_campaign=popup')?>
			</div>
		</label>
		<label class="tbpDeactivateReasonShell">
			<?php echo htmlTbp::radiobutton('deactivate_reason', array(
				'value' => 'found_better',
			))?>
			<?php _e('I found a better plugin', TBP_LANG_CODE)?>
			<div class="tbpDeactivateDescShell">
				<?php echo htmlTbp::text('better_plugin', array(
					'placeholder' => __('If it\'s possible, specify plugin name', TBP_LANG_CODE),
				))?>
			</div>
		</label>
		<label class="tbpDeactivateReasonShell">
			<?php echo htmlTbp::radiobutton('deactivate_reason', array(
				'value' => 'not_need',
			))?>
			<?php _e('I no longer need the plugin', TBP_LANG_CODE)?>
		</label>
		<label class="tbpDeactivateReasonShell">
			<?php echo htmlTbp::radiobutton('deactivate_reason', array(
				'value' => 'temporary',
			))?>
			<?php _e('It\'s a temporary deactivation', TBP_LANG_CODE)?>
		</label>
		<label class="tbpDeactivateReasonShell">
			<?php echo htmlTbp::radiobutton('deactivate_reason', array(
				'value' => 'other',
			))?>
			<?php _e('Other', TBP_LANG_CODE)?>
			<div class="tbpDeactivateDescShell">
				<?php echo htmlTbp::text('other', array(
					'placeholder' => __('What is the reason?', TBP_LANG_CODE),
				))?>
			</div>
		</label>
		<?php echo htmlTbp::hidden('mod', array('value' => 'supsystic_promo'))?>
		<?php echo htmlTbp::hidden('action', array('value' => 'saveDeactivateData'))?>
	</form>
	<a href="" class="tbpDeactivateSkipDataBtn"><?php _e('Skip & Deactivate', TBP_LANG_CODE)?></a>
</div>