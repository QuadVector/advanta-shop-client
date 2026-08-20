<?php

namespace QuadVector\AdvantaShopClient\API\Module;

class Products extends AbstractModule
{
	public const string MODULE_URL = "/products";

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
	 * Получить информацию о товаре
	 *
	 * GET /api/products/{id}
	 *
	 * Пример query:
	 * [
	 *     "colorId" => 1,
	 *     "sizeId" => 2
	 * ]
	 *
	 * @param int $id ID товара
	 * @param array<string, mixed> $query Дополнительные параметры запроса
	 *
	 * @return array|bool
	 */
	public function getProduct(int $id, array $query = []): array|bool
	{
		$response = $this->get($this->getRequestURL() . "/" . $id, $query, "authApiKey");

		if ($response && is_array($response)) {
			return $response;
		}

		return false;
	}

	/**
	 * Получить характеристики товара
	 *
	 * GET /api/products/{id}/properties
	 *
	 * Пример query:
	 * [
	 *     "type" => "inDetails"
	 * ]
	 *
	 * Возможные значения type:
	 * - inDetails — свойства в карточке товара
	 * - inBriefDescription — свойства в брифе
	 *
	 * Если type не указан, по умолчанию используется inDetails.
	 *
	 * @param int $id ID товара
	 * @param string|null $type Тип свойств
	 *
	 * @return array|bool
	 */
	public function getProperties(int $id, ?string $type = null): array|bool
	{
		$query = [];

		if ($type !== null) {
			$query["type"] = $type;
		}

		$response = $this->get($this->getRequestURL() . "/" . $id . "/properties", $query, "authApiKey");

		if ($response && is_array($response)) {
			return $response;
		}

		return false;
	}

	/**
	 * Получить свойства товара для карточки товара
	 *
	 * GET /api/products/{id}/properties?type=inDetails
	 *
	 * @param int $id ID товара
	 *
	 * @return array|bool
	 */
	public function getDetailProperties(int $id): array|bool
	{
		return $this->getProperties($id, "inDetails");
	}

	/**
	 * Получить свойства товара для краткого описания
	 *
	 * GET /api/products/{id}/properties?type=inBriefDescription
	 *
	 * @param int $id ID товара
	 *
	 * @return array|bool
	 */
	public function getBriefProperties(int $id): array|bool
	{
		return $this->getProperties($id, "inBriefDescription");
	}
}
