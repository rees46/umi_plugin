<?php
/**
 * User: nixx
 * Date: 25.11.13
 * Time: 15:41
 */
abstract class __rees46_adm extends baseModuleAdmin {
	public function tree() {
		//Получение id родительской страницы. Если передан неверный id, будет выброшен exception
		$parent_id = $this->expectElementId('param0');

		$per_page = 25;
		$curr_page = getRequest('p');

		//Подготавливаем выборку
		$sel = new selector('pages');
		$sel->types('hierarchy-type')->name('comments', 'comment');
		$sel->limit($per_page, $curr_page);

		// фильтр по автору
		$filter_author_id = intval(getRequest('filter_author_id'));
		if ($filter_author_id) {
			$sel->where('author_id')->equals($filter_author_id);
		}

		//Выполняем выборку. В $result теперь будет лежать массив id страниц - результат выборки
		$result = $sel->result();
		$total = $sel->length();

		//Вывод данных
		//Устанавливаем тип для вывода данных в "list" - список
		$this->setDataType("list");

		//Устанавливаем действие над списокм - "view" - просмотр списка
		$this->setActionType("view");

		//Указываем диапозон данных
		$this->setDataRange($per_page, $curr_page * $per_page);

		//Подготавливаем данные, чтобы потом корректно их вывести
		$data = $this->prepareData($result, "pages");

		//Завершаем вывод
		$this->setData($data, $total);

		return $this->doData();
	}
}