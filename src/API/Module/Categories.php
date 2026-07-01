<?php

namespace QuadVector\AdvantaShopClient\API\Module;

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
		return $this->get($this->getRequestURL() . "/list", $query);
	}
}
