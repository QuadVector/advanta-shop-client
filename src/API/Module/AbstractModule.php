<?php

namespace QuadVector\AdvantaShopClient\API\Module;

use GuzzleHttp\Exception\GuzzleException;
use QuadVector\AdvantaShopClient\API\AdvantaClient;
use QuadVector\AdvantaShopClient\Exception\APIException;

/**
 * Абстрактный класс-обертка для работы с тем или иным модулем AdvantaShop
 */
abstract class AbstractModule
{
	public const string API_URL = "/api";

	/**
	 * Конструктор
	 * @param AdvantaClient $client Экземпляр клиента Advanta
	 */
	public function __construct(
		protected AdvantaClient $client,
	) {}

	abstract protected function getRequestURL(): string;

	/**
	 * Декодировать ответ в формате JSON и преобразовать в массив
	 * 
	 * @param string $body Содержимое ответа в виде строки
	 * @return array
	 * 
	 * @throws APIException
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
	 * @param string $keyName Имя ключа, который будет задействован в запросе (обычный apiKey или authApiKey)
	 * 
	 * @return array
	 * 
	 * @throws APIException
	 */
	protected function get(string $url, array $query = [], string $keyName = "apiKey"): array
	{
		try {
			if (isset($this->client->$keyName)) {
				$query["apikey"] = $this->client->$keyName;
			} else {
				throw new APIException("API key is not set");
			}

			$response = $this->client->getHTTPClient()->get($url, [
				"query" => $query,
			]);

			return $this->decodeResponse($response->getBody()->getContents());
		} catch (GuzzleException $ex) {
			throw new APIException($ex->getMessage());
		}
	}


	/**
	 * Выполнить POST-запрос
	 * 
	 * @param string $url Ссылка
	 * @param array<string, mixed> $data Данные тела запроса
	 * @param string $keyName Имя ключа, который будет задействован в запросе (обычный apiKey или authApiKey)
	 * 
	 * @return array
	 * 
	 * @throws APIException
	 */
	protected function post(string $url, array $data = [], string $keyName = "apiKey"): array
	{
		try {
			if (isset($this->client->$keyName)) {
				$query["apikey"] = $this->client->$keyName;
			} else {
				throw new APIException("API key is not set");
			}

			$response = $this->client->getHTTPClient()->post($url, [
				"query" => $query,
				"json" => $data,
			]);

			return $this->decodeResponse($response->getBody()->getContents());
		} catch (GuzzleException $ex) {
			throw new APIException($ex->getMessage());
		}
	}

	/**
	 * Выполнить POST-запрос с multipart/form-data
	 *
	 * @param string $url Ссылка
	 * @param array<int, array<string, mixed>> $multipart Данные multipart
	 * @param string $keyName Имя ключа, который будет задействован в запросе (обычный apiKey или authApiKey)
	 * 
	 * @return array
	 *
	 * @throws APIException
	 */
	protected function postMultipart(string $url, array $multipart, string $keyName = "apiKey"): array
	{
		try {
			if (isset($this->client->$keyName)) {
				$query["apikey"] = $this->client->$keyName;
			} else {
				throw new APIException("API key is not set");
			}

			$response = $this->client->getHTTPClient()->post($url, [
				"query" => [
					"apikey" => $this->client->apiKey,
				],
				"multipart" => $multipart,
			]);

			return $this->decodeResponse(
				$response->getBody()->getContents()
			);
		} catch (GuzzleException $ex) {
			throw new APIException($ex->getMessage());
		}
	}

	/**
	 * Выполнить PUT-запрос
	 * 
	 * @param string $url Ссылка
	 * @param array<string, mixed> $data Данные тела запроса
	 * @param string $keyName Имя ключа, который будет задействован в запросе (обычный apiKey или authApiKey)
	 * 
	 * @return array
	 * 
	 * @throws APIException
	 */
	protected function put(string $url, array $data = [], string $keyName = "apiKey"): array
	{
		try {
			if (isset($this->client->$keyName)) {
				$query["apikey"] = $this->client->$keyName;
			} else {
				throw new APIException("API key is not set");
			}

			$response = $this->client->getHTTPClient()->put($url, [
				"query" => $query,
				"json" => $data,
			]);

			return $this->decodeResponse($response->getBody()->getContents());
		} catch (GuzzleException $ex) {
			throw new APIException($ex->getMessage());
		}
	}
}
