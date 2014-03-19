<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM "ulang://i18n/constants.dtd:file">

<xsl:stylesheet version="1.0"
				xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
				xmlns:umi="http://www.umi-cms.ru/TR/umi"
				xmlns:xlink="http://www.w3.org/TR/xlink">

	<xsl:template match="/" mode="layout">
		<xsl:choose>
			<xsl:when test="result[@module = 'rees46'][@method = 'recommends']">
				<xsl:apply-templates select="document('udata://rees46/recommends')/udata" />
			</xsl:when>
			<xsl:otherwise>
		<html>
			<head>
				<meta http-equiv="X-UA-Compatible" content="IE=edge" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="keywords" content="{//meta/keywords}" />
				<meta name="description" content="{//meta/description}" />
				<title><xsl:value-of select="$document-title" /></title>
				<xsl:value-of select="document('udata://system/includeQuickEditJs')/udata" disable-output-escaping="yes" />

				<script type="text/javascript" charset="utf-8" src="/templates/demodizzy/js/__common.js"></script>

				<link type="text/css" rel="stylesheet" href="/templates/demodizzy/css/common.css" />

				<xsl:if test="$method = 'compare'">
					<link type="text/css" rel="stylesheet" href="/templates/demodizzy/css/two_left.css" />
				</xsl:if>
				<link rel="canonical" href="http://{concat(result/@domain, result/@request-uri)}" />
				<script type="text/javascript" src="http://apis.google.com/js/plusone.js">
					{lang: 'ru'}
				</script>
				<!-- social buttons-->
				<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?32"></script>
				<script src="http://vkontakte.ru/js/api/openapi.js" type="text/javascript" charset="windows-1251"></script>
				<!-- /social buttons-->
				<link media="print" type="text/css" rel="stylesheet" href="/templates/demodizzy/css/print.css" />
			</head>
			<body>
				<div id="main">
					<div id="head">
						<a id="logo" href="/" umi:element-id="{$site-info-id}" umi:field-name="site_logo">
							<xsl:attribute name="style">
								<xsl:value-of select="concat('background-image: url(', $site-info[@name = 'site_logo']/value, ')')" />
							</xsl:attribute>
						</a>
						<div class="site_info" itemscope="itemscope" itemtype="http://schema.org/Organization">
							<xsl:apply-templates select="document('usel://info-pages')/udata" mode="info-pages-head" />
							<div class="work" umi:element-id="{$site-info-id}">
								<div itemprop="telephone" class="phone" umi:field-name="phone">
									<xsl:value-of select="$site-info[@name = 'phone']/value" />
								</div>
								<div umi:field-name="order_info_top">
									<xsl:value-of select="$site-info[@name = 'order_info_top']/value" disable-output-escaping="yes" />
								</div>
							</div>
						</div>
						<xsl:apply-templates select="document('udata://emarket/cart')" mode="basket" />
					</div>
					<xsl:apply-templates select="document('udata://content/menu/(null)/1/')" mode="top_menu" />
					<div id="page">
						<div class="right">
							<xsl:apply-templates select="/result/user" />

							<xsl:choose>
								<xsl:when test="$is-two-columns">
									<div class="cards" umi:element-id="{$site-info-id}" umi:field-name="order_info_left">
										<xsl:value-of select="$site-info[@name = 'order_info_left']/value" disable-output-escaping="yes" />
									</div>
								</xsl:when>
								<xsl:otherwise>
									<xsl:apply-templates select="document('udata://news/lastlist/(news)')" mode="right-column-news" />
									<xsl:apply-templates select="document('udata://emarket/getCompareList')" />
									<xsl:apply-templates select="document('udata://vote/insertlast/')" />
									<xsl:apply-templates select="document('udata://dispatches/subscribe/')/udata" mode="right" />
									<xsl:apply-templates select="document('udata://content/getRecentPages////3')/udata" mode="right" />
									<xsl:apply-templates select="document('udata://banners/fastInsert/right_block/')/udata" mode="right" />
								</xsl:otherwise>
							</xsl:choose>
						</div>
						<xsl:if test="$is-two-columns = false()">	
							<div class="left">
								<xsl:call-template name="search-form-left-column" />

								<xsl:apply-templates select="document('udata://catalog/getCategoryList/void/shop//1/')" mode="left-column" />

								<div class="cards" umi:element-id="{$site-info-id}" umi:field-name="order_info_left">
									<xsl:value-of select="$site-info[@name = 'order_info_left']/value" disable-output-escaping="yes" />
								</div>
								<div class="hours" umi:element-id="{$site-info-id}" umi:field-name="payment_info_left">
									<xsl:value-of select="$site-info[@name = 'payment_info_left']/value" disable-output-escaping="yes" />
								</div>
								<div>
									<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FUMI.CMS&amp;width=188&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false&amp;height=293" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:188px; height:293px; margin: 50px 0 10px;" allowTransparency="true"></iframe>
									<!-- VK Widget -->
									<div id="vk_groups" style="margin-bottom: 10px;"></div>
									<script type="text/javascript">
										VK.Widgets.Group("vk_groups", {mode: 0, width: "188", height: "293"}, 23325076);
									</script>
								</div>
							</div>
						</xsl:if>
						<div class="center">
							<xsl:if test="$is-two-columns">
								<xsl:attribute name="style">margin-left: 15px;</xsl:attribute>
							</xsl:if>
							<xsl:apply-templates select="$errors" />
							<xsl:apply-templates select="result" mode="header" />
							<div class="content">
								<xsl:apply-templates select="result" />
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<div id="foot">
						<xsl:apply-templates select="document('usel://info-pages')/udata" mode="info-pages-foot" />
						<div class="copyright">
							Copyright <xsl:value-of select="document('udata://system/convertDate/now/(Y)')/udata" />. <xsl:text>&copyright;</xsl:text>
						</div>
					</div>
				</div>
				<xsl:apply-templates select="document('udata://rees46/view')/udata" />
			</body>
		</html>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>