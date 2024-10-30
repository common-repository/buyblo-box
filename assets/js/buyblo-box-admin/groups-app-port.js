var AccountPostProductsGroupsAppPort = (function ($, window, document) {
    var loader;

    var selector = {
        groupsContainer: '#buyblo-box-groups',
        groupsProductsJsonInput: '[name="buyblo_box_groups"]'
    };

    var init = function () {
        loader = $('#buyblo-groups-container .buyblo-loader');
    };

    var getLoader = function () {
        return loader;
    };

    var getSelector = function () {
        return selector;
    };

    var showMessage = function (type, message) {
        alert(message);
    };

    var ajaxGetGroups = function (groupsJson, callback) {
        var data = {
            action: 'buyblo_box_groups',
            groupsJson: groupsJson
        };

        $.ajax({
            url: buyblo_box_ajax_object.ajax_url,
            type: 'post',
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            dataType: 'json',
            data: data,
            success: callback
        });
    };

    var reInitGroups = function () {
        initGroupsProducts();
    };

    var initGroupsProducts = function () {
        $(selector.groupsContainer).find('.buyblo-box-action-btn span').click(function () {
            var productBox = $(this).closest('.buyblo-box-group-product');
            switch ($(this).data("action")) {
                case "add":
                    AccountPostProductsGroups.addToGroup(productBox.data('product-id'), productBox.data('category-id'));
                    break;
                case "remove":
                    AccountPostProductsGroups.removeFromGroup(productBox.data('product-id'));
                    break;
            }
        });
    };

    var getGroupsJson = function () {
        var groups = $(selector.groupsProductsJsonInput).val();
        if (groups && groups !== '[]') {
            groups = JSON.parse(groups);
        } else {
            groups = {};
        }

        return groups;
    };

    var setGroupsJson = function (groups) {
        $(selector.groupsProductsJsonInput).val(JSON.stringify(groups)).trigger('change');
    };

    return {
        init: init,
        getLoader: getLoader,
        getSelector: getSelector,
        reInitGroups: reInitGroups,
        ajaxGetGroups: ajaxGetGroups,
        getGroupsJson: getGroupsJson,
        setGroupsJson: setGroupsJson,
        showMessage: showMessage
    }
})(jQuery, window, document);
