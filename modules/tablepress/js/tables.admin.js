(function ($, app) {
    var tableContentReloading = false;

	$(document).ready(function () {

		var tableSearch = '';
		var tableContent = '';
		var tablePreview = '';

		function initTable(tablename){
            switch (tablename){
                case 'tableSearch':
                    tableSearch = $('.tbpSearchTable').css('width', '100%').DataTable(
                        {
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    text: 'Add Selected',
                                    className: 'button',
                                    action: function ( e, dt, node, config ) {
                                        $(document.body).trigger('addSelected');

                                    }
                                }
                            ],
                            columnDefs: [ {
                                "targets": 'no-sort',
                                "orderable": false
                            } ],
                            order: [],
                            responsive: true
                        }
                    );
				break;
                case 'tableContent':
                    tableContent = $('.tbpContentAdmTable').DataTable(
                        {
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    text: 'Remove Selected',
                                    className: 'button',
                                    action: function ( e, dt, node, config ) {
                                        $(document.body).trigger('removeSelected');
                                    }
                                }
                            ],
                            columnDefs: [ {
                                "targets": 'no-sort',
                                "orderable": false,
                            } ],
                            order: [],
                        }
                    );
				break;
            }
            return;
        }

        $(document.body).on( 'click', '.tbpCheckAll', function () {
            var el = $(this)
            ,   wrapper = el.closest('.dataTable')
            ,   rows = wrapper.find('tbody tr');

            if(el.is(':checked')){
                rows.addClass('selected');
                rows.find('input').prop("checked", true);
            }else{
                rows.removeClass('selected');
                rows.find('input').prop("checked", false);
            }
        });

        $(document.body).on( 'click', '#row-tab-content table tbody input[type="checkbox"]', function () {
            var el = $(this);
            if(el.is(':checked')){
                el.closest('tr').addClass('selected');
            }else{
                el.closest('tr').removeClass('selected');
            }
        });

        $(document.body).on('addSelected', function (e) {
            e.preventDefault();

            var postIdExist = $('#tbpTablePressEditForm input[name="settings[postids]"]').val();
            var data = tableSearch.rows('.selected').data().toArray();
            var elementsId = [];
            var orders = $('#tbpTablePressEditForm input[name="settings[order]"]').val();
            orders = orders.split(',');

            var elSearchType = $('#tbpSearchType input:checked').attr('data-search');

            data.forEach(function(row, i) {
                row.forEach(function(column, j) {
                    //get only id value
                    if(j === 0){
                        var html = $.parseHTML( column )
                            ,   id = $(html).attr('data-id');
                        elementsId.push(id);
                    }
                });
            });

            $('#tbpSearchTable')
                .find('.selected')
                .removeClass('selected')
                .find('input[type="checkbox"]')
                .prop( "checked", false );

            $('#tbpSearchTable')
                .find('th input[type="checkbox"]')
                .prop( "checked", false );

            var tableId = $("#tbpTablePressEditForm").attr('data-table-id');
            if(!tableId){
                tableId = 0;
            }
            var data ={
                mod:'tablepress',
                action:'getPostContent',
                type: elSearchType,
                elementsid: elementsId,
                postIdExist: postIdExist,
                order: orders,
                tableid: tableId,
                pl:'tbp',
                reqType:"ajax",
            };

            jQuery.ajax({
                url: url,
                data: data,
                type: 'POST',
                success: function(res) {
                    var data = JSON.parse(res);
                    if( data.errors.length === 0 && data.html.length > 0){
                        var el = $('#tbpContentTable');
                        if ( !$.fn.dataTable.isDataTable( '#tbpContentTable' ) ) {
                            el.html(data.html);
                            initTable('tableContent');
                            tableContent.columns.adjust().draw();
                            $('input[name="settings[postids]"]').val(data.data['ids']);
                        }else{
                            tableContent.destroy();
                            el.html(data.html);
                            initTable('tableContent');
                            tableContent.columns.adjust().draw();
                            $('input[name="settings[postids]"]').val(data.data['ids']);
                        }
                        $('#tbpSortTableContent').show();
                    }
                }
            });

        });

        $(document.body).on('removeSelected', function (e) {
            e.preventDefault();
            tableContent.rows('.selected').remove().draw();
            saveContentIdsToInput();
        });

        $(document.body).on('click', '.chooseLoaderIcon', function (e) {
            e.preventDefault();
            chooseIconPopup();
        });


        //change Border color in preview and ajax save
        jQuery('.tbpColorObserver .wp-color-result').attr('id', 'wp-color-result-border');

        var observer = new MutationObserver(styleChangedCallback);
        observer.observe(document.getElementById('wp-color-result-border'), {
            attributes: true,
            attributeFilter: ['style'],
        });
        var oldIndex = document.getElementById('wp-color-result-border').style.backgroundColor;
        function styleChangedCallback(mutations) {
            var newIndex = mutations[0].target.style.backgroundColor;
            if (newIndex !== oldIndex) {
                jQuery('.supsystic-table-loader.spinner').css('background-color', newIndex);
                jQuery('.supsystic-table-loader').not('.spinner').css('color', newIndex);
                //jQuery('.ba-slider').beforeAfter();
            }
        }


        function chooseIconPopup() {

            var color = $('input[name="settings[table_loader_icon_color]"]').val();

            $(document.body).on('click', '#chooseIconPopup .item-inner', function (e) {
                e.preventDefault();
                var el = $(this)
                ,   name = el.find('.preicon_img').attr('data-name')
                ,   dataItems = el.find('.preicon_img').attr('data-items');

                $('input[name="settings[table_loader_icon_name]"]').val(name);
                $('input[name="settings[table_loader_icon_number]"]').val(dataItems);

                if(name === 'default'){
                    $('.tbpIconPreview').html('');
                    $('.tbpIconPreview').html('<div class="supsystic-table-loader spinner" style="background-color:'+color+'"></div>');
                }else{
                    $('.tbpIconPreview').html('');
                    var htmlIcon = ' <div class="supsystic-table-loader la-'+name+' la-2x" style="color: '+color+';">';
                    for(var i = 0; i<dataItems; i++){
                        htmlIcon += '<div></div>';
                    }
                    htmlIcon += '</div>';
                    $('.tbpIconPreview').html(htmlIcon);
                }

                $container.empty();
                $container.dialog('close');
            });

            var $container = jQuery('<div id="chooseIconPopup" style="display: none;" title="" /></div>').dialog({
                modal:    true
                ,	autoOpen: false
                ,	width: 900
                ,	height: 750
                ,	buttons:  {
                    OK: function() {

                        $container.empty();
                        $container.dialog('close');
                    }
                    ,	Cancel: function() {
                        $container.empty();
                        $container.dialog('close');
                    }
                }
            });

            var title = $('.chooseLoaderIcon').text();
            var loaderArray = {
                'timer': 1,
                'ball-beat': 3,
                'ball-circus': 5,
                'ball-atom': 4,
                'ball-spin-clockwise-fade-rotating': 8,
                'line-scale': 5,
                'ball-climbing-dot': 4,
                'square-jelly-box': 2,
                'ball-rotate': 1,
                'ball-clip-rotate-multiple': 2,
                'cube-transition': 2,
                'square-loader': 1,
                'ball-8bits': 16,
                'ball-newton-cradle': 4,
                'ball-pulse-rise': 5,
                'triangle-skew-spin': 1,
                'fire': 3,
                'ball-zig-zag-deflect': 2
            };
            var contentHtml = '<div class="items items-list">';

            contentHtml += '<div class="item">';
                contentHtml += '<div class="item-inner">';
                    contentHtml += '<div class="item-loader-container">';
                        contentHtml += '<div class="preicon_img" data-name="default" data-items="0" >';
                            contentHtml += '<div class="supsystic-table-loader spinner" style="background-color: '+color+';"></div>';
                        contentHtml += '</div>';
                    contentHtml += '</div>';
                contentHtml += '</div>';
                contentHtml += '<div class="item-title">default</div>';
            contentHtml += '</div>';

            for (var k in loaderArray){
                if (loaderArray.hasOwnProperty(k)) {
                    contentHtml += '<div class="item">';
                        contentHtml += '<div class="item-inner">';
                            contentHtml += '<div class="item-loader-container">';
                                contentHtml += '<div class="supsystic-table-loader la-'+k+' la-2x preicon_img" data-name="'+k+'" data-items="'+loaderArray[k]+'" style="color: '+color+';">';
                                    for(var i=0; i < loaderArray[k]; i++){
                                        contentHtml += '<div></div>';
                                    }
                                contentHtml += '</div>';
                            contentHtml += '</div>';
                        contentHtml += '</div>';
                        contentHtml += '<div class="item-title">'+k+'</div>';
                    contentHtml += '</div>';

                }
            }
            contentHtml += '<div style="clear: both;"></div>';
            contentHtml += '</div>';



            $container.append(contentHtml);

            $container.dialog( "option", "title", title );
            $container.dialog('open');
            return false;

        }

		// Initialize Main Tabs
		var $mainTabsContent = $('.row-tab'),
			$mainTabs = $('.tbpSub.tabs-wrapper.tbpMainTabs .button'),
			$currentTab = $mainTabs.filter('.current').attr('href');
		
		$mainTabsContent.filter($currentTab).addClass('active');
		
		$mainTabs.on('click', function (e) {
			e.preventDefault();
			var $this = $(this),
				$curTab = $this.attr('href');
			
			$mainTabsContent.removeClass('active');
			$mainTabs.filter('.current').removeClass('current');
			$this.addClass('current');
			$mainTabsContent.filter($curTab).addClass('active');
		});

        // Initialize Settings Tabs
        var $settingsTabsContent = $('.row-settings-tab'),
            $settingsTabs = $('.tabs-settings .tbpSub.tabs-wrapper .button'),
            $currentSettingsTab = $settingsTabs.filter('.current').attr('href');

        $settingsTabsContent.filter($currentSettingsTab).addClass('active');

        $settingsTabs.on('click', function (e) {
            e.preventDefault();
            var $this = $(this),
                $curTab = $this.attr('href');

            $settingsTabsContent.removeClass('active');
            $settingsTabs.filter('.current').removeClass('current');
            $this.addClass('current');
            $settingsTabsContent.filter($curTab).addClass('active');
        });

		//Replace search content type
		jQuery('.tbpMenu input').on('ifChecked',function(){
			var el = jQuery(this)
				,   searchType = el.attr('data-search');
			
			var data ={
				mod:'tablepress',
				action:'loadPost',
				type: searchType,
				pl:'tbp',
				reqType:"ajax",
			};
			jQuery.ajax({
				url: url,
				data: data,
				type: 'POST',
				success: function(res) {
					var data = JSON.parse(res);
					if( data.errors.length === 0 && data.html.length > 0){
							var el = $('#tbpSearchTable');
						if ( !$.fn.dataTable.isDataTable( '#tbpSearchTable' ) ) {
							el.html(data.html);
                            initTable('tableSearch');
						}else{
                            tableSearch.destroy();
							el.html(data.html);
                            initTable('tableSearch');
						}
					}
				}
			});
		});

        jQuery('.tbpMenu input').on('changeSearchContent',function(){
            var el = jQuery(this)
                ,   searchType = el.attr('data-search');
            var data ={
                mod:'tablepress',
                action:'loadPost',
                type: searchType,
                pl:'tbp',
                reqType:"ajax",
            };
            jQuery.ajax({
                url: url,
                data: data,
                type: 'POST',
                success: function(res) {
                    var data = JSON.parse(res);
                    if( data.errors.length === 0 && data.html.length > 0){
                        var el = $('#tbpSearchTable');
                        if ( !$.fn.dataTable.isDataTable( '#tbpSearchTable' ) ) {
                            el.html(data.html);
                            initTable('tableSearch');
                        }else{
                            tableSearch.destroy();
                            el.html(data.html);
                            initTable('tableSearch');
                        }
                    }
                }
            });
        });
        jQuery('.tbpMenu input').on('ifChecked',function(){
            $(document.body).trigger('changeSearchContent');
        });
        jQuery('.tbpMenu input').on('click',function(){
            var el = jQuery(this)
                ,   searchType = el.attr('data-search');
            var data ={
                mod:'tablepress',
                action:'loadPost',
                type: searchType,
                pl:'tbp',
                reqType:"ajax",
            };
            jQuery.ajax({
                url: url,
                data: data,
                type: 'POST',
                success: function(res) {
                    var data = JSON.parse(res);
                    if( data.errors.length === 0 && data.html.length > 0){
                        var el = $('#tbpSearchTable');
                        if ( !$.fn.dataTable.isDataTable( '#tbpSearchTable' ) ) {
                            el.html(data.html);
                            initTable('tableSearch');
                        }else{
                            tableSearch.destroy();
                            el.html(data.html);
                            initTable('tableSearch');
                        }
                    }
                }
            });
        });

		//after load page get post table
        var data ={
            mod:'tablepress',
            action:'loadPost',
            type: 'post',
            pl:'tbp',
            reqType:"ajax",
        };
		jQuery.ajax({
			url: url,
			data: data,
			type: 'POST',
			success: function(res) {
				var data = JSON.parse(res);
				if( data.errors.length === 0 && data.html.length > 0){
                    $('#tbpSearchTable').html(data.html);
                    initTable('tableSearch');
				}
			}
		});

        $(document.body).on('reloadContentTable', function(){
            //if exist post id show them in second tables
            if($('input[name="settings[postids]"]').val().length){
                var postIdsStr = $('input[name="settings[postids]"]').val();
                var orders = $('#tbpTablePressEditForm input[name="settings[order]"]').val();
                orders = orders.split(',');
                var tableId = $("#tbpTablePressEditForm").attr('data-table-id');
                if(!tableId){
                    tableId = 0;
                }
                var data ={
                    mod:'tablepress',
                    action:'getPostContent',
                    postIdExist: postIdsStr,
                    order: orders,
                    tableid: tableId,
                    pl:'tbp',
                    reqType:"ajax",
                };

                jQuery.ajax({
                    url: url,
                    data: data,
                    type: 'POST',
                    success: function(res) {
                        var data = JSON.parse(res);
                        if( data.errors.length === 0 && data.html.length > 0){
                            var el = $('#tbpContentTable');
                            if ( !$.fn.dataTable.isDataTable( '#tbpContentTable' ) ) {
                                el.html(data.html);
                                initTable('tableContent');
                            }else{
                                tableContent.destroy();
                                el.html(data.html);
                                initTable('tableContent');
                            }
                            $('#tbpSortTableContent').show();
                        }
                    }
                });
            }else{
                $('#tbpSortTableContent').hide();
            }
        });

        $(document.body).on('click', '.tbpPreviewShow', function(e){
            e.preventDefault();
            $('.tbpAdminPreviewNotice').addClass('tbpHidden');
            $('#loadingProgress').removeClass('tbpHidden');
            $('#buttonSave').trigger('click');

            setTimeout(function() {
                if($('input[name="settings[postids]"]').val().length){
                    var postIdsStr = $('input[name="settings[postids]"]').val();
                    var orders = $('#tbpTablePressEditForm input[name="settings[order]"]').val();
                    orders = orders.split(',');
                    var tableId = $("#tbpTablePressEditForm").attr('data-table-id');
                    if(!tableId){
                        tableId = 0;
                    }
                    var data ={
                        mod:'tablepress',
                        action:'getPostContent',
                        postIdExist: postIdsStr,
                        order: orders,
                        tableid: tableId,
                        frontend: true,
                        prewiew: true,
                        pl:'tbp',
                        reqType:"ajax",
                    };
                    var request = jQuery.ajax({
                        url: url,
                        data: data,
                        type: 'POST',
                    });

                    request.done(function( res ) {
                        var data = JSON.parse(res);
                        if( data.errors.length === 0 && data.html.length > 0){

                            var el = $('#tbpPreviewTable')
                                ,   tableWrapper = $('#row-tab-preview .tbpTableWrapper')
                                ,   settings = data.data['settings'];
                            if (  tablePreview !== null && typeof tablePreview === 'object'  ) {
                                tablePreview.destroy();
                                $('#tbp-table-wrapper-1').find('*').not('#tbpPreviewTable').remove();
                                el.html(data.html);
                                tablePreview = app.Tablepress.initializeTable(tableWrapper, '', function(){}, settings);
                                $('#tbp-table-wrapper-1 .tbpLoader').addClass('tbpHidden');
                                $('.tbpAdminPreviewNotice').addClass('tbpHidden');
                                $('#loadingFinished').removeClass('tbpHidden');
                                tablePreview.columns.adjust().draw();
                            } else {
                                el.html(data.html);
                                tablePreview = app.Tablepress.initializeTable(tableWrapper, '', function(){}, settings);
                                tableWrapper.find('.tbpLoader').addClass('tbpHidden');
                                $('.tbpAdminPreviewNotice').addClass('tbpHidden');
                                $('#loadingFinished').removeClass('tbpHidden');
                                tablePreview.columns.adjust().draw();
                            }
                            //$('#tbpPreviewTable').show();
                        }
                    });

                    request.fail(function( jqXHR, textStatus ) {
                        console.log( "Request failed: " + textStatus );
                    });

                }else{
                    $('.tbpAdminPreviewNotice').addClass('tbpHidden');
                    $('#loadingEmpty').removeClass('tbpHidden');
                    $('#tbpPreviewTable').hide();
                }
            }, 1000);




        });
        $(document.body).on('click', '.tbpContentTab', function(e){
            if ( $.fn.dataTable.isDataTable( '#tbpContentTable' ) ) {
                tableContent.draw()
            }
        });

        $(document.body).trigger('reloadContentTable');

        $(document.body).on('click', '#buttonSave', function(e){
            e.preventDefault();
            $('#tbpTablePressEditForm').trigger('submit');
        });

        function saveContentIdsToInput(){
            if(tableContent){
                var contentData = tableContent.rows().data().toArray();
                var postids = [];
                contentData.forEach(function(row, i) {
                    row.forEach(function(column, j) {
                        //get only id value
                        if(j === 0){
                            var html = $.parseHTML( column )
                                ,   id = $(html).attr('data-id');

                            postids.push(id);
                        }
                    });
                });
                $('input[name="settings[postids]"]').val(postids);
            }
        }

        $('#tbpTablePressEditForm').submit(function(e){
            e.preventDefault();

            saveContentIdsToInput();

            jQuery(this).sendFormTbp({
                btn: jQuery('#buttonSave')
                ,	onSuccess: function(res) {
                    var currentUrl = window.location.href;
                    if(!res.error && res.data.edit_link && currentUrl !== res.data.edit_link) {
                        toeRedirect( res.data.edit_link );
                    }
                    jQuery('.icsComparisonSaveBtn i').attr('class', 'fa fa-check');
                }
            });
            return false;

        });

        $(document.body).on('click', '#buttonDelete', function(e){
            e.preventDefault();
            var id = $('#tbpTablePressEditForm').attr('data-table-id');

            if(id){
                var data ={
                    mod:'tablepress',
                    action:'deleteByID',
                    id: id,
                    pl:'tbp',
                    reqType:"ajax"
                };
                jQuery.ajax({
                    url: url,
                    data: data,
                    type: 'POST',
                    success: function(res) {
                        var redirectUrl = $('#tbpTablePressEditForm').attr('data-href');
                        if(!res.error) {
                            toeRedirect( redirectUrl );
                        }
                    }
                });
            }
        });

        $('input[name="settings[caption_enable]"]').on('change', function(){
            if($(this).is(':checked')){
                $('#tbpCaptionText').removeClass('tbpHidden');
            }else{
                $('#tbpCaptionText').addClass('tbpHidden');
            }
        });
        $('input[name="settings[description_enable]"]').on('change', function(){
            if($(this).is(':checked')){
                $('#tbpDescriptionText').removeClass('tbpHidden');
            }else{
                $('#tbpDescriptionText').addClass('tbpHidden');
            }
        });
        $('input[name="settings[signature_enable]"]').on('change', function(){
            if($(this).is(':checked')){
                $('#tbpSignatureText').removeClass('tbpHidden');
            }else{
                $('#tbpSignatureText').addClass('tbpHidden');
            }
        });
        $('input[name="settings[auto_width]"]').on('change', function(){
            if($(this).is(':checked')){
                $('#tbpFixedTableWidthText').addClass('tbpVisibilityHidden');
            }else{
                $('#tbpFixedTableWidthText').removeClass('tbpVisibilityHidden');
            }
        });

        $('input[name="settings[hide_table_loader]"]').on('change', function(){
            if($(this).is(':checked')){
                $('.tbpLoader').addClass('tbpHidden');
            }else{
                $('.tbpLoader').removeClass('tbpHidden');
            }
        });
	});

    //-- Work with Show columns --//

    function changeOrderPosition(){
        // help disabled multiple request for server
        if(tableContentReloading){
            clearTimeout( tableContentReloading );
        }
        var inputs = '';
        $(".tbpCheckColumns input:checked").each(function() {
            inputs += $(this).val() + ',';
        });
        inputs = inputs.slice(0, -1); // remove last char ','
        $('input[name="settings[order]"]').val(inputs);

        tableContentReloading = setTimeout(function() {
            $(document.body).trigger('reloadContentTable');
            tableContentReloading = false;
        }, 2000);
    }

    $('.tbpCheckColumns').on('click', 'label input', function(){
        changeOrderPosition();
    });

    $(".tbpCheckColumns").sortable({
        axis: "x",
        cursor: "move",
        stop: changeOrderPosition
    });

    //-- End work with Show columns --//

    //-- Work with shortcode copy text --//
	$('#tbpCopyTextCodeExamples').on('change', function(e){
	   var optName = $(this).val();
	   switch (optName){
           case 'shortcode' :
               $('.tbpCopyTextCodeShowBlock').hide();
               $('.tbpCopyTextCodeShowBlock.shortcode').show();
               break;
           case 'phpcode' :
               $('.tbpCopyTextCodeShowBlock').hide();
               $('.tbpCopyTextCodeShowBlock.phpcode').show();
               break;
       }
    });
    //-- Work with shortcode copy text --//

	//-- Work with title --//
    $('#tbpTableTitleShell').on('click', function(){
        $('#tbpTableTitleLabel').hide();
        $('#tbpTableTitleTxt').show();
    });

    $('#tbpTableTitleTxt').on('focusout', function(){
        var tableTitle = $(this).val();
        $('#tbpTableTitleLabel').text(tableTitle);
        $('#tbpTableTitleTxt').hide();
        $('#tbpTableTitleLabel').show();
        $('#buttonSave').trigger('click');
    });
    //-- Work with title --//

}(window.jQuery, window.supsystic));
