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

    public function getPatientDataProvider(): string
    {
        return '<GetPatientResponse xmlns=\"http://tempuri.org/\"> <GetPatientResult xmlns:a=\"http://schemas.datacontract.org/2004/07/EMKService.Data.Dto\" xmlns:i=\"http://www.w3.org/2001/XMLSchema-instance\"> <a:PatientDto> <a:Addresses/> <a:BirthDate>1987-01-10T00:00:00</a:BirthDate> <a:BirthPlace/> <a:ContactPerson/> <a:Contacts/> <a:DeathTime/> <a:Documents/> <a:FamilyName>Новикова</a:FamilyName> <a:GivenName>Алиса</a:GivenName> <a:IdBloodType/> <a:IdGlobal>f341c5bc-2427-40ec-afa8-ff0ab1dcf18c</a:IdGlobal> <a:IdLivingAreaType/> <a:IdPatientMIS>1212</a:IdPatientMIS> <a:IsVip>false</a:IsVip> <a:Job/> <a:MiddleName>Дмитриевна</a:MiddleName> <a:Privilege/> <a:Sex>2</a:Sex> <a:SocialGroup/> <a:SocialStatus/> </a:PatientDto> </GetPatientResult> </GetPatientResponse>';
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
        self::assertEquals('', $response->getBody()->getContents());
        self::assertEquals(201, $response->getStatusCode());
    }

    /**
     * @dataProvider getPatientDataProvider
     * @covers ::getPatient
     *
     * @throws \DocDoc\RgsApiClient\Exception\InternalErrorRgsException
     * @throws \DocDoc\RgsApiClient\Exception\BaseRgsException
     */
    public function testGetPatient(string $extendedString): void
    {
        $response = $this->client->getPatient(1212);
        self::assertEquals($extendedString, $response->getBody()->getContents());
    }

    /**
     * @covers ::updatePatient
     *
     * @throws \DocDoc\RgsApiClient\Exception\InternalErrorRgsException
     * @throws \DocDoc\RgsApiClient\Exception\BaseRgsException
     */
    public function testUpdatePatient(): void
    {
        $response = $this->client->updatePatient($this->buildPatientDTO());
        self::assertEquals('', json_decode($response->getBody()->getContents(), true));
        self::assertEquals(201, $response->getStatusCode());
    }

    /**
     * @return Patient
     */
    private function buildPatientDTO(): Patient
    {
        $patient = new Patient();
        $patient->setGivenName('Анастасия')
            ->setFamilyName('Успенская')
            ->setMiddleName('Васильевна')
            ->setIdPatientMIS('1212')
            ->setSex(2)
            ->setBirthDate('1990-06-20');

        return $patient;
    }
}
