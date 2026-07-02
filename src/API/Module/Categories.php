<?php

namespace QuadVector\AdvantaShopClient\API\Module;

use QuadVector\AdvantaShopClient\Helper\Text;

class Categories extends AbstractModule
{
	public const string MODULE_URL = "/categories";

	/**
	 * Получить полную ссылку к модулю API
	 * 
	 * @return string
	 */
	private function getRequestURL(): string
	{
		return self::API_URL . self::MODULE_URL;
	}

	/**
	 * Получить список категорий
	 * 
	 * @param array<string, mixed> $query
	 * @return array
	 */
	public function getList(array $query = []): array
	{
		return $this->get($this->getRequestURL(), $query);
	}

	/**
	 * Получить полный список категорий
	 * Данный метод будет выполнять обращение к API каждые 500 элементов до тех пор, пока список не закончится
	 * На выполнение операции может уйти некоторое время
	 * 
	 * @return array
	 */
	public function getFullList(): array
	{
		$result = [];

		$page = 1;
		do {
			// делаем запрос
			$response = $this->get($this->getRequestURL(), [
				"itemsPerPage" => 500,
				"page" => $page
			]);

			// формируем результат
			if ($response && isset($response["categories"])) {
				$result = array_merge($result, $response["categories"]);
			}

			$page++;
		} while ($response["pagination"]["count"] > 0);

		return $result;
	}

	/**
	 * Получить информацию о категории
	 * @param int $id ID категории
	 * 
	 * @return array|bool
	 */
	public function getCategory(int $id): array|bool
	{
		// делаем запрос
		$response = $this->get($this->getRequestURL() . "/" . $id);

		if ($response && isset($response["id"])) {
			return $response;
		} else {
			return false;
		}
	}

	/** 
	 * Редактировать категорию
	 * @param int $id ID категории
	 * @param array $data Данные, которые нужно изменить
	 * 
	 * @return array|bool
	 */
	public function editCategory(int $id, array $data): array|bool
	{
		// получаем информацию о категории
		$category = $this->getCategory($id);
		if (!$category) {
			return false;
		}

		$updateData = array_merge($category, $data); // итоговый массив, в котором содержатся все данные категории и данные, которые нужно изменить

		// делаем запрос
		$response = $this->post($this->getRequestURL() . "/" . $id, $updateData);

		return $response;
	}

	/**
	 * Создать категорию
	 * @param array $data Данные категории
	 * 
	 * Пример данных:
	 * [
	 * "parentCategoryId" => 0,
	 * "name" => "Категория",
	 * "url" => "new-category",
	 * "description" => "description",
	 * "briefDescription" => "brief description",
	 * "enabled" => true,
	 * "hidden" => false,
	 * "sortOrder" => 0,
	 * "sorting" => "nosorting",
	 * "showMode" => 1,
	 * "showBrandsInMenu" => false,
	 * "showSubCategoriesInMenu" => false,
	 * "showOnMainPage" => true,
	 * "modifiedBy" => "api"
	 * ]
	 * 
	 * @return array
	 */
	public function addCategory(array $data): array
	{
		// приводим url в ЧПУ, если его значение не указано изначально
		if (!isset($data["url"])) {
			$data["url"] = Text::translitRef($data["name"]);
		}

		// делаем запрос
		$response = $this->post($this->getRequestURL() . "/add", $data);

		return $response;
	}

	/**
	 * Удалить категорию
	 * @param int $id ID категории
	 * 
	 * @return array
	 */
	public function deleteCategory(int $id): array
	{
		// делаем запрос
		$response = $this->post($this->getRequestURL() . "/" . $id . "/delete");

		return $response;
	}
}
