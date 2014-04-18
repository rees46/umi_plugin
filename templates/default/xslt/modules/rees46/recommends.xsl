<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template name="rees46-recommender">
        <xsl:param name="type" />

        <!--<xsl:apply-templates select="document('udata://emarket/cart/')/udata/items" mode="rees46-cart" />-->

        <h1>Заголовок рекоммендера</h1>
        <div id="recommender_{$type}"></div>
        <script type="text/javascript">
            if (window.rees46_recommenders === undefined) {
            window.rees46_recommenders = []
            }
            window.rees46_recommenders.push('<xsl:value-of select="$type" />')
        </script>
    </xsl:template>


    <!--<xsl:template match="udata/items" mode="rees46-cart">-->
    <!--<div style="display:none">-->
    <!--<xsl:apply-templates select="lines/item" mode="short-view">-->
    <!--<xsl:with-param name="cart_items" select="document('udata://emarket/cart/')/udata/items" />-->
    <!--</xsl:apply-templates>-->
    <!--</div>-->
    <!--</xsl:template>-->

</xsl:stylesheet>