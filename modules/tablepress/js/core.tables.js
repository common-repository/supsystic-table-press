(function (vendor, $, window) {

	var appName = 'Tablepress';
	//var dataTableInstances = [];

	if (!(appName in vendor)){
		vendor[appName] = {};

		vendor[appName].initializeTable = (function initializeTable(tableWrapper, callback, finalCallback, settings) {
			var table = tableWrapper.find('.tbpContentTable');
			var tableObj = '';
			if(!settings){
				var settings = table.attr('data-settings');
				settings = JSON.parse(settings);
			}else{
				settings = settings.settings;
			}
			var caption = ( settings.caption_enable === '1' && undefined !== settings.caption_text && settings.caption_text.length > 0 ) ? settings.caption_text : false
				,   description = ( settings.description_enable === '1' && undefined !== settings.description_text && settings.description_text.length > 0 ) ? settings.description_text : false
				,   signature = ( settings.signature_enable === '1' && undefined !== settings.signature_text && settings.signature_text.length > 0 ) ? settings.signature_text : false
				,   headerEnable = ( settings.header_show === '1' ) ? settings.header_show : false
				,   footerEnable = ( settings.footer_show === '1' ) ? settings.footer_show : false
				,   headerFixed = ( settings.header_fixed === '1' ) ? settings.header_fixed : false
				,   responsiveMode = ( settings.responsive_mode === '1' ) ? settings.responsive_mode : false
				,   tableInformationEnable = ( settings.table_information === '1' ) ? settings.table_information : false
				,   sortingEnable = ( settings.sorting === '1' ) ? settings.sorting : false
				,   paginationEnable = ( settings.pagination === '1' ) ? settings.pagination : false
				,   searchingEnable = ( settings.searching === '1' ) ? settings.searching : false
				,   printButtonEnable = ( settings.print === '1' ) ? settings.print : false
				,   autoTableWidthEnabled = ( settings.auto_width === '1' ) ? settings.auto_width : false
				,   fixedTableWidth = ( settings.width['fixed_width'] ) ? settings.width['fixed_width'] : '100'
				,   fixedTableMeasure = ( settings.width.width_unit) ? settings.width.width_unit : 'percents'
				,   rowStriping = ( settings.row_striping) ? settings.row_striping : false
				,   highlightOrderColumn = ( settings.highlighting_order_column) ? settings.highlighting_order_column : false
				,   highlightRowByHover = ( settings.highlighting_mousehover) ? settings.highlighting_mousehover : false
				,   borders = ( settings.borders) ? settings.borders : false
				,   emptyTable = ( settings.empty_table ) ? settings.empty_table : 'No data available in table'
				,   tableInfoText = ( settings.table_info ) ? settings.table_info : 'Showing _START_ to _END_ of _TOTAL_ entries'
				,   emptyInfoText = ( settings.table_info_empty ) ? settings.table_info_empty : 'Showing 0 to 0 of 0 entries'
				,   filteredInfoText = ( settings.filtered_info_text ) ? settings.filtered_info_text : '(filtered from _MAX_ total entries)'
				,   lengthText = ( settings.length_text ) ? settings.length_text : 'Show _MENU_ entries'
				,   searchLabel = ( settings.search_label ) ? settings.search_label : 'Search:'
				,   zeroRecords = ( settings.zero_records ) ? settings.zero_records : 'No matching records are found'
				,   loaderEnabled = ( undefined === settings.hide_table_loader || settings.hide_table_loader === 0 )
				,   loaderIconColor = ( settings.table_loader_icon_color ) ? settings.table_loader_icon_color : 'black'
				,   loaderIconName = ( settings.table_loader_icon_name ) ? settings.table_loader_icon_name : 'default'
				,   loaderIconNumber = ( settings.table_loader_icon_number ) ? settings.table_loader_icon_number : '0'
			;

			//loader work
			if(loaderEnabled){
				var htmlPreview = '';
				if(loaderIconName === 'default'){
					htmlPreview = '<div class="tbpLoader"><div class="supsystic-table-loader spinner" style="background-color:'+loaderIconColor+'"></div></div>';
				}else{
					htmlPreview = '<div class="tbpLoader"><div class="supsystic-table-loader la-'+loaderIconName+' la-2x" style="color: '+loaderIconColor+'">';
					for(var i = 0; i <= loaderIconNumber; i++){
						htmlPreview += '<div></div>';
					}
					htmlPreview += '</div></div>';
				}
				tableWrapper.append(htmlPreview);
			}else{
				tableWrapper.removeClass('tbpVisibilityHidden');
			}

			var objAttr = {
				dom: 'Bfrtip',
				columnDefs: [ {
					"targets": 'no-sort',
					"orderable": false
				} ],
				order: []
			};
			if(!paginationEnable){
				objAttr['paging'] = false;
			}

			var languageObj = {};

			if(emptyTable){
				languageObj['emptyTable'] = emptyTable;
			}
			if(tableInfoText){
				languageObj['info'] = tableInfoText;
			}
			if(emptyInfoText){
				languageObj['infoEmpty'] = emptyInfoText;
			}
			if(filteredInfoText){
				languageObj['infoFiltered'] = filteredInfoText;
			}
			if(lengthText){
				languageObj['lengthMenu'] = lengthText;
			}
			if(searchLabel){
				languageObj['search'] = searchLabel;
			}
			if(zeroRecords){
				languageObj['zeroRecords'] = zeroRecords;
			}

			objAttr['language'] = languageObj;

			if(headerEnable && headerFixed){
				objAttr['fixedHeader'] = true;
			}
			if(responsiveMode){
				objAttr['responsive'] = true;
			}
			//if container for table have small width - enable scroll
			objAttr['scrollX'] = true;

			//after init callback
			objAttr['initComplete'] = function(settings, json) {
				if(typeof finalCallback  == "function") {
					finalCallback();
				}
			};

			//init table with parametrs
			tableObj = table.DataTable(objAttr);

			if(!headerEnable){
				tableWrapper.find("thead").remove();
			}
			if(!footerEnable){
				tableWrapper.find("tfoot").remove();
			}
			if(description){
				var descriptionHtml = '<div class="tbpDescription">'+description+'</div>';
				tableWrapper.prepend(descriptionHtml);
			}
			if(caption){
				var captionHtml = '<div class="tbpTitle">'+caption+'</div>';
				tableWrapper.prepend(captionHtml);
			}
			if(signature){
				var signatureHtml = '<div class="tbpSignature">'+signature+'</div>';
				tableWrapper.append(signatureHtml);
			}
			if(!tableInformationEnable){
				tableWrapper.find('.dataTables_info').remove();
			}
			if(!sortingEnable){
				tableWrapper.find('th.sorting').off('click').css('background', 'none');
			}
			if(!searchingEnable){
				tableWrapper.find('.dataTables_filter').remove();
			}
			if(!printButtonEnable){
				tableWrapper.find('.buttons-print').remove();
			}
			if(!autoTableWidthEnabled){

				if(fixedTableMeasure === 'percents'){
					tableWrapper.css('width', fixedTableWidth + '%');
				}else if(fixedTableMeasure === 'pixels'){
					tableWrapper.css('width', fixedTableWidth + 'px');
				}
			}

			if(!printButtonEnable){
				tableWrapper.find('.buttons-print').remove();
			}
			if(highlightOrderColumn){
				table.addClass('order-column');
			}
			if(rowStriping){
				table.addClass('stripe');
			}
			if(highlightRowByHover){
				table.addClass('hover');
			}
			if(borders){
				if(borders === 'cell'){
					table.addClass('cell-border dataTable');
				}else if(borders === 'rows'){
					table.addClass('row-border dataTable');
				}else if(borders === 'none'){
					table.addClass('no-border dataTable');
				}
			}

			// Correct header position
			if(headerFixed) {

				$(window).on('resize', table, function(event) {
					var tBody = tableWrapper.find('.dataTables_scrollBody');

					if(tBody.width() > table.width() || tableWrapper.width() > table.width()) {
						tBody.width(table.width());
						//plus one px to avoid displaying scroll
						tableWrapper.find('.dataTables_scrollHead, .dataTables_scrollFoot, .dataTables_scrollBody').width(table.width() + 1);
					}
					if( table.isHorizontallyScrollable ){
						tBody.css({'border-bottom' : 'none'});
					}else{
						tBody.removeStyle('border-bottom');
					}
					tableObj.fixedHeader.adjust();
				}).trigger('resize');

				var tBody = tableWrapper.find('.dataTables_scrollBody');
				if(table.is(":visible")){
					setTimeout(function() {
						$(window).trigger('resize');
					}, 200);
				}
				tableObj.fixedHeader.adjust();
			}


			return tableObj;
		});

	}

}(window.supsystic = window.supsystic || {}, window.jQuery, window));

(function($)
{
	$.fn.removeStyle = function(style)
	{
		var search = new RegExp(style + '[^;]+;?', 'g');

		return this.each(function()
		{
			$(this).attr('style', function(i, style)
			{
				return style && style.replace(search, '');
			});
		});
	};
}(jQuery));