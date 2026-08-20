<?php

namespace QuadVector\AdvantaShopClient\API;

use GuzzleHttp\Client;
use QuadVector\AdvantaShopClient\API\Module\Categories;
use QuadVector\AdvantaShopClient\API\Module\Products;
use QuadVector\AdvantaShopClient\API\Module\Search;

final class AdvantaClient
{
	private Client $HTTPClient; // Клиент Guzzle
	private ?Categories $categoriesModule = null; // экземпляр модуля категорий
	private ?Products $productsModule = null; // экземпляр модуля товаров
	private ?Search $searchModule = null; // экземпляр модуля поиска

	/**
	 * Конструктор
	 * 
	 * @param string $baseURL Основная ссылка на действующий API адванты (c протоколом)
	 * @param string $apiKey Ключ API
	 * @param string $authApiKey Ключ API с авторизацией
	 */
	public function __construct(
		public string $baseURL,
		public ?string $apiKey,
		public ?string $authApiKey
	) {
		// обработка baseURL
		// автоматически убираем слеш в конце
		$baseURL = rtrim($this->baseURL, "/");

		$this->HTTPClient = new Client([
			'base_uri' => $this->baseURL,
		]);
	}

	/**
	 * Получить текущий клиент Guzzle
	 * 
	 * @return Client
	 */
	public function getHTTPClient(): Client
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

	/**
	 * Ленивая загрузка модуля товаров
	 * 
	 * @return Products
	 */
	public function products(): Products
	{
		return $this->productsModule ??= new Products($this);
	}

	/**
	 * Ленивая загрузка модуля товаров
	 * 
	 * @return Search
	 */
	public function search(): Search
	{
		return $this->searchModule ??= new Search($this);
	}
}
