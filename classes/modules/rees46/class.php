<?php

/**
 * Class rees46
 */
class rees46 extends def_module {

	const BASE_URL = 'http://api.rees46.com';
	const PRODUCTS_PER_RECOMMENDER = 6;

	/**
	 * Конструктор
	 */
	public function __construct() {

		parent::__construct();

		if (cmsController::getInstance()->getCurrentMode() == 'admin') {
			# админка
			$this->__loadLib('__admin.php');
			$this->__implement('__rees46_admin');

			$configTabs = $this->getConfigTabs();
			if ($configTabs) {
				$configTabs->add("config");
			}
		} else {
			$this->__loadLib("__custom.php");
			$this->__implement("__custom_rees46");

			$this->shop_id = regedit::getInstance()->getVal("//modules/rees46/shop-id");
			$permissions = permissionsCollection::getInstance();
			$this->current_user_id = $permissions->getUserId();

			if( $this->current_user_id ) {
				$collection = umiObjectsCollection::getInstance();
				$this->current_user = $collection->getObject( $this->current_user_id );
			}
		}
	}

	/**
	 * Просмотр страницы в tpls шаблоне
	 * @return mixed
	 */
	public function view_tpls() {

		list($template_block) = def_module::loadTemplates("rees46/default", "view");

		if (cmsController::getInstance()->getCurrentModule() == 'catalog' && cmsController::getInstance()->getCurrentMethod() == 'object') {
			$item['item_id'] = cmsController::getInstance()->getCurrentElementId();
			$item['category'] = umiHierarchy::getInstance()->getElement(umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getParentId())->getObjectId();
			$item['price'] = umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getValue('price');
		} elseif (cmsController::getInstance()->getCurrentModule() == 'catalog' && cmsController::getInstance()->getCurrentMethod() == 'category') {
			$item['category'] = true;
			$item['category_id'] = umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getObjectId();
		}

		return self::parseTemplate($template_block, array(
			'shop_id' => $this->shop_id,
			'user_id' => $this->current_user_id,
			'email' => $this->current_user ? $this->current_user->getValue('e-mail') : null,
			'type' => isset($item['item_id']) ? 'object' : (isset($item['category_id']) ? 'category' : 'none'),
			'item_id' => isset($item['item_id']) ? $item['item_id'] : null,
			'category' => isset($item['category']) ? $item['category'] : null,
			'category_id' => isset($item['category_id']) ? $item['category_id'] : null,
			'price' => isset($item['price']) ? $item['price'] : null
		));
	}

	/**
	 * Показать блок с рекоммендером в tpls шаблоне
	 * @todo: получить айдишники товаров в корзине $cartElementIds
	 * @param $type
	 * @param $header
	 * @return mixed
	 */
	public function recommend_tpls($type, $header) {

		list($template_block) = def_module::loadTemplates("rees46/default", "recommend");

		$cartElementIds = array();

		$emarket = cmsController::getInstance()->getModule("emarket");
		$order = $emarket->getBasketOrder(false);
		if (empty($order) == false) {
			$items = $order->getItems();
			foreach ($items as $item) {
				$cartElementIds[] = $item->id;
			}
		}

		$objectId = "";
		$itemId = "";
		if (empty($_GET['path']) == false) {
			$object = umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId());
			if (empty($object) == false) {
				$objectId = $object->getObjectId();
			}
			$itemId = cmsController::getInstance()->getCurrentElementId();
		}

		return self::parseTemplate($template_block, array(
			'type' => $type,
			'header' => $header,
			'item_id' => "'" . $itemId . "'",
			'category_id' => "'" . $objectId . "'",
			'cart' => '[' . implode(",", $cartElementIds) . ']'

		));

	}

	/**
	 * Просмотр страницы в xslt шаблоне
	 * @return mixed
	 */
	public function view() {

		// - "напрямую" http://example.com/rees46/view/.xml
		// - в xslt-шаблоне document('udata://rees46/view')

		if (cmsController::getInstance()->getCurrentModule() == 'catalog' && cmsController::getInstance()->getCurrentMethod() == 'object') {
			$item['item_id'] = cmsController::getInstance()->getCurrentElementId();
			$item['category'] = umiHierarchy::getInstance()->getElement(umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getParentId())->getObjectId();
			$item['price'] = umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getValue('price');
		} elseif (cmsController::getInstance()->getCurrentModule() == 'catalog' && cmsController::getInstance()->getCurrentMethod() == 'category') {
			$item['category'] = true;
			$item['category_id'] = umiHierarchy::getInstance()->getElement(cmsController::getInstance()->getCurrentElementId())->getObjectId();
		}

		return def_module::parseTemplate("", array(
			'shop_id' => $this->shop_id,
			'user_id' => $this->current_user_id,
			'email' => $this->current_user ? $this->current_user->getValue('e-mail') : null,
			'type' => isset($item['item_id']) ? 'object' : (isset($item['category_id']) ? 'category' : 'none'),
			'item_id' => isset($item['item_id']) ? $item['item_id'] : null,
			'category' => isset($item['category']) ? $item['category'] : null,
			'category_id' => isset($item['category_id']) ? $item['category_id'] : null,
			'price' => isset($item['price']) ? $item['price'] : null
		));

	}

	/**
	 *
	 * @return array
	 */
	public function recommends() {
		//Проверяем данные
		if (!isset($_GET['items']) || !is_array($_GET['items'])) {
			return array();
		}

		// формирование итогового массива с данными, из которых потом будет строиться select
		$items = array();
		foreach ($_GET['items'] as $item) {
			$item_arr = array();
			$item_arr['attribute:id'] = intval($item);
			$items [] = $item_arr;
		}

		$block_arr = array('lines' => array('nodes:item' => $items));

		return $block_arr;
	}

	/**
	 * @param iUmiEventPoint $event
	 * @return bool
	 */
	public function onOrderRefresh(iUmiEventPoint $event) {

		if ($event->getMode() !== 'after') {
			return true;
		}

		static $cachedCart = null;

		$cart = null;

		$items = $event->getParam('items');

		if (isset($items) && is_array($items)) {
			$cart = array();

			foreach ($items as $item) {
				/** @var optionedOrderItem @item */
				$cart[] = $item->getItemElement()->id;
			}

			if ($cachedCart) { // if we have something to compare with
				$this->processCart($cart, $cachedCart);
			}

			$cachedCart = $cart;
		}

		return true;
	}

	/**
	 * @param iUmiEventPoint $event
	 */
	public function onOrderAdded(iUmiEventPoint $event) {

		if ($event->getMode() == 'after' && $event->getParam('old-status-id') != $event->getParam('new-status-id')) {

			if ($event->getParam('new-status-id') == order::getStatusByCode('waiting') && $event->getParam("old-status-id") != order::getStatusByCode('editing')) {
				//file_put_contents('/tmp/umi.orders.log', var_export($event->eventParams, true), FILE_APPEND);
				$order = $event->getRef('order');
				/** @var order $order */

				$orderNumber = $order->getValue('number');

				$orderItems = array();

				foreach ($order->getItems() as $item) {
					/** @var orderItem $item */
					$orderItems [] = array(
						'item_id' => $item->getItemElement()->id,
						'price' => $item->getItemPrice(),
						'amount' => $item->getAmount(),
					);
				}

				$order = array(
					'order_id' => $orderNumber,
					'items' => $orderItems,
				);

				setcookie('rees46_track_purchase', json_encode($order), strtotime('+1 hour'), '/');

			}

		}

	}

	/**
	 * @param $newCart
	 * @param $oldCart
	 */
	private function processCart($newCart, $oldCart) {

		if ($newItems = array_diff($newCart, $oldCart)) {
			$this->processEvent('rees46_track_cart', $newItems);
		}

		if ($removedItems = array_diff($oldCart, $newCart)) {
			$this->processEvent('rees46_track_remove_from_cart', $removedItems);
		}
	}

	/**
	 * @param $cookie
	 * @param $newItems
	 */
	private function processEvent($cookie, $newItems) {
		if (isset($_COOKIE[$cookie])) {
			$json = json_decode($_COOKIE[$cookie]);
			$items = ($json ? $json : array());
		} else {
			$items = array();
		}

		$newItems = array_filter($newItems);

		foreach ($newItems as $itemId) {
			$items [] = array('item_id' => $itemId);
		}

		setcookie($cookie, json_encode($items), strtotime('+1 hour'), '/');
	}

	/**
	 * Функция должна возвращать параметры продуктов
	 * @return mixed
	 */
	public function products_by_id() {

		$ids = array_slice(
			explode(",",
				array_pop(
					explode("=",
						str_replace('.json', '', $_GET['path'])
					)
				)
			), 0, self::PRODUCTS_PER_RECOMMENDER);

		$products = array();

		foreach ($ids as $id) {

			$element = umiHierarchy::getInstance()->getElement($id);
			if( $element == null ) {
				continue;
			}
			$title = $element->getName();
			$permalink = umiHierarchy::getInstance()->getPathById($id);
			$image = $element->getValue('photo');
			$description = $element->getValue('short_description');
			$emarket = cmsController::getInstance()->getModule("emarket");
			$price = $emarket->getPrice($element);

			$products[$id] = array(
				'title' => $title,
				'description' => $description,
				'permalink' => $permalink,
				'image' => $image,
				'price' => $price
			);

		}

		return def_module::parseTemplate("", array(
			'products' => $products
		));

	}

}