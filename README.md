# Инструкция по интеграции UMI CMS с REES46
==========

## I Скопируйте файлы

1. Скопируйте директории ```classes```, ```images```, ```styles```, ```js``` в корневую директорию вашего сайта
2. Скопируйте директорию ```templates/default/xslt/modules``` в соответствующую директорию вашего сайта

## II Отредактируйте файлы

1. Добавьте в файл вашего шаблона ```tempates/имя-вашего-шаблона/xslt/layouts/default.xsl``` перед закрывающим тегом body строчку:

  ```xslt
    <xsl:apply-templates select="document('udata://rees46/view')/udata" mode="rees46-init" />
  ```
2. Добавьте в файл ```templates/имя-вашего-шаблона/xslt/default.xsl``` строчку:

  ```xslt
    <xsl:include href="modules/rees46x/common.xsl" />
  ```

## III Установите модуль

1. Зайдите в панель управления модулями ```/admin/config/modules/``` (Меню Модули -> Конфигурация -> вкладка Модули)
2. Введите в поле "Путь до инсталляционного файла" ```classes/modules/rees46/install.php```
3. Нажмите на кнопку "Установить"
4. После инсталляции модуль должен появится в самом низу списка модулей (REES46 коннектор)

## IV Настройте модуль

1. Перейдите в Модули -> Пользователи, нажмите на иконку редактирования пользователя Гость, поставьте галочку "Просмотр рекомендаций" модуля REES46 коннектор. Галка "Права на использование" стоять не должна.
2. Установите права на просмотр требуемым вам пользователям и групп пользователей
3. Перейдите в Модули -> REES46 коннектор, следуйте инструкциям на экране.

## V Настройте внешний вид

В стили используемой вами темы добавьте следующий код и оформите его в соответствии с вашим дизайном:

```css
.rees46 .recommended-items {}
.rees46 .recommended-item {
  display: inline-block;
  text-align: center;
  width: 180px;
  height: 290px;
  margin-right: 15px;
  margin-bottom: 15px;
  overflow: hidden;
}
.rees46 .recommended-item .recommended-item-photo {
  margin-bottom: 20px;
}
.rees46 .recommended-item .recommended-item-photo img {
  max-width: 180px;
  max-height: 180px;
}
.rees46 .recommended-item .recommended-item-title {
  margin-bottom: 20px;
  font-size: 16px;
  height: 38px;
  overflow: hidden;
}
.rees46 .recommended-item .recommended-item-title a {
  color: #5580F0;
}
```

## VI Настройка рекоммендеров

Рекоммендеры подключаются в xslt-файлы текущей темы кодом:

```xslt
<xsl:call-template name="rees46-recommender">
  <xsl:with-param name="type">recently_viewed</xsl:with-param>
</xsl:call-template>
```

где recently_viewed - имя рекоммендера из документации REES46
(http://memo.mkechinov.ru/pages/viewpage.action?pageId=786532 п. 5.1)