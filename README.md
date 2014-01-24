umi_plugin
==========

Плагин для подключения REES46 к UMI CMS

```
2. переместить папку classes в корневую директорию вашего сайта
3. переместить папку templates/default/xslt в директорию на вашем сайте templates/имя вашего шаблона/
4. зайти в панель управления модулями /admin/config/modules/, ввести путь до инсталляции плагина classes/modules/rees46/install.php, установить
5. добавить права на доступ к просмотру плагина всем необходимым юзерам и группам: /admin/users/users_list_all/
6. добавить строчку в нужное место вашего шаблона, расположение стандартного шаблона: templates/имя вашего шаблона/xslt/layouts/default.xsl
Код вставки:
<xsl:apply-templates select="document('udata://rees46/view/[token]')/udata" mode="right" />
Вместо [token] необходимо вставить ваш токен

Последняя версия, единственное что изменилось, это нужно добавить некое условие в основной шаблон:
найти секцию <xsl:template match="/" mode="layout"> и после нее вставить перед тегом <html>
<xsl:choose>
    <xsl:when test="result[@module = 'rees46'][@method = 'recommends']">
        <xsl:apply-templates select="document('udata://rees46/recommends')/udata" />
    </xsl:when>
<xsl:otherwise>
после тега </html> добавить:
</xsl:otherwise>
</xsl:choose>



строку инициализации добавить в конец перед тегом </body>:
<xsl:apply-templates select="document('udata://rees46/view/d3b7ec463691c473cb1656463d545b')/udata" mode="right" />



в templates/templatename/xslt/default.xsl еще дописать

<xsl:include href="modules/rees46/common.xsl" />
```
