<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM	"ulang://i18n/constants.dtd:file">

<xsl:stylesheet	version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:umi="http://www.umi-cms.ru/TR/umi"
	xmlns:xlink="http://www.w3.org/TR/xlink">

	<xsl:template match="udata[@module = 'rees46'][@method = 'view'][rees46]">
		<script type="text/javascript" src="//cdn.rees46.com/rees46_script.js"></script>
		<!--<script type="text/javascript" src="/js/rees46.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				REES46.init("<xsl:value-of select="@id"/>");
				<xsl:if test="/udata/rees46/id > 0">
					REES46.pushData("view", {
					"item_id": <xsl:value-of select="$result/@pageId" />,
					"category": <xsl:value-of select="/udata/rees46/category_id" />,
					"price": <xsl:value-of select="/udata/rees46/price" />
					});
					REES46.recommend('similar', rees46_callback, <xsl:value-of select="/udata/rees46/id" />);
				</xsl:if>
				<xsl:if test="/udata/rees46/category">
					REES46.recommend('recently_viewed', rees46_callback, <xsl:value-of select="/udata/rees46/category_id" />);
				</xsl:if>
			});
		</script>-->
	</xsl:template>

</xsl:stylesheet>