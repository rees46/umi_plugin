if (!String.prototype.format) {
    String.prototype.format = function () {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function (match, number) {
            return typeof args[number] != 'undefined'
                ? args[number]
                : match
                ;
        });
    };
}

window.__REES46 = {

    PRODUCTS_PER_RECOMMENDER: 6,

    _obj: null,
    tpl_items: '<div class="rees46-recommend">' +
		'<div class="recommender-block-title">Возможно, вам это будет интересно</div>' +
		'<div class="recommended-items">{0}</div>' +
		'</div>',
    tpl_item: '<div class="recommended-item cat_item">' +
        '<div class="recommended-item-photo">' +
        '<a href="{0}"><img src="{2}" class="item_img" alt="Товар" /></a>' +
        '</div>' +
        '<div class="cat_item_text">{5}</div>'+
        '<div class="recommended-item-title">' +
        '<a href="{0}">{1}</a>' +
        '</div>' +
        '<div class="recommended-item-price">' +
        '<span umi:element-id="66" umi:field-name="price">{4}</span> р.' +
        '</div>' +
        '<div class="recommended-item-action"><a href="{0}" class="button">Подробнее</a></div>' +
        '</div>',

    push: function (obj) {

        this.obj = obj;

        if (window.rees46_recommenders === undefined) {
            return;
        }

        var i, rec = window.rees46_recommenders;

        for (i = 0; i <= rec.length; i++) {

            if (!rec[i]) {
                continue;
            }

            type = rec[i].type;

            var recommender = {
                recommender_type: type,
                limit: __REES46.PRODUCTS_PER_RECOMMENDER,
                item: rec[i].item,
                cart: rec[i].cart,
                category: rec[i].category
            };

            // т.к. рекоммендер не сообщает свой тип callback-функции,
            // указываем разные функции в качестве callback
            switch (type) {
                case 'interesting':
                    obj.recommend(recommender, __REES46.recommendInteresting);
                    break;
                case 'also_bought':
                    obj.recommend(recommender, __REES46.recommendAlso_bought);
                    break;
                case 'similar':
                    obj.recommend(recommender, __REES46.recommendSimilar);
                    break;
                case 'popular':
                    obj.recommend(recommender, __REES46.recommendPopular);
                    break;
                case 'see_also':
                    obj.recommend(recommender, __REES46.recommendSee_also);
                    break;
                case 'recently_viewed':
                    obj.recommend(recommender, __REES46.recommendRecently_viewed);
                    break;
            }
        }
    },

    recommendByType: function (type, ids) {

        if (ids.length > 0) {

            // получение данных по продуктам
            jQuery.getJSON('/udata/rees46/products_by_id.json?ids=' + ids.join(',') + '.json', jQuery.proxy(function (data) {

                var foundProducts = false;
                var selector = $('#recommender_' + type);

                if (data) {

                    var items = '';

                    $.each(data.products, function (id, product) {

                        foundProducts = true;

                        if (product.title) {
                            items += __REES46.tpl_item.format(
                                product.permalink + '?recommended_by=' + type,
                                product.title,
                                product.image.src,
                                '/emarket/basket/put/element/' + id + '/?recommended_by=' + type,
                                product.price,
                                product.description
                            );
                        }

                    });

                    items = __REES46.tpl_items.format(items);
										if (REES46.showPromotion) {
										// Эта функция возвращает верстку рекламной строчки, она должна быть в самом конце контента блока
											items = items + REES46.getPromotionBlock();
										}
                    selector.html(items);

                }

                if (foundProducts == true) {
                    selector.parent().fadeIn(100);
                }

            }, jQuery('#' + type)));

        }

    },

    recommendInteresting: function (data) {
        window.__REES46.recommendByType('interesting', data);
    },
    recommendAlso_bought: function (data) {
        window.__REES46.recommendByType('also_bought', data);
    },
    recommendSimilar: function (data) {
        window.__REES46.recommendByType('similar', data);
    },
    recommendPopular: function (data) {
        window.__REES46.recommendByType('popular', data);
    },
    recommendSee_also: function (data) {
        window.__REES46.recommendByType('see_also', data);
    },
    recommendRecently_viewed: function (data) {
        window.__REES46.recommendByType('recently_viewed', data);
    }

}