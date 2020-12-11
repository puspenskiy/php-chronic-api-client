<?php

namespace DocDoc\RgsApiClient\test;

use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\IemkPatientRgsClient;
use DocDoc\RgsApiClient\ValueObject\IEMK\Patient\Patient;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

/**
 * @coversDefaultClass \DocDoc\RgsApiClient\IemkPatientRgsClient
 */
class IemkPatientRgsClientTest extends TestCase
{
    /** @var IemkPatientRgsClient */
    private $client;

    public function setUp(): void
    {
        parent::setUp();
        $rgsApiParams = $this->createMock(RgsApiParamsInterface::class);
        // Mock server Apiary
        $rgsApiParams->method('getHost')->willReturn('https://private-63631f-chronicmonitor.apiary-mock.com/');
        $rgsApiParams->method('getPartnerId')->willReturn(241);

        $this->client = new IemkPatientRgsClient(
            new Client(),
            $rgsApiParams,
            $this->createMock(LoggerInterface::class)
        );
    }

    public function getPatientDataProvider(): array
    {
        return [
            [
                '{
                  "FamilyName": "Фамилия",
                  "GivenName": "Имя",
                  "Sex": 2,
                  "BirthDate": "2020-12-09",
                  "IdPatientMIS": "2309",
                  "MiddleName": "Отчество"
                }',
            ],
        ];
    }

    /**
     * @covers ::createPatient
     *
     * @throws \DocDoc\RgsApiClient\Exception\InternalErrorRgsException
     * @throws \DocDoc\RgsApiClient\Exception\BaseRgsException
     */
    public function testCreatePatient(): void
    {
        $response = $this->client->createPatient($this->buildPatientDTO());
        self::assertEquals(json_decode($response->getBody()->getContents(), true), []);
    }

    /**
     * @dataProvider getPatientDataProvider
     * @covers ::getPatient
     *
     * @throws \DocDoc\RgsApiClient\Exception\InternalErrorRgsException
     * @throws \DocDoc\RgsApiClient\Exception\BaseRgsException
     */
    public function testGetPatient(string $extendedJson): void
    {
        $response = $this->client->getPatient('1212');
        self::assertEquals(json_decode($response->getBody()->getContents(), true), $extendedJson);
    }

    /**
     * @covers ::updatePatient
     *
     * @throws \DocDoc\RgsApiClient\Exception\InternalErrorRgsException
     * @throws \DocDoc\RgsApiClient\Exception\BaseRgsException
     */
    public function updatePatient(string $expectedResponseData): void
    {
        $response = $this->client->updatePatient($this->buildPatientDTO());
        self::assertEquals(json_decode($response->getBody()->getContents(), true), []);
    }

    /**
     * @return Patient
     */
    private function buildPatientDTO(): Patient
    {
        $patient = new Patient();
        $patient->setGivenName('Анастасия');
        $patient->setFamilyName('Успенская');
        $patient->setMiddleName('Васильевна');
        $patient->setIdPatientMIS('1212');
        $patient->setSex(2);
        $patient->setBirthDate('1990-06-20');

        return $patient;
    }
}
