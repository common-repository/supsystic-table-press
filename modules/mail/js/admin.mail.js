jQuery(document).ready(function(){
	jQuery('#tbpMailTestForm').submit(function(){
		jQuery(this).sendFormTbp({
			btn: jQuery(this).find('button:first')
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#tbpMailTestForm').slideUp( 300 );
					jQuery('#tbpMailTestResShell').slideDown( 300 );
				}
			}
		});
		return false;
	});
	jQuery('.tbpMailTestResBtn').click(function(){
		var result = parseInt(jQuery(this).data('res'));
		jQuery.sendFormTbp({
			btn: this
		,	data: {mod: 'mail', action: 'saveMailTestRes', result: result}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#tbpMailTestResShell').slideUp( 300 );
					jQuery('#'+ (result ? 'tbpMailTestResSuccess' : 'tbpMailTestResFail')).slideDown( 300 );
				}
			}
		});
		return false;
	});
	jQuery('#tbpMailSettingsForm').submit(function(){
		jQuery(this).sendFormTbp({
			btn: jQuery(this).find('button:first')
		});
		return false; 
	});
});