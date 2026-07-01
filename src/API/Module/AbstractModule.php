<?php

namespace QuadVector\AdvantaShopClient\API\Module;

use GuzzleHttp\Exception\GuzzleException;
use QuadVector\AdvantaShopClient\API\Client;
use QuadVector\AdvantaShopClient\Exception\APIException;

/**
 * Абстрактный класс-обертка для работы с тем или иным модулем AdvantaShop
 */
abstract class AbstractModule
{
	public const string API_URL = "/api";

	/**
	 * Конструктор
	 * @param Client $client Экземпляр SDK-клиента
	 */
	public function __construct(
		protected Client $client,
	) {}

	/**
	 * Декодировать ответ в формате JSON и преобразовать в массив
	 * 
	 * @param string $body Содержимое ответа в виде строки
	 * @return array
	 */
	private function decodeResponse(string $body): array
	{
		$result = json_decode($body, true);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new APIException(json_last_error_msg());
		}

		if (!is_array($result)) {
			throw new APIException("Response is not an array");
		}

		return $result;
	}

	/**
	 * Выполнить GET-запрос
	 * 
	 * @param string $url Ссылка
	 * @param array<string, mixed> $query Параметры
	 * @return array
	 */
	protected function get(string $url, array $query = []): array
	{
		try {
			$query["key"] = $this->client->apiKey;
			$response = $this->client->getHTTPClient()->get($url, $query);

			return $this->decodeResponse($response->getBody()->getContents());
		} catch (GuzzleException $ex) {
			throw new APIException($ex->getMessage());
		}
	}

	/**
	 * Выполнить POST-запрос
	 * 
	 * @param string $url Ссылка
	 * @param array<string, mixed> $query Параметры
	 * @return array
	 */
	protected function post(string $url, array $query = []): array
	{
		try {
			$query["key"] = $this->client->apiKey;
			$response = $this->client->getHTTPClient()->post($url, [
				"form_params" => $query,
			]);

			return $this->decodeResponse($response->getBody()->getContents());
		} catch (GuzzleException $ex) {
			throw new APIException($ex->getMessage());
		}
	}

	/**
	 * Выполнить PUT-запрос
	 * 
	 * @param string $url Ссылка
	 * @param array<string, mixed> $query Параметры
	 * @return array
	 */
	protected function put(string $url, array $query = []): array
	{
		try {
			$query["key"] = $this->client->apiKey;
			$response = $this->client->getHTTPClient()->put($url, [
				"form_params" => $query,
			]);

			return $this->decodeResponse($response->getBody()->getContents());
		} catch (GuzzleException $ex) {
			throw new APIException($ex->getMessage());
		}
	}
}
