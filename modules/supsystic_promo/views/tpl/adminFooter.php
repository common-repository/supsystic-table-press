<div class="tbpAdminFooterShell">
	<div class="tbpAdminFooterCell">
		<?php echo TBP_WP_PLUGIN_NAME?>
		<?php _e('Version', TBP_LANG_CODE)?>:
		<a target="_blank" href="http://wordpress.org/plugins/popup-by-supsystic/changelog/"><?php echo TBP_VERSION?></a>
	</div>
	<div class="tbpAdminFooterCell">|</div>
	<?php  if(!frameTbp::_()->getModule(implode('', array('l','ic','e','ns','e')))) {?>
	<div class="tbpAdminFooterCell">
		<?php _e('Go', TBP_LANG_CODE)?>&nbsp;<a target="_blank" href="<?php echo $this->getModule()->getMainLink();?>"><?php _e('PRO', TBP_LANG_CODE)?></a>
	</div>
	<div class="tbpAdminFooterCell">|</div>
	<?php } ?>
	<div class="tbpAdminFooterCell">
		<a target="_blank" href="http://wordpress.org/support/plugin/popup-by-supsystic"><?php _e('Support', TBP_LANG_CODE)?></a>
	</div>
	<div class="tbpAdminFooterCell">|</div>
	<div class="tbpAdminFooterCell">
		Add your <a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/popup-by-supsystic?filter=5#postform">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on wordpress.org.
	</div>
</div>