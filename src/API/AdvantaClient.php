<?php

namespace QuadVector\AdvantaShopClient\API;

use GuzzleHttp\Client;
use QuadVector\AdvantaShopClient\API\Module\Categories;

final class AdvantaClient
{
	private Client $HTTPClient; // Клиент Guzzle
	private ?Categories $categoriesModule = null; // экземпляр модуля категорий

	/**
	 * Конструктор
	 * 
	 * @param string $baseURL Основная ссылка на действующий API адванты (c протоколом)
	 * @param string $apiKey Ключ API
	 */
	public function __construct(
		public string $baseURL,
		public string $apiKey
	) {
		// обработка baseURL
		// автоматически убираем слеш в конце
		$baseURL = rtrim($baseURL, "/");

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
}
