<?php

namespace DocDoc\RgsApiClient\test;

use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\Exception\InternalErrorRgsException;
use DocDoc\RgsApiClient\IemkStatisticsRgsClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @coversDefaultClass \DocDoc\RgsApiClient\IemkStatisticsRgsClient
 */
class IemkStatisticsRgsClientTest extends TestCase
{
    /** @var IemkStatisticsRgsClient */
    private $client;

    public function setUp(): void
    {
        parent::setUp();
        $rgsApiParams = $this->createMock(RgsApiParamsInterface::class);
        // Mock server Apiary
        $rgsApiParams->method('getHost')->willReturn('https://private-63631f-chronicmonitor.apiary-mock.com/');
        $rgsApiParams->method('getPartnerId')->willReturn(241);

        $this->client = new IemkStatisticsRgsClient(
            new Client(),
            $rgsApiParams,
            $this->createMock(LoggerInterface::class)
        );
    }

    /**
     * @dataProvider telemedCaseDataProvider
     * @covers ::createTelemedCase
     *
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function testCreateCase(string $extendedJson): void
    {
        $response = $this->client->createTelemedCase($extendedJson);
        self::assertEquals(json_decode($response->getBody()->getContents(), true), []);
    }

    /**
     * @dataProvider telemedCaseDataProvider
     * @covers ::updateTelemedCase
     *
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function testUpdateCase(string $extendedJson): void
    {
        $response = $this->client->createTelemedCase($extendedJson);
        self::assertEquals(json_decode($response->getBody()->getContents(), true), []);
    }

    public function telemedCaseDataProvider(): array
    {
        return [
            [
                '{
                  "OpenDate": "2020-12-09T22:49:26.767Z",
                  "CloseDate": "2020-12-09T22:49:26.767Z",
                  "HistoryNumber": "141618",
                  "IdCaseMis": "1416180",
                  "IdPaymentType": 3,
                  "Confidentiality": 2,
                  "DoctorConfidentiality": 2,
                  "CuratorConfidentiality": 2,
                  "IdCaseResult": 2,
                  "Comment": "Текст заключения",
                  "DoctorInCharge": {
                    "IdSpeciality": 2,
                    "IdPosition": 59,
                    "Person": {
                      "HumanName": {
                        "FamilyName": "Тестовый",
                        "GivenName": "Пациент"
                      },
                      "IdPersonMis": "1717"
                    }
                  },
                  "Authenticator": {
                    "Doctor": {
                      "IdSpeciality": 2,
                      "IdPosition": 59,
                      "Person": {
                        "HumanName": {
                          "FamilyName": "Тестовый",
                          "GivenName": "Пациент"
                        },
                        "IdPersonMis": "1717"
                      }
                    },
                    "IdRole": 3
                  },
                  "Author": {
                    "Doctor": {
                      "IdSpeciality": 2,
                      "IdPosition": 59,
                      "Person": {
                        "HumanName": {
                          "FamilyName": "Тестовый",
                          "GivenName": "Пациент"
                        },
                        "IdPersonMis": "1717"
                      }
                    },
                    "IdRole": 3
                  },
                  "IdPatientMis": "9080",
                  "TmcID": "23456",
                  "TmcForm": 2,
                  "TmcGoal": 2,
                  "Initiator": {
                    "InitiatorType": 3,
                    "Doctor": {
                      "IdSpeciality": 2,
                      "IdPosition": 59,
                      "Person": {
                        "HumanName": {
                          "FamilyName": "Тестовый",
                          "GivenName": "Пациент"
                        },
                        "IdPersonMis": "1717"
                      }
                    }
                  },
                  "MedRecords": [
                    {
                      "Author": {
                        "IdSpeciality": 2,
                        "IdPosition": 59,
                        "Person": {
                          "HumanName": {
                            "FamilyName": "Тестовый",
                            "GivenName": "Пациент"
                          },
                          "IdPersonMis": "1717"
                        }
                      },
                      "CreationDate": "2020-12-09T22:49:26.768Z",
                      "Header": "Заголовок документа",
                      "IdDocumentMis": "9090",
                      "Attachments": [
                        {
                          "Data": "Данные вложения (текст, pdf, html,xml) в формате base64binary",
                          "MimeType": "application/pdf"
                        }
                      ]
                    }
                  ]
                }',
            ],
        ];
    }
}
