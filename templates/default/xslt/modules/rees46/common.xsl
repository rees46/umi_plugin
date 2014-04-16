<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet	version="1.0" xmlns="http://www.w3.org/1999/xhtml"
								 xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
								 xmlns:date="http://exslt.org/dates-and-times"
								 xmlns:udt="http://umi-cms.ru/2007/UData/templates"
								 xmlns:xlink="http://www.w3.org/TR/xlink"
								 exclude-result-prefixes="xsl date udt xlink">

	<xsl:variable name="result" select="/result" />

	<xsl:include href="rees46.xsl" />
	<!--<xsl:include href="recommends.xsl" />-->
</xsl:stylesheet>