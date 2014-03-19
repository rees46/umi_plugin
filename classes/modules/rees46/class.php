<?php
class rees46 extends def_module {

    const BASE_URL = 'http://api.rees46.com';

    public function __construct() {
        parent::__construct();

        if(cmsController::getInstance()->getCurrentMode() == "admin") {
            # админка
            $this->__loadLib("__admin.php");
            $this->__implement("__rees46_admin");

            $configTabs = $this->getConfigTabs();
            if ($configTabs) {
                $configTabs->add("config");
            }

        } else {
            # сайт
            $this->__loadLib("__events_handlers.php");
            $this->__implement("__eventsHandlersEvents");
            $this->__loadLib("Pest.php");
            // падает при загрузке о_О
//            $this->__loadLib("REES46.php");
//            $this->__implement("REES46");

            $this->shop_id = regedit::getInstance()->getVal("//modules/rees46/shop-id");
            $permissions = permissionsCollection::getInstance();
            $this->current_user_id = $permissions->getUserId();
//            if ($this->shop_id) {
//                $this->rees = new REES46(this->BASE_URL, $this->shop_id, $_COOKIE['rees46_session_id'], $this->current_user_id);
//            }
        }
    }


    public function view() {
        // - "напрямую" http://example.com/mymodule/page - тогда он выполнится в дефолтном шаблоне
        // - в xslt-шаблоне document('udata://mymodule/page/1234')

        if( cmsController::getInstance()->getCurrentModule() == 'catalog' && cmsController::getInstance()->getCurrentMethod() == 'object' ) {
            $item['item_id'] = cmsController::getInstance()->getCurrentElementId();
            $item['category'] = umiHierarchy::getInstance()->getElement(umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getParentId())->getObjectId();
            $item['price'] = umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getValue('price');
        }
        else if( cmsController::getInstance()->getCurrentModule() == 'catalog' && cmsController::getInstance()->getCurrentMethod() == 'category' ) {
            $item['category'] = true;
            $item['category_id'] = umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getObjectId();
        }

//        if ($this->shop_id) {
//            $this->rees->pushView( array( (object) $item) );
//        }

    }

    public function recommends() {

        //Проверяем данные
        if( !isset($_GET['items']) || !is_array($_GET['items']) ) {
            exit;
        }

        // формирование итогового массива с данными, из которых потом будет строиться select
        $items = Array();
        foreach($_GET['items'] as $item) {
            $item_arr = Array();
            $item_arr['attribute:id'] = $item;
            $items[] = $item_arr;
        }

        $block_arr = array("lines" => Array('nodes:item' => $items));

        return $block_arr;
    }

}