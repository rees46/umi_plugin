REES46 UMI CMS plugin
==========
Плагин для подключения REES46 к UMI CMS

Инструкции по установке
----------
1. Переместить папку ```classes``` в корневую директорию вашего сайта
2. Переместить папку ```tempates/default/xslt``` в директорию на вашем сайте ```templates/имя-вашего-шаблона/```
3. Зайти в панель управления модулями ```/admin/config/modules/```, ввести путь до инсталляции плагина ```classes/modules/rees46/install.php```, установить
4. Добавить права на доступ к просмотру плагина всем необходимым юзерам и группам: ```/admin/users/users_list_all/```
5. Добавить в файл ```имя-вашего-шаблона/xslt/default.xsl``` строчку
```
<xsl:include href="modules/rees46x/common.xsl" />
```
6. Добавить перед закрывающим тегом ```</body>``` в шаблон ```имя-вашего-шаблона/xslt/layouts/default.xsl```
```
<xsl:apply-templates select="document('udata://rees46/view/[token]')/udata" mode="right" />
```

Вместо [token] необходимо вставить ваш токен

