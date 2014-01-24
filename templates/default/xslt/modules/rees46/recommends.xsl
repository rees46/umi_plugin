<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="udata[@module = 'rees46'][@method = 'recommends']">
		<h1>Рекомендованные</h1>
		<div class="catalog">
			<div class="objects">

				<xsl:apply-templates select="lines/item" mode="short-view">
					<xsl:with-param name="cart_items" select="document('udata://emarket/cart/')/udata/items" />
				</xsl:apply-templates>
				<script>
					jQuery('.basket_list').unbind('click').click(function(){
						if (!site.basket.is_cart || !jQuery(this).hasClass('options_false')) {
						site.basket.list(this);
						return false;
					}
					});
				</script>
			</div>
		</div>
	</xsl:template>

</xsl:stylesheet>