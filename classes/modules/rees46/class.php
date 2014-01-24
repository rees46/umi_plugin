<?php
/**
 * User: nixx
 * Date: 25.11.13
 * Time: 15:22
 */
class rees46 extends def_module {

	public function __construct() {
		parent::__construct();  // Вызываем конструктор родительского класса def_module

		// В зависимости от режима работы системы, подключаем различные методы
		if(cmsController::getInstance()->getCurrentMode() == "admin") {
			// подгружаем файл с абстрактным классом __mymodule_adm для админки
			$this->__loadLib("__admin.php");
			// подключаем ("импортируем") методы класса __mymodule_adm
			// для расширения функционала в режиме администрирования
			$this->__implement("__rees46_adm");
		} else {
			// подгружаем файл с абстрактным классом __custom_mymodule для клиентской части
			$this->__loadLib("__custom.php");
			// подключаем ("импортируем") методы класса __custom_mymodule
			// для расширения функционала в клиентском режиме
			$this->__implement("__custom_rees46");
		}
//		echo "<pre>";
//		print_r(umiHierarchy::getInstance()->getElement(umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getParentId())->getObjectId());
//		echo "</pre>";exit;
	}


	public function view($id) {
		// реализация метода page
		// этот публичный метод также является макросом
		// его можно вызвать:
		// - "напрямую" http://example.com/mymodule/page - тогда он выполнится в дефолтном шаблоне
		// - в tpl-шаблоне, напрмер так %mymodule page('%pid%')%
		// - в xslt-шаблоне document('udata://mymodule/page/1234')

		$block_arr = array(
			'widget' => array(),
			'attribute:id' => $id
		);

		if( cmsController::getInstance()->getCurrentModule() == 'catalog' && cmsController::getInstance()->getCurrentMethod() == 'object' ) {
			$block_arr['widget']['id'] = cmsController::getInstance()->getCurrentElementId();
			$block_arr['widget']['category_id'] = umiHierarchy::getInstance()->getElement(umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getParentId())->getObjectId();
			$block_arr['widget']['price'] = umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getValue('price');
		}

		if( cmsController::getInstance()->getCurrentModule() == 'catalog' && cmsController::getInstance()->getCurrentMethod() == 'category' ) {
			$block_arr['widget']['category'] = true;
			$block_arr['widget']['category_id'] = umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getObjectId();
		}
//		echo "<pre>";
//		print_r($block_arr);
//		echo "</pre>";exit;
		return def_module::parseTemplate("", $block_arr, false, $id);
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