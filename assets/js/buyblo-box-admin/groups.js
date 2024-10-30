var AccountPostProductsGroups = (function ($, window, document, appGroupsPort) {
    var loader;
    var selector = appGroupsPort.getSelector();
    var groups = {};

    var init = function (renderGroupsOnInit) {
        appGroupsPort.init();
        loader = appGroupsPort.getLoader();
        groups = appGroupsPort.getGroupsJson();

        if (typeof renderGroupsOnInit === 'undefined') {
            renderGroupsOnInit = true;
        }

        if (renderGroupsOnInit) {
            renderGroups();
        } else {
            initLoadedGroups();
        }
    };

    var renderGroups = function () {
        loader.show();
        AccountPostProductsSearch.getLoader().show();

        appGroupsPort.ajaxGetGroups(
            JSON.stringify(groups),
            function (response) {
                $(selector.groupsContainer).html(response.groupsHtml);
                initLoadedGroups();
                loader.hide();
                AccountPostProductsSearch.getLoader().hide();
            }
        );
    };

    var initLoadedGroups = function () {
        appGroupsPort.reInitGroups();
    };

    var getGroups = function () {
        return groups;
    };

    var countGroups = function () {
        var count = 0;
        for (var categoryId in getGroups()) {
            if (groups.hasOwnProperty(categoryId)) {
                count++;
            }
        }
        return count;
    };

    var countGroup = function (categoryId) {
        if (typeof groups[categoryId] !== 'undefined') {
            return groups[categoryId].length;
        } else {
            return 0;
        }
    };

    var addToGroup = function (productId, categoryId) {
        if (typeof groups[categoryId] === 'undefined') {
            if (countGroups() >= 3) {
                appGroupsPort.showMessage('danger', "Zdefiniowano już 3 grupy.");
                return false;
            }
            groups[categoryId] = [];
        }

        if (groups[categoryId].length >= 4) {
            appGroupsPort.showMessage('danger', "Zdefiniowano już 4 produkty w grupie.");
            return false;
        }
        groups[categoryId].push(productId);
        groups[categoryId] = arrayUnique(groups[categoryId]);
        temporarySaveGroups();
        renderGroups();
        AccountPostProductsSearch.updateProductsStatus();
    };

    var removeFromGroup = function (productId) {
        for (var categoryId in groups) {
            var group = groups[categoryId];
            var index = group.indexOf(productId);
            if (index >= 0) {
                group.splice(index, 1);
            }
            if (group.length === 0) {
                delete groups[categoryId]
            }
        }

        temporarySaveGroups();
        renderGroups();
        AccountPostProductsSearch.updateProductsStatus();
    };

    var isInGroups = function (productId) {
        for (var categoryId in getGroups()) {
            var group = groups[categoryId];
            var index = group.indexOf(productId);
            if (index >= 0) {
                return true;
            }
        }

        return false;
    };

    var groupAdded = function (categoryId) {
        return (typeof groups[categoryId] !== 'undefined');
    };

    var temporarySaveGroups = function () {
        appGroupsPort.setGroupsJson(groups);
    };

    var arrayUnique = function (array) {
        return $.grep(array, function (el, index) {
            return index === $.inArray(el, array);
        });
    };

    return {
        init: init,
        addToGroup: addToGroup,
        removeFromGroup: removeFromGroup,
        countGroups: countGroups,
        getGroups: getGroups,
        isInGroups: isInGroups,
        groupAdded: groupAdded,
        countGroup: countGroup
    };
})(jQuery, window, document, AccountPostProductsGroupsAppPort);