/**
 * User: nixx
 * Date: 27.11.13
 * Time: 12:03
 */
function basket_add(f) {
	return function() {
		REES46.pushData("cart", {item_id: arguments[0], price: arguments[1] ? $(arguments[1]).parent().find(".price").text().trim() : null});
		return f.apply(this, arguments);
	}
}
site.basket.add = basket_add(site.basket.add);

function basket_remove(f) {
	return function(id) {
		REES46.pushData("remove_from_cart", {item_id: $(".cart_item_" + id).find('[umi\\:element-id]').attr('umi:element-id')});
		return f.apply(this, arguments);
	}
}
site.basket.remove = basket_remove(site.basket.remove);

function rees46_callback(r) {
	console.log(r);
	$.ajax({
		url: "/rees46/recommends/",
		data: {
			items: r
		},
		success: function(r) {
			$(".catalog").after(r);
		}
	});
}