window.__REES46 = {

    _obj: null,
    tpl_items: '<div class="recommended-items">{0}</div>',
    tpl_item:  '<div class="recommended-item">'+
        '<div class="recommended-item-photo">'+
        '<a href="{0}"><img src="{2}" class="item_img" /></a>'+
        '</div>'+
        '<div class="recommended-item-title">'+
        '<a href="{0}">{1}</a>'+
        '</div>'+
        '</div>',

    push: function(obj) {
        this.obj = obj;

        if (window.rees46_recommenders === undefined) {
            return;
        }

        var i, rec = window.rees46_recommenders;
        for(i = 0; i <= rec.length; i++) {
            type = rec[i];
            // т.к. рекоммендер не сообщает свой тип callback-функции,
            // указываем разные функции в качестве callback
            switch(type) {
                case 'interesting': obj.recommend(type, __REES46.recommendInteresting); break;
                case 'also_bought': obj.recommend(type, __REES46.recommendAlso_bought); break;
                case 'similar': obj.recommend(type, __REES46.recommendSimilar); break;
                case 'popular': obj.recommend(type, __REES46.recommendPopular); break;
                case 'see_also': obj.recommend(type, __REES46.recommendSee_also); break;
                case 'recently_viewed': obj.recommend(type, __REES46.recommendRecently_viewed); break;
            }
        }
    },

    recommendByType: function(type, ids) {
        if (ids.length > 0) {
            // получение данных по продуктам
            jQuery.getJSON('/udata/rees46/products_by_id.json?ids=' + ids.join(',') + '.json', jQuery.proxy(function(data) {
                if (data) {
                    var items = '',
                        selector = this,
                        type = selector.data('type');
                    jQuery(data.products).each(function() {
                        if (this.title) {
                            items += __REES46.tpl_item.format(
                                '/product/' + this.permalink + '?recommended_by=' + type,
                                this.title,
                                this.images[0].medium_url
                            );
                        }
                    });
                    items = __REES46.tpl_items.format(items);
                    selector.html(items);
                }
            }, jQuery('#' + type)));
        }
    },

    recommendInteresting: function(data) {
        this.recommendByType('interesting', data);
    },
    recommendAlso_bought: function(data) {
        this.recommendByType('also_bought', data);
    },
    recommendSimilar: function(data) {
        this.recommendByType('similar', data);
    },
    recommendPopular: function(data) {
        this.recommendByType('popular', data);
    },
    recommendSee_also: function(data) {
        this.recommendByType('see_also', data);
    },
    recommendRecently_viewed: function(data) {
        this.recommendByType('recently_viewed', data);
    }

}