<?php

namespace DocDoc\RgsApiClient;

use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Exception\BadRequestRgsException;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\Exception\InternalErrorRgsException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Абстрактный Клиент для работы с API РГС
 * Содержит в себе отправку, валидацию ответов, логирование запросов.
 *
 * @see https://chronicmonitor.docs.apiary.io/#reference/
 */
abstract class AbstractRgsClient
{
	/** @var ClientInterface */
	private $client;

	/** @var RgsApiParamsInterface */
	protected $apiParams;

	/** @var LoggerInterface */
	private $logger;

	/**
	 * @param ClientInterface       $client
	 * @param RgsApiParamsInterface $apiParams
	 * @param LoggerInterface       $logger
	 */
	public function __construct(
		ClientInterface $client,
		RgsApiParamsInterface $apiParams,
		LoggerInterface $logger
	) {
		$this->client = $client;
		$this->apiParams = $apiParams;
		$this->logger = $logger;
	}

	/**
	 * @param RequestInterface $request
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 * @throws InternalErrorRgsException
	 */
	protected function send(RequestInterface $request): ResponseInterface
	{
		try {
			$response = $this->sendRequest($request);
			$request->getBody()->rewind();
			$this->logger->info(
				'Отправлен запрос партнеру РГС',
				[
					'partnerId' => $this->apiParams->getPartnerId(),
					'url' => $request->getUri(),
					'request' => $request->getBody()->getContents()
				]
			);
		} catch (BaseRgsException $e) {
			$request->getBody()->rewind();
			$response = $e->getResponse();
			$response->getBody()->rewind();
			$this->logger->error(
				$e->getMessage(),
				[
					'partnerId' => $this->apiParams->getPartnerId(),
					'url' => $request->getUri(),
					'request' => $request->getBody()->getContents(),
					'responseBody' => $response ? $response->getBody()->getContents() : null,
					'exception' => $e,
				]
			);
			throw $e;
		}
		return $response;
	}

	/**
	 * Отправка запроса и отлов ошибок
	 *
	 * @param RequestInterface $request
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws InternalErrorRgsException
	 */
	public function sendRequest(RequestInterface $request): ResponseInterface
	{
		try {
			$response = $this->client->send($request);
			if ($response === null) {
				throw new BadRequestRgsException('РГС сервис не прислал ответ.');
			}
			return $response;
		} catch (ClientException $e) {
			throw new InternalErrorRgsException($e->getResponse(), 'Ошибка 4xx при запросе к партнёру РГС');
		} catch (ServerException $e) {
			$request->getBody()->rewind();
			$response = $e->getResponse();
			$response->getBody()->rewind();
			$this->logger->error(
				'Ошибка 5xx при запросе к партнёру РГС',
				[
					'partnerId' => $this->apiParams->getPartnerId(),
					'url' => $request->getUri(),
					'request' => $request->getBody()->getContents(),
					'responseBody' => $response ? $response->getBody()->getContents() : null,
					'exception' => $e,
				]
			);
			throw new BadRequestRgsException('Ошибка 5xx при запросе к партнёру РГС', 0, $e);
		} catch (GuzzleException $e) {
			$this->logger->error(
				'Критическая не известная ошибка при запросе к партнёру РГС',
				[
					'partnerId' => $this->apiParams->getPartnerId(),
					'url' => $request->getUri(),
					'request' => $request->getBody()->getContents(),
					'responseBody' => $response ? $response->getBody()->getContents() : null,
					'exception' => $e,
				]
			);
			throw new BadRequestRgsException('Критическая ошибка при запросе к партнёру РГС', 0, $e);
		}
	}

	/**
	 * Сборка объекта запроса
	 *
	 * @param string $method
	 * @param string $url
	 * @param string $body
	 *
	 * @return Request
	 */
	protected function buildRequest(string $method, string $url, string $body): Request
	{
		return new Request(
			$method,
			rtrim($this->apiParams->getHost(), '/') . '/' . ltrim($url, '/'),
			[
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
			],
			$body,
			'2.0'
		);
	}
}
