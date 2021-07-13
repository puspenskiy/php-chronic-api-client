<?php

namespace DocDoc\RgsApiClient;

use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\Exception\InternalErrorRgsException;
use Psr\Http\Message\ResponseInterface;

class StatisticsRgsClient extends AbstractRgsClient
{
    /**
     * Получить статистику по продукту мониторинга из РГС
     *
     * @param int $productId
     *
     * @return ResponseInterface
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function getStatisticsByProduct(int $productId): ResponseInterface
    {
        $url = '/api/v1/statistics/' . $productId;
        $request = $this->buildRequest('GET', $url, '');

        return $this->send($request);
    }
}