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
    tpl_items: '<div class="recommended-items">{0}</div>',
    tpl_item: '<div class="recommended-item">' +
        '<div class="recommended-item-photo">' +
        '<a href="{0}"><img src="{2}" class="item_img" /></a>' +
        '</div>' +
        '<div class="recommended-item-title">' +
        '<a href="{0}">{1}</a>' +
        '</div>' +
        '</div>',

    push: function (obj) {

        this.obj = obj;

        if (window.rees46_recommenders === undefined) {
            return;
        }

        var i, rec = window.rees46_recommenders;
        for (i = 0; i <= rec.length; i++) {
            type = rec[i];
            var recommender = {
                recommender_type: type,
                limit: __REES46.PRODUCTS_PER_RECOMMENDER
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

                if (data) {

                    var items = '';
                    var selector = $('#recommender_' + type);

                    $.each(data.products, function (id, product) {

                        if (product.title) {
                            items += __REES46.tpl_item.format(
                                product.permalink + '?recommended_by=' + type,
                                product.title,
                                product.image.src
                            );
                        }

                    });

                    items = __REES46.tpl_items.format(items);
                    selector.html(items);

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