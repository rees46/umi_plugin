<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM	"ulang://i18n/constants.dtd:file">

<xsl:stylesheet	version="1.0"
                   xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                   xmlns:umi="http://www.umi-cms.ru/TR/umi"
                   xmlns:xlink="http://www.w3.org/TR/xlink">

    <xsl:template match="udata" mode="rees46-init">
        <script type="text/javascript" src="//cdn.rees46.com/rees46_script2.js"></script>
        <script type="text/javascript">
            <xsl:choose>
                <xsl:when test="type='object'">
                    var reesReady = function() {
                    REES46.pushData("view", {
                    "item_id": <xsl:value-of select="item_id" />,
                    "category": <xsl:value-of select="category" />,
                    "price": <xsl:value-of select="price" />
                    });
                    }
                </xsl:when>
                <xsl:otherwise>var reesReady = function() {}</xsl:otherwise>
            </xsl:choose>
        </script>
        <script type="text/javascript">REES46.init("<xsl:value-of select="shop_id" />", <xsl:value-of select="user_id" />, reesReady);</script>
    </xsl:template>

</xsl:stylesheet>