<form id="tbpMailTestForm">
	<label>
		<?php _e('Send test email to')?>
		<?php echo htmlTbp::text('test_email', array('value' => $this->testEmail))?>
	</label>
	<?php echo htmlTbp::hidden('mod', array('value' => 'mail'))?>
	<?php echo htmlTbp::hidden('action', array('value' => 'testEmail'))?>
	<button class="button button-primary">
		<i class="fa fa-paper-plane"></i>
		<?php _e('Send test', TBP_LANG_CODE)?>
	</button><br />
	<i><?php _e('This option allows you to check your server mail functionality', TBP_LANG_CODE)?></i>
</form>
<div id="tbpMailTestResShell" style="display: none;">
	<?php _e('Did you receive test email?', TBP_LANG_CODE)?><br />
	<button class="tbpMailTestResBtn button button-primary" data-res="1">
		<i class="fa fa-check-square-o"></i>
		<?php _e('Yes! It works!', TBP_LANG_CODE)?>
	</button>
	<button class="tbpMailTestResBtn button button-primary" data-res="0">
		<i class="fa fa-exclamation-triangle"></i>
		<?php _e('No, I need to contact my hosting provider with mail function issue.', TBP_LANG_CODE)?>
	</button>
</div>
<div id="tbpMailTestResSuccess" style="display: none;">
	<?php _e('Great! Mail function was tested and is working fine.', TBP_LANG_CODE)?>
</div>
<div id="tbpMailTestResFail" style="display: none;">
	<?php _e('Bad, please contact your hosting provider and ask them to setup mail functionality on your server.', TBP_LANG_CODE)?>
</div>
<div style="clear: both;"></div>
<form id="tbpMailSettingsForm">
	<table class="form-table" style="max-width: 450px;">
		<?php foreach($this->options as $optKey => $opt) { ?>
			<?php
				$htmlType = isset($opt['html']) ? $opt['html'] : false;
				if(empty($htmlType)) continue;
			?>
			<tr>
				<th scope="row" class="col-w-30perc">
					<?php echo $opt['label']?>
					<?php if(!empty($opt['changed_on'])) {?>
						<br />
						<span class="description">
							<?php 
							$opt['value'] 
								? printf(__('Turned On %s', TBP_LANG_CODE), dateTbp::_($opt['changed_on']))
								: printf(__('Turned Off %s', TBP_LANG_CODE), dateTbp::_($opt['changed_on']))
							?>
						</span>
					<?php }?>
				</th>
				<td class="col-w-10perc">
					<i class="fa fa-question supsystic-tooltip" title="<?php echo $opt['desc']?>"></i>
				</td>
				<td class="col-w-1perc">
					<?php echo htmlTbp::$htmlType('opt_values['. $optKey. ']', array('value' => $opt['value'], 'attrs' => 'data-optkey="'. $optKey. '"'))?>
				</td>
				<td class="col-w-50perc">
					<div id="tbpFormOptDetails_<?php echo $optKey?>" class="tbpOptDetailsShell"></div>
				</td>
			</tr>
		<?php }?>
	</table>
	<?php echo htmlTbp::hidden('mod', array('value' => 'mail'))?>
	<?php echo htmlTbp::hidden('action', array('value' => 'saveOptions'))?>
	<button class="button button-primary">
		<i class="fa fa-fw fa-save"></i>
		<?php _e('Save', TBP_LANG_CODE)?>
	</button>
</form>


