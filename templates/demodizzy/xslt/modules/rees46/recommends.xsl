<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template name="rees46-recommender">

        <xsl:param name="type"/>
        <xsl:param name="header"/>
        <xsl:param name="item"/>

        <!--<xsl:apply-templates select="document('udata://emarket/cart/')/udata/items" mode="rees46-cart" />-->

        <div class="recommender-wrapper">

            <h1>
                <xsl:value-of select="$header"/>
            </h1>

            <div id="recommender_{$type}"></div>

            <script type="text/javascript">
                if (window.rees46_recommenders === undefined) {
                window.rees46_recommenders = []
                }
                window.rees46_recommenders.push({type:'<xsl:value-of select="$type"/>', item: '<xsl:value-of select="$item"/>'})
            </script>
        </div>

    </xsl:template>


    <!--<xsl:template match="udata/items" mode="rees46-cart">-->
    <!--<div style="display:none">-->
    <!--<xsl:apply-templates select="lines/item" mode="short-view">-->
    <!--<xsl:with-param name="cart_items" select="document('udata://emarket/cart/')/udata/items" />-->
    <!--</xsl:apply-templates>-->
    <!--</div>-->
    <!--</xsl:template>-->

</xsl:stylesheet>