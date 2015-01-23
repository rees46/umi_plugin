<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet  SYSTEM	"ulang://modules/rees46/i18n/constants.dtd:file">
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="data[@type = 'settings' and @action = 'modify']">
        <form method="post" action="do/" enctype="multipart/form-data">
            <xsl:apply-templates select="." mode="settings.modify" />
        </form>
    </xsl:template>

    <xsl:template match="/result[@method = 'config']/data[@type = 'settings' and @action = 'modify']">
        <div class="panel properties-group">
            <div class="header">
                <span>&rees46-settings-title;</span>
                <div class="l" /><div class="r" />
            </div>
            <div class="content">
                <strong>Для работоспособности модуля вам необходимо выполнить следующие действия:</strong>
                <br/><br/>
                <ul>
                    <li>1. Зарегистрироваться и добавить магазин на <a href="http://rees46.com/customers/sign_up">rees46.com</a>;</li>
                    <li>2. Получить персональный идентификатор вида &lt;9a9ecdc3265b397fd7196b6351a33e>;</li>
                    <li>3. Вписать полученный идентификатор ниже и сохранить изменения.</li>
                </ul>
                <br/><br/>
            </div>
        </div>
        <form method="post" action="do/" enctype="multipart/form-data">
            <xsl:apply-templates select="." mode="settings.modify" />
        </form>
    </xsl:template>

</xsl:stylesheet>