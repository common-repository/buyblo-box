var BuyBloMetaBox = (function ($, window, document) {
    var init = function () {
        AccountPostProductsSearch.init(false);
        AccountPostProductsGroups.init(false);
    };

    var initHelp = function () {
        $('#buyblo_admin_help_advanced_toggle').click(function (e) {
            e.preventDefault();
            $('#buyblo_admin_help_advanced').toggle();
        });
    };

    return {
        init: init,
        initHelp: initHelp
    }
})(jQuery, window, document);
