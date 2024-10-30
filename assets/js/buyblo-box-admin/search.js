var AccountPostProductsSearch = (function ($, window, document, appSearchPort) {
    var loader;
    var selector = appSearchPort.getSelector();
    var text = appSearchPort.getText();
    var lastLoadedFilterUrl = '/';
    var xhrRequest;

    var init = function (renderSearchProductsOnInit) {
        appSearchPort.init();
        loader = appSearchPort.getLoader();

        if (typeof renderSearchProductsOnInit === 'undefined') {
            renderSearchProductsOnInit = true;
        }

        if (renderSearchProductsOnInit) {
            searchProducts('/');
        } else {
            initLoadedSearchProducts();
        }
    };

    var getLoader = function () {
        return loader;
    };

    var searchShops = function (filterPrefix) {
        if (xhrRequest) {
            xhrRequest.abort();
        }

        xhrRequest = appSearchPort.ajaxSearchShops(filterPrefix, function (response) {
            searchResponse(response, $(selector.shopStart + ' ' + selector.listLabel), $(selector.shopStartClass));
        });
    };

    var searchProducers = function (filterPrefix) {
        if (xhrRequest) {
            xhrRequest.abort();
        }

        xhrRequest = appSearchPort.ajaxSearchProducers(filterPrefix, function (response) {
            searchResponse(response, $(selector.producerStart + ' ' + selector.listLabel), $(selector.producerStartClass));
        });
    };

    var searchProducts = function (filterUrl) {
        if (filterUrl) {
            loader.show();
            filterUrl = prepareFilterUrl(filterUrl);

            appSearchPort.ajaxSearchProducts(filterUrl, AccountPostProductsGroups.getGroups(), function (response) {
                lastLoadedFilterUrl = filterUrl;
                $(selector.mainContainer).html(response.productsHtml);
                initLoadedSearchProducts();
                loader.hide();
            });
        }
    };

    var initLoadedSearchProducts = function () {
        appSearchPort.reInitSearchProducts();
        initInputActions([$(selector.categoryStart), $(selector.producerStart), $(selector.shopStart), $(selector.input + selector.inputSpecClass)]);
        initSubmitBtn();
        initFilterPrice();
        initProductsActions();
        initProductsSort();
        updateProductsStatus();
    };

    var updateProductsStatus = function () {
        $(selector.productList).find(selector.foundProduct).each(function () {
            var box = $(this).find(selector.productActions),
                categoryId = $(this).data('category-id'),
                productId = $(this).data('product-id');

            box.removeClass(selector.productBlocked + ' ' + selector.productTooManyCat + ' ' + selector.productTooMuch);

            if (AccountPostProductsGroups.isInGroups(productId)) {
                box.addClass(selector.productVisible + ' ' + selector.productAdded).removeClass(selector.productNotSelected);
            } else {
                box.removeClass(selector.productVisible + ' ' + selector.productAdded).addClass(selector.productNotSelected);

                if (!AccountPostProductsGroups.groupAdded(categoryId)) {
                    if (AccountPostProductsGroups.countGroups() >= 3) {
                        box.addClass(selector.productBlocked + ' ' + selector.productTooManyCat);
                    }
                } else {
                    if (AccountPostProductsGroups.countGroup(categoryId) === 4) {
                        box.addClass(selector.productBlocked + ' ' + selector.productTooMuch);
                    }
                }
            }
        })
    };

    var prepareFilterUrl = function (filterUrl) {
        if (filterUrl) {
            if (filterUrl.search(/^\/?--/) >= 0) {
                // tylko sortowanie, niedozwolone przez api (np. odklik ze sklepu z sortowaniem)
                filterUrl = '/';
            } else if (filterUrl.search(/^\/?produkt:$/) >= 0) {
                // pusta fraza bez kategorii (np. odklik z globalego filtra na cene)
                filterUrl = '/';
            }
        } else {
            filterUrl = '/';
        }
        return filterUrl;
    };

    var initFilterPrice = function () {
        $(selector.prices).find(selector.pricesMin).add(selector.pricesMax)
            .focusout(priceFilterHandler)
            .keypress(function (e) {
                if (e.which === 13) { // enter key
                    priceFilterHandler();
                    e.preventDefault();
                }
            });
    };

    var priceFilterHandler = function () {
        var valueFrom = parseRangeValue($(selector.pricesMin).val());
        var valueTo = parseRangeValue($(selector.pricesMax).val());
        var url = '';
        if (valueFrom || valueTo) {
            var template = $(selector.prices).attr('data-price-url-in-template');
            url = template.replace('%s', valueFrom + '~' + valueTo);
        } else {
            url = $(selector.prices).attr('data-price-url-out');
        }

        searchProducts(url);
    };

    var parseRangeValue = function (inputValue) {
        var value = parseFloat(inputValue);
        return value ? value : '';
    };

    var initSubmitBtn = function () {
        var searchSection = $(selector.searchSection);

        searchSection.find("[type='search']").keypress(function (e) {
            if (e.which === 13) { // enter key
                e.preventDefault();
                e.stopPropagation();
                searchPhraseHandler();
            }
        });

        searchSection.find("[type='submit']").click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            searchPhraseHandler();
        });
    };

    var initProductsSort = function () {
        $('#dropdownSort').click(function () {
            if ($('#ProductsSort').hasClass('buyblo-hidden')) {
                $('#ProductsSort').slideDown(400, function () {
                    $(this).removeClass('buyblo-hidden');
                });
            } else {
                $('#ProductsSort').slideUp(400, function () {
                    $(this).addClass('buyblo-hidden');
                });
            }
        });

        $('#ProductsSort li').click(function () {
            searchProducts($(this).data('value'));
        });
    };

    var searchPhraseHandler = function () {
        var searchSection = $(selector.searchSection);
        var searchInput = searchSection.find("[type='search']");
        var searchFullFieldSet = searchInput.closest('fieldset[data-phrase-url-in-template]');
        var phrase = searchInput.val();
        var url = '';

        if (searchFullFieldSet.length) {
            if (phrase) {
                var template = searchFullFieldSet.attr('data-phrase-url-in-template');
                url = template.replace('%s', encodeURIComponent(phrase));
            } else {
                url = searchFullFieldSet.attr('data-phrase-url-out');
            }
        }
        else if (phrase) {
            url = 'produkt:' + encodeURIComponent(phrase) + '.html';
        }
        searchProducts(url);
    };

    var searchResponse = function (response, listLebel, list) {
        if (typeof response.options !== "undefined" && response.options.length) {
            listLebel.hide();
            list.empty();
            $.each(response.options, function (key, data) {
                list.append('<li data-value="' + data.id + '">' + data.text + '</li>');
            });
        } else {
            list.empty();
            listLebel.html(text.searchNotFound).show();
        }
    };

    var initInputActions = function (arrElements) {
        $.each(arrElements, function (key, element) {
            if (element.length) {
                initActionSearch(element);
                initActionClick(element);
                initActionRemove(element);
                initFocusInOut(element);
            }
        });
    };

    var initActionSearch = function (element) {
        if (element.attr('id') !== selector.producerStart.replace('#', '') && element.attr('id') !== selector.shopStart.replace('#', '')) {
            simpleSearch(element);
        } else {
            ajaxSearch(element);
        }
    };

    var ajaxSearch = function (element) {
        var label = element.find(selector.listLabel);
        element.find(selector.inputField).on('keyup', function (e) {
            var value = $(this).val();

            if (value.length >= 2) {
                label.html(text.searchLoading).show();

                switch (element.attr('id')) {
                    case selector.producerStart.replace('#', '') :
                        searchProducers(value);
                        break;
                    case selector.shopStart.replace('#', '') :
                        searchShops(value);
                        break;
                }

            } else {
                label.html(text.searchLabel).show();
                element.find(selector.results + ' ul').empty();
            }

        });
    };

    var simpleSearch = function (element) {
        element.find(selector.inputField).on('keyup', function (e) {
            var value = $(this).val();
            var valueWithUpper = value.charAt(0).toUpperCase() + value.substr(1);

            if (e.keyCode !== 38 && e.keyCode !== 40 && e.keyCode !== 9) {
                $(this).closest(selector.input).find(selector.results + ' ul li').each(function () {
                    if ($(this).text().search(value) > -1 || $(this).text().search(valueWithUpper) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

            }
        });
    };

    var initActionClick = function (element) {
        $(document).on('click', function () {
            if ($(selector.results).length) {
                toggleList($(selector.input + '.focus'), 'hide');
            }
        });

        element.children(selector.results).on('click', 'li:not(.disabled)', function (e) {
            e.stopPropagation();
            $(this).closest(selector.results).hide();
            var value = $(this).data("value");
            var resultsUl = $(this).closest('ul');

            if (resultsUl.hasClass(selector.resultMulti)) {
                clickCanBeMulti($(this), value, resultsUl);
            } else {
                clickDefault(value, resultsUl);
            }
        });
    };

    var clickDefault = function (value, resultsUl) {
        if (value.length) {
            searchProducts(value);
        } else {
            var searchPart = getSearchPartFromPathName();
            var categoriesLevel = resultsUl.attr('data-categories-level');

            if (categoriesLevel > 0) {
                var url = $(selector.results + ' ul[data-categories-level="' + (categoriesLevel - 1) + '"]').data("value-active");
                searchProducts(url);
            } else if (searchPart) {
                searchProducts('/produkt:' + searchPart);
            } else {
                searchProducts('/');
            }
        }
    };

    var clickCanBeMulti = function (clickedElement, value, resultsUl) {
        if (!resultsUl.attr("data-multiple")) {
            if (value.length) {
                searchProducts(value);
            } else {
                searchProducts(resultsUl.attr('data-url-out'))
            }

        } else {
            var multipleList = getMultipleList(clickedElement);

            if (value.length && multipleList.length > 0) {
                var urlInTemplate = resultsUl.attr('data-url-in-template'),
                    url = urlInTemplate.replace('%s', multipleList.join(';'));
                searchProducts(url);
            } else {
                searchProducts(resultsUl.attr('data-url-out'))
            }
        }
    };

    var getMultipleList = function (clickedElement) {
        var value = clickedElement.data("value"),
            multipleList = $(clickedElement.closest('ul').find('li' + selector.activeFilter)).map(function () {
                return $(this).data("value");
            }).get();

        if (clickedElement.hasClass(selector.activeFilter.replace('.', ''))) {
            multipleList = $.grep(multipleList, function (valueArr) {
                return valueArr !== value;
            });
        } else {
            multipleList.push(value);
        }
        return multipleList;
    };

    var getSearchPartFromPathName = function () {
        var pathname = document.location.pathname;
        if (pathname.search(/(produkt:|producent:|sklep:|cena:)/) >= 0) {
            var pathnameArray = pathname.split('/');
            if (pathnameArray.length === 3) {
                return pathnameArray[2];
            }
        }
        return null;
    };

    var initActionRemove = function (element) {
        element.find(selector.activeCategory + ' ' + selector.actionRemove).on('click', function () {
            $(this).closest(selector.input + selector.inputSpecClass).find(selector.results + ' li' + selector.hiddenResult).trigger('click');
        });

        element.find(selector.filter + ' ' + selector.closeFilter).on('click', function () {
            var value = $(this).data("value");

            if ($(this).closest(selector.filters).children(selector.filter).length > 1) {
                $(this).closest(selector.input + selector.inputSpecClass).find(selector.results + ' li' + selector.activeFilter + '[data-value=' + value + ']').trigger('click');
            } else {
                searchProducts($(this).closest(selector.filters).attr('data-url-out'));
            }
        });
    };

    var initFocusInOut = function (element) {

        element.find(selector.activeCategory + ' ' + selector.activeCategoryText).on('click', function (e) {
            e.stopPropagation();
            var inputBox = $(this).closest(selector.input).find(selector.inputField);
            if (!inputBox.is(":focus")) {
                inputBox.focus();
            }
        });

        $(selector.input).on('focusin', selector.inputField, function () {
            if ($(selector.inputField).not(this).closest(selector.input).length) {
                $(selector.inputField).not(this).closest(selector.input).children(selector.results).slideUp(300);
                $(selector.inputField).not(this).closest(selector.input).removeClass('focus');
            }
            toggleList($(this).closest(selector.input), 'show');
        });

        $(selector.input).on('click', selector.inputField, function (e) {
            e.stopPropagation();
        });

    };

    var toggleList = function (element, action) {
        switch (action) {
            case 'show':
                element.addClass('focus');
                element.children(selector.results).slideDown(300);
                break;
            case 'hide':
                element.removeClass('focus');
                element.children(selector.results).slideUp(300);
                break;
        }
    };

    var initProductsActions = function () {
        $(selector.mainContainer).find(selector.productActionsBtn + ' span').click(function () {
            var productBox = $(this).closest(selector.foundProduct);
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

    return {
        init: init,
        getLoader: getLoader,
        updateProductsStatus: updateProductsStatus
    };
})(jQuery, window, document, AccountPostProductsSearchAppPort);
