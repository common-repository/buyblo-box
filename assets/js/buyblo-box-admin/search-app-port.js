var AccountPostProductsSearchAppPort = (function ($, window, document) {
    var loader;

    var selector = {
        mainContainer: '#buyblo-box-products-search-content',
        input: '.buyblo-search-input',
        inputSpecClass: '.buyblo-filters-box',
        inputField: '.buyblo_input_field',
        productList: '#ProductList',
        prices: '#buyblo_filter_prices',
        pricesMin: '.buyblo_min_price',
        pricesMax: '.buyblo_max_price',
        shopStart: '#buyblo_filter_shop_start',
        shopStartClass: '.buyblo_filter_shop_start',
        producerStart: '#buyblo_filter_producer_start',
        producerStartClass: '.buyblo_filter_producer_start',
        categoryStart: '#buyblo_filter_category_start',
        searchSection: '.buyblo_search_form',
        searchStart: '#buyblo_filter_search_start',
        searchFull: '#buyblo_filter_search',
        foundProduct: '.buyblo-search-product',
        activeCategory: '.buyblo_active_category',
        activeCategoryText: '.buyblo_category_label',
        results: '.buyblo_results_list',
        resultMulti: 'buyblo_can_be_multi',
        hiddenResult: '.buyblo-hidden-list-element',
        listLabel: '.buyblo_list_label',
        filters: '.buyblo_filters',
        filter: '.buyblo_filter',
        closeFilter: '.buyblo_close_filter',
        activeFilter: '.buyblo_selected_filter',
        productBlocked: 'buyblo-prod-blocked',
        productTooManyCat: 'buyblo-too-many-categories',
        productTooMuch: 'buyblo-too-much-products',
        productVisible: 'buyblo-prod-visible',
        productAdded: 'buyblo-prod-added',
        actionRemove: '.buyblo_remove',
        productNotSelected: 'buyblo-prod-none',
        productActions: '.buyblo-box-settings',
        productActionsBtn: '.buyblo-box-action-btn'
    };

    var text = {
        searchLoading: 'Trwa szukanie...',
        searchLabel: 'Wpisz 2 lub więcej znaków',
        searchNotFound: 'Nie znaleziono wyników'
    };

    var init = function () {
        loader = $('.buyblo-wordpress .buyblo-loader');
        reInitSearchProducts();
    };

    var getLoader = function () {
        return loader;
    };

    var getSelector = function () {
        return selector;
    };

    var getText = function () {
        return text;
    };

    var ajaxSearchShops = function (filterPrefix, successCallback) {
        var data = {
            action: 'buyblo_box_shops_search',
            filterPrefix: filterPrefix
        };

        return $.ajax({
            url: buyblo_box_ajax_object.ajax_url,
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            dataType: 'json',
            method: 'post',
            data: data,
            success: successCallback
        });
    };

    var ajaxSearchProducers = function (filterPrefix, successCallback) {
        var data = {
            action: 'buyblo_box_producers_search',
            filterPrefix: filterPrefix
        };

        return $.ajax({
            url: buyblo_box_ajax_object.ajax_url,
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            dataType: 'json',
            method: 'post',
            data: data,
            success: successCallback
        });
    };

    var ajaxSearchProducts = function (filterUrl, groups, successCallback) {
        var data = {
            action: 'buyblo_box_products_search',
            filterUrl: filterUrl,
            groupsJson: JSON.stringify(groups)
        };

        return $.ajax({
            url: buyblo_box_ajax_object.ajax_url,
            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
            dataType: 'json',
            method: 'post',
            data: data,
            success: successCallback
        });
    };

    var reInitSearchProducts = function () {
        initProductsList();
    };

    var initProductsList = function () {

        var simpleSlider = (function () {
            var animationBlocked = false,
                animationSpeed = 600,
                visibleInPage = 5,
                productPadding = 0,
                activePage = 1,
                widget,
                productsContainer,
                productWidth,
                idVisibleElement,
                productsLength,
                maxProducts,
                btnPrev,
                btnNext,
                activePagePagin,
                maxPagePagin,

                setVaribles = function (widgetBlock) {
                    widget = widgetBlock;
                    productsContainer = widget.find('.buyblo-box-product-list');
                    productWidth = productsContainer.find('.buyblo-box-group-product').outerWidth();
                    idVisibleElement = parseInt(widget.attr('data-widget-visible-nr'));
                    productsLength = productsContainer.find('.buyblo-search-product').length;
                    maxProducts = Math.ceil(productsLength / visibleInPage);
                    btnPrev = $('.buyblo-navigation-prev');
                    btnNext = $('.buyblo-navigation-next');
                    activePagePagin = $('#activePagePagin');
                    maxPagePagin = $('#maxPagePagin');
                },

                updatePagesNav = function () {
                    btnPrev.add(btnNext).show();
                    activePagePagin.html(activePage);
                    maxPagePagin.html(maxProducts);

                    if (activePage === 1) {
                        btnPrev.hide();
                    }
                    if (activePage === maxProducts) {
                        btnNext.hide();
                    }
                },

                productsSlider = function (direction) {
                    if (!animationBlocked) {
                        animationBlocked = true;

                        if (direction === "next") {
                            if (activePage >= 1 && activePage < maxProducts) {
                                activePage++;
                                updatePagesNav();

                                productsContainer.animate({
                                    marginLeft: '-=' + (productWidth * visibleInPage + (visibleInPage * productPadding)) + 'px'
                                }, animationSpeed, function () {
                                    idVisibleElement++;
                                    widget.attr('data-widget-visible-nr', idVisibleElement);
                                    animationBlocked = false;
                                });
                            } else {
                                animationBlocked = false;
                            }

                        } else if (direction === "prev") {
                            if (activePage > 1 && activePage <= maxProducts) {
                                activePage--;
                                updatePagesNav();

                                productsContainer.animate({
                                    marginLeft: '+=' + (productWidth * visibleInPage + (visibleInPage * productPadding)) + 'px'
                                }, animationSpeed, function () {
                                    idVisibleElement--;
                                    widget.attr('data-widget-visible-nr', idVisibleElement);
                                    animationBlocked = false;
                                });
                            } else {
                                animationBlocked = false;
                            }
                        }
                    }
                },

                actionsClickNav = function () {
                    btnNext.click(function () {
                        productsSlider("next");
                    });
                    btnPrev.click(function () {
                        productsSlider("prev");
                    });
                },

                init = function (widgetBlock) {
                    setVaribles(widgetBlock);
                    updatePagesNav();
                    actionsClickNav();
                };

            return {
                init: init
            }
        })();

        simpleSlider.init($('.buyblo-wordpress .buyblo-product-widget'));
    };

    return {
        init: init,
        getLoader: getLoader,
        ajaxSearchShops: ajaxSearchShops,
        ajaxSearchProducers: ajaxSearchProducers,
        ajaxSearchProducts: ajaxSearchProducts,
        reInitSearchProducts: reInitSearchProducts,
        getSelector: getSelector,
        getText: getText
    }
})(jQuery, window, document);