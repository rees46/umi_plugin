<?php
/**
 * User: nixx
 * Date: 25.11.13
 * Time: 15:32
 */
$INFO = Array();

$INFO['name'] = "rees46";
$INFO['filename'] = "rees46/class.php";
$INFO['config'] = "0";
$INFO['ico'] = "ico_rees46";
$INFO['default_method'] = "insert";
$INFO['default_method_admin'] = "tree";

$INFO['func_perms'] = "";
$INFO['func_perms/view'] = "Просмотр баннеров";
$INFO['func_perms/admin'] = "Администрирование модуля";

$COMPONENTS = array();

$COMPONENTS[0] = "./classes/modules/rees46/__custom.php";
$COMPONENTS[1] = "./classes/modules/rees46/__admin.php";
$COMPONENTS[2] = "./classes/modules/rees46/class.php";
$COMPONENTS[3] = "./classes/modules/rees46/lang.php";
$COMPONENTS[4] = "./classes/modules/rees46/i18n.php";
$COMPONENTS[5] = "./classes/modules/rees46/permissions.php";