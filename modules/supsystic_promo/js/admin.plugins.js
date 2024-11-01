jQuery(document).ready(function(){
	var $deactivateLnk = jQuery('#the-list tr[data-slug="'+ tbpPluginsData.plugSlug+ '"] .row-actions .deactivate a');
	if($deactivateLnk && $deactivateLnk.size()) {
		var $deactivateForm = jQuery('#tbpDeactivateForm');
		var $deactivateWnd = jQuery('#tbpDeactivateWnd').dialog({
			modal:    true
		,	autoOpen: false
		,	width: 500
		,	height: 390
		,	buttons:  {
				'Submit & Deactivate': function() {
					$deactivateForm.submit();
				}
			}
		});
		var $wndButtonset = $deactivateWnd.parents('.ui-dialog:first')
			.find('.ui-dialog-buttonpane .ui-dialog-buttonset')
		,	$deactivateDlgBtn = $deactivateWnd.find('.tbpDeactivateSkipDataBtn')
		,	deactivateUrl = $deactivateLnk.attr('href');
		$deactivateDlgBtn.attr('href', deactivateUrl);
		$wndButtonset.append( $deactivateDlgBtn );
		$deactivateLnk.click(function(){
			$deactivateWnd.dialog('open');
			return false;
		});
		
		$deactivateForm.submit(function(){
			var $btn = $wndButtonset.find('button:first');
			$btn.width( $btn.width() );	// Ha:)
			$btn.showLoaderTbp();
			jQuery(this).sendFormTbp({
				btn: $btn
			,	onSuccess: function(res) {
					toeRedirect( deactivateUrl );
				}
			});
			return false;
		});
		$deactivateForm.find('[name="deactivate_reason"]').change(function(){
			jQuery('.tbpDeactivateDescShell').slideUp( g_tbpAnimationSpeed );
			if(jQuery(this).prop('checked')) {
				var $descShell = jQuery(this).parents('.tbpDeactivateReasonShell:first').find('.tbpDeactivateDescShell');
				if($descShell && $descShell.size()) {
					$descShell.slideDown( g_tbpAnimationSpeed );
				}
			}
		});
	}
});