(function ($) {
    "use strict";
    $(document).ready(function () {
        $('[data-hook="buyblo-box"]').each(function () {
            var loaded = $(this).attr('data-loaded');
            if (typeof loaded !== 'undefined' && loaded == "true") {
                setParametersHeight($(this));
                return;
            }

            loadAjaxBuyBloBox($(this));
        });
    });

    var loadAjaxBuyBloBox = function (buyBloBox) {
        var postData = {
            action: 'get_buyblo_box',
            post_id: buyBloBox.attr('data-post-id'),
            group: buyBloBox.attr('data-group'),
            template: buyBloBox.attr('data-template')
        };

        var classes = buyBloBox.attr('data-classes');
        if (typeof classes !== 'undefined') {
            postData['classes'] = classes;
        }

        jQuery.post(buyblo_box_ajax_object.ajax_url, postData, function (response) {
            if (response.error) {
                buyBloBox.html('<!-- ' + response.error + ' -->');
            } else if (response.box) {
                buyBloBox.html(response.box);
                setParametersHeight(buyBloBox);
                buyBloBox.show();
            }
        }).fail(function () {
            buyBloBox.html('<!-- BuyBlo Box Error: Internal Error (ajax) -->');
        });
    };

    var animationBlocked = false;

    function productsSlider(widget, direction) {
        if (!animationBlocked) {
            animationBlocked = true;
            var productsContainer = widget.find('.buyblo-box-product-list'),
                productWidth = productsContainer.find('.buyblo-box-group-product').outerWidth(),
                idVisibleElement = parseInt(widget.attr('data-widget-visible-nr')),
                animationSpeed = 200,
                maxProducts = 4;

            if (direction === "next") {
                if (idVisibleElement >= 1 && idVisibleElement < maxProducts) {
                    productsContainer.animate({
                        marginLeft: '-=' + productWidth + 'px'
                    }, animationSpeed, function () {
                        idVisibleElement++;
                        widget.attr('data-widget-visible-nr', idVisibleElement);
                        animationBlocked = false;
                    });
                } else {
                    animationBlocked = false;
                }

            } else if (direction === "prev") {
                if (idVisibleElement > 1 && idVisibleElement <= maxProducts) {
                    productsContainer.animate({
                        marginLeft: '+=' + productWidth + 'px'
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
    }

    $(document).on('click', '.buyblo-navigation-right', function () {
        productsSlider($(this).closest('.buyblo-product-widget'), "next");
    });

    $(document).on('click', '.buyblo-navigation-left', function () {
        productsSlider($(this).closest('.buyblo-product-widget'), "prev");
    });

    function setParametersHeight(container) {
        var groups = container.find('.buyblo-boxes-group');

        groups.each(function () {
            var products = $(this).find('.buyblo-box-group-product');

            var ulList = [];
            products.each(function () {
                var parameters = $(this).find('.buyblo-box-product-parameters ul li');

                parameters.each(function (index) {
                    var liHeight = parseInt($(this).outerHeight());
                    if (ulList[index]) {
                        if (ulList[index] < liHeight) {
                            ulList[index] = liHeight;
                        }
                    } else {
                        ulList.push(liHeight);
                    }
                });
            });

            products.each(function () {
                var parameters = $(this).find('.buyblo-box-product-parameters ul li');
                parameters.each(function (index) {
                    $(this).height(ulList[index]);
                });
            });
        });
    }
}(jQuery));