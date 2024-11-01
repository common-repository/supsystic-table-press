var g_tbpCurrTour = null
,	g_tbpTourOpenedWithTab = false
,	g_tbpAdminTourDissmissed = false;
jQuery(document).ready(function(){
	setTimeout(function(){
		if(typeof(tbpAdminTourData) !== 'undefined' && tbpAdminTourData.tour) {
			jQuery('body').append( tbpAdminTourData.html );
			tbpAdminTourData._$ = jQuery('#supsystic-admin-tour');
			for(var tourId in tbpAdminTourData.tour) {
				if(tbpAdminTourData.tour[ tourId ].points) {
					for(var pointId in tbpAdminTourData.tour[ tourId ].points) {
						_tbpOpenPointer(tourId, pointId);
						break;	// Open only first one
					}
				}
			}
			for(var tourId in tbpAdminTourData.tour) {
				if(tbpAdminTourData.tour[ tourId ].points) {
					for(var pointId in tbpAdminTourData.tour[ tourId ].points) {
						if(tbpAdminTourData.tour[ tourId ].points[ pointId ].sub_tab) {
							var subTab = tbpAdminTourData.tour[ tourId ].points[ pointId ].sub_tab;
							jQuery('a[href="'+ subTab+ '"]')
								.data('tourId', tourId)
								.data('pointId', pointId);
							var tabChangeEvt = str_replace(subTab, '#', '')+ '_tabSwitch';
							jQuery(document).bind(tabChangeEvt, function(event, selector) {
								if(!g_tbpTourOpenedWithTab && !g_tbpAdminTourDissmissed) {
									var $clickTab = jQuery('a[href="'+ selector+ '"]');
									_tbpOpenPointer($clickTab.data('tourId'), $clickTab.data('pointId'));
								}
							});
						}
					}
				}
			}
		}
	}, 500);
});

function _tbpOpenPointerAndPopupTab(tourId, pointId, tab) {
	g_tbpTourOpenedWithTab = true;
	jQuery('#tbpPopupEditTabs').wpTabs('activate', tab);
	_tbpOpenPointer(tourId, pointId);
	g_tbpTourOpenedWithTab = false;
}
function _tbpOpenPointer(tourId, pointId) {
	var pointer = tbpAdminTourData.tour[ tourId ].points[ pointId ];
	var $content = tbpAdminTourData._$.find('#supsystic-'+ tourId+ '-'+ pointId);
	if(!jQuery(pointer.target) || !jQuery(pointer.target).size())
		return;
	if(g_tbpCurrTour) {
		_tbpTourSendNext(g_tbpCurrTour._tourId, g_tbpCurrTour._pointId);
		g_tbpCurrTour.element.pointer('close');
		g_tbpCurrTour = null;
	}
	if(pointer.sub_tab && jQuery('#tbpPopupEditTabs').wpTabs('getActiveTab') != pointer.sub_tab) {
		return;
	}
	var options = jQuery.extend( pointer.options, {
		content: $content.find('.supsystic-tour-content').html()
	,	pointerClass: 'wp-pointer supsystic-pointer'
	,	close: function() {
			//console.log('closed');
		}
	,	buttons: function(event, t) {
			g_tbpCurrTour = t;
			g_tbpCurrTour._tourId = tourId;
			g_tbpCurrTour._pointId = pointId;
			var $btnsShell = $content.find('.supsystic-tour-btns')
			,	$closeBtn = $btnsShell.find('.close')
			,	$finishBtn = $btnsShell.find('.supsystic-tour-finish-btn');

			if($finishBtn && $finishBtn.size()) {
				$finishBtn.click(function(e){
					e.preventDefault();
					jQuery.sendFormTbp({
						msgElID: 'noMessages'
					,	data: {mod: 'supsystic_promo', action: 'addTourFinish', tourId: tourId, pointId: pointId}
					});
					g_tbpCurrTour.element.pointer('close');
				});
			}
			if($closeBtn && $closeBtn.size()) {
				$closeBtn.bind( 'click.pointer', function(e) {
					e.preventDefault();
					jQuery.sendFormTbp({
						msgElID: 'noMessages'
					,	data: {mod: 'supsystic_promo', action: 'closeTour', tourId: tourId, pointId: pointId}
					});
					t.element.pointer('close');
					g_tbpAdminTourDissmissed = true;
				});
			}
			return $btnsShell;
		}
	});
	jQuery(pointer.target).pointer( options ).pointer('open');
	var minTop = 10
	,	pointerTop = parseInt(g_tbpCurrTour.pointer.css('top'));
	if(!isNaN(pointerTop) && pointerTop < minTop) {
		g_tbpCurrTour.pointer.css('top', minTop+ 'px');
	}
}
function _tbpTourSendNext(tourId, pointId) {
	jQuery.sendFormTbp({
		msgElID: 'noMessages'
	,	data: {mod: 'supsystic_promo', action: 'addTourStep', tourId: tourId, pointId: pointId}
	});
}