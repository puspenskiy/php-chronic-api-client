<?php

namespace DocDoc\RgsApiClient;

use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\Exception\InternalErrorRgsException;
use DocDoc\RgsApiClient\ValueObject\IEMK\Statistics\TelemedCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Класс взаимодействия с РГС ИЭМК Модуль статистика
 * Класс является проксирующим, поэтому на выходе всех методов будет ResponseInterface
 *
 * @see https://chronicmonitor.docs.apiary.io/#reference/iemk/statistics
 */
class IemkStatisticsRgsClient extends AbstractRgsClient
{
    /**
     * Получить список всех доступных функций сервиса Netrika ИЭМК (Модуль статистика)
     *
     * @return ResponseInterface
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function getFunctions(): ResponseInterface
    {
        $url = '/api/v1/iemk/statistics/functions';
        $request = $this->buildRequest('GET', $url);

        return $this->send($request);
    }

    /**
     * Добавить информацию о телемед-консультации в серси ЕГИСЗ ИЭМК (Модуль статистика)
     *
     * @param TelemedCase $telemedCase
     *
     * @return ResponseInterface
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function createTelemedCase(TelemedCase $telemedCase): ResponseInterface
    {
        $request = $this->buildRequest('POST', '/api/v1/iemk/statistics/telemed-case', json_encode($telemedCase));

        return $this->send($request);
    }

    /**
     * Перезаписать информацию о телемед-консультации в серси ЕГИСЗ ИЭМК (Модуль статистика)
     *
     * @param TelemedCase $telemedCase
     *
     * @return ResponseInterface
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function updateTelemedCase(TelemedCase $telemedCase): ResponseInterface
    {
        $url = '/api/v1/iemk/statistics/telemed-case';
        $request = $this->buildRequest('PATCH', $url, json_encode($telemedCase));

        return $this->send($request);
    }
}
