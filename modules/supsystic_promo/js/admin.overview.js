jQuery(document).ready(function(){
	jQuery('#form-settings').submit(function(){
		jQuery(this).sendFormTbp({
			btn: jQuery(this).find('.button-primary')
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#form-settings').slideUp();
					jQuery('#form-settings-send-msg').slideDown();
				}
			}
		});
		return false;
	});
	jQuery('.supsystic-overview-news-content').slimScroll({
		height: '500px'
	,	railVisible: true
	,	alwaysVisible: true
	,	allowPageScroll: true
	});
	jQuery('.faq-title').click(function(){
		var descBlock = jQuery(this).find('.description:first');
		if(descBlock.is(':visible')) {
			descBlock.slideUp( g_tbpAnimationSpeed );
		} else {
			jQuery('.faq-title .description').slideUp( g_tbpAnimationSpeed );
			descBlock.slideDown( g_tbpAnimationSpeed );
		}
	});
});