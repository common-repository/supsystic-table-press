(function ($, app) {
    $(document).ready(function () {

        $('.tbpTableWrapper').each(function( ) {
            var tableWrapper = $(this);
            app.Tablepress.initializeTable(tableWrapper, '', function(){
                tableWrapper.removeClass('tbpVisibilityHidden');
                tableWrapper.find('.tbpLoader').addClass('tbpHidden');
            });
        });

    });

}(window.jQuery, window.supsystic));