<?php

namespace DocDoc\RgsApiClient;

use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\Exception\InternalErrorRgsException;
use DocDoc\RgsApiClient\ValueObject\IEMK\Patient\Patient;
use Psr\Http\Message\ResponseInterface;

/**
 * Класс взаимодействия с РГС ИЭМК Модуль пациенты
 * Класс является проксирующим, поэтому на выходе всех методов будет ResponseInterface
 *
 * @see https://chronicmonitor.docs.apiary.io/#reference/iemk/patient
 */
class IemkPatientRgsClient extends AbstractRgsClient
{
    /**
     * Получить список всех доступных функций сервиса Netrika ИЭМК (Модуль пациент)
     *
     * @return ResponseInterface
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function getFunctions(): ResponseInterface
    {
        $url = '/api/v1/iemk/patient/functions';
        $request = $this->buildRequest('GET', $url);

        return $this->send($request);
    }

    /**
     * Получить пациента из ЕГИСЗ ИЭМК
     *
     * @param int $externalId
     *
     * @return ResponseInterface
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     * @see CategoryEnum
     *
     */
    public function getPatient(int $externalId): ResponseInterface
    {
        $url = '/api/v1/iemk/patient/' . $externalId;
        $request = $this->buildRequest('GET', $url, '');

        return $this->send($request);
    }

    /**
     * Создать пациента в сервисе ЕГИСЗ ИЭМК (Модуль пациент)
     *
     * @param Patient $patient
     *
     * @return ResponseInterface
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function createPatient(Patient $patient): ResponseInterface
    {
        $request = $this->buildRequest('POST', '/api/v1/iemk/patient', json_encode($patient->toArray()));

        return $this->send($request);
    }

    /**
     * Перезаписать данные пациента в ЕГИСЗ ИЭМК (Модуль пациент)
     *
     * @param Patient $patient
     *
     * @return ResponseInterface
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function updatePatient(Patient $patient): ResponseInterface
    {
        $url = '/api/v1/iemk/patient';
        $request = $this->buildRequest('PATCH', $url, json_encode($patient->toArray()));

        return $this->send($request);
    }
}
