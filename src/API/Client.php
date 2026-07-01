<?php

namespace QuadVector\AdvantaShopClient\API;

use GuzzleHttp\Client as GuzzleClient;
use QuadVector\AdvantaShopClient\API\Module\Categories;

final class Client
{
	private GuzzleClient $HTTPClient; // Клиент Guzzle
	private ?Categories $categoriesModule = null; // экземпляр модуля категорий

	/**
	 * Конструктор
	 * 
	 * @param string $baseURL Основная ссылка на действующий API адванты
	 * @param string $apiKey Ключ API
	 */
	public function __construct(
		public string $baseURL,
		public string $apiKey
	) {
		$this->HTTPClient = new GuzzleClient([
			'base_uri' => $this->baseURL,
		]);
	}

	/**
	 * Получить текущий клиент Guzzle
	 * 
	 * @return GuzzleClient
	 */
	public function getHTTPClient(): GuzzleClient
	{
		return $this->HTTPClient;
	}

	/**
	 * Ленивая загрузка модуля категорий
	 * 
	 * @return Categories
	 */
	public function categories(): Categories
	{
		return $this->categoriesModule ??= new Categories($this);
	}
}
