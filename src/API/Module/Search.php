<?php

namespace QuadVector\AdvantaShopClient\API\Module;

class Search extends AbstractModule
{
	public const string MODULE_URL = "/search";

	/**
	 * Получить полную ссылку к модулю API
	 *
	 * @return string
	 */
	protected function getRequestURL(): string
	{
		return self::API_URL . self::MODULE_URL;
	}

	/**
	 * Поиск товаров
	 *
	 * POST /api/search
	 *
	 * Пример payload:
	 * [
	 *     'query' => 'Красное платье',
	 *     'page' => 1,
	 *     'brandIds' => [1, 2],
	 *     'colorIds' => [3],
	 *     'sizeIds' => [4, 5],
	 *     'propertyLists' => [[1, 2], [3, 4, 5], [7]],
	 *     'propertyRanges' => [
	 *         ['id' => 397, 'min' => 1.1, 'max' => 3],
	 *     ],
	 *     'priceFrom' => 100,
	 *     'priceTo' => 5000,
	 *     'available' => true,
	 *     'sorting' => 'DescByPopular',
	 *     'showHtmlPrice' => false,
	 *     'warehouseIds' => [1, 2],
	 * ]
	 *
	 * @param array<string, mixed> $data
	 * @return array|bool
	 */
	public function search(array $data): array|bool
	{
		// массив должен иметь хотя бы один элемент
		if (count($data) > 0) {
			$response = $this->post($this->getRequestURL(), $data, "authApiKey");

			if ($response && is_array($response)) {
				return $response;
			}
		}
		return false;
	}
}
