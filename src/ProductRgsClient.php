<?php

declare(strict_types=1);

namespace DocDoc\RgsApiClient;

use DocDoc\RgsApiClient\Exception\BadRequestRgsException;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\Exception\InternalErrorRgsException;
use DocDoc\RgsApiClient\ValueObject\Product\Product;
use Psr\Http\Message\ResponseInterface;

/**
 * Клиент для настроек продукта в системе РГС.
 * Обновляет настройки продукта для всех пользователей этого продукта.
 */
class ProductRgsClient extends AbstractRgsClient
{
	/**
	 * Обновление настроек продукта
	 *
	 * @param Product $product
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 * @throws InternalErrorRgsException
	 */
	public function updateProduct(Product $product): ResponseInterface
	{
		$request = $this->buildRequest(
			'PATCH',
			'/api/v1/product/' . $product->getProductId() . '/update',
			(string)json_encode($product)
		);
		return $this->send($request);
	}
}
