<?php

namespace DocDoc\RgsApiClient\test;

use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Enum\IEMK\MimeTypeEnum;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\Exception\InternalErrorRgsException;
use DocDoc\RgsApiClient\IemkStatisticsRgsClient;
use DocDoc\RgsApiClient\ValueObject\IEMK\Statistics\DocumentAttachment;
use DocDoc\RgsApiClient\ValueObject\IEMK\Statistics\HumanName;
use DocDoc\RgsApiClient\ValueObject\IEMK\Statistics\Initiator;
use DocDoc\RgsApiClient\ValueObject\IEMK\Statistics\MedicalStaff;
use DocDoc\RgsApiClient\ValueObject\IEMK\Statistics\MedRecord;
use DocDoc\RgsApiClient\ValueObject\IEMK\Statistics\Participant;
use DocDoc\RgsApiClient\ValueObject\IEMK\Statistics\Person;
use DocDoc\RgsApiClient\ValueObject\IEMK\Statistics\TelemedCase;
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
    public function testCreateCase(TelemedCase $tmc): void
    {
        $response = $this->client->createTelemedCase($tmc);
        self::assertEquals(json_decode($response->getBody()->getContents(), true), []);
    }

    /**
     * @dataProvider telemedCaseDataProvider
     * @covers ::updateTelemedCase
     *
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function testUpdateCase(TelemedCase $tmc): void
    {
        $response = $this->client->createTelemedCase($tmc);
        self::assertEquals(json_decode($response->getBody()->getContents(), true), []);
    }

    public function telemedCaseDataProvider(): TelemedCase
    {
        $tmc = new TelemedCase();

        $tmc->setOpenDate('2020-12-09T22:49:26.767Z')
            ->setCloseDate('2020-12-09T22:49:26.767Z')
            ->setHistoryNumber('141618')
            ->setIdCaseMis('1416180')
            ->setIdPaymentType(3)
            ->setConfidentiality(2)
            ->setDoctorConfidentiality(2)
            ->setCuratorConfidentiality(2)
            ->setIdCaseResult(2)
            ->setComment('Текст заключения')
            ->setIdPatientMis('9080')
            ->setTmcID('23456')
            ->setTmcForm(2)
            ->setTmcGoal(2)
            ->setDoctorInCharge($this->createMedicalStaff())
            ->setAuthenticator($this->createParticipant())
            ->setAuthor($this->createParticipant())
            ->setInitiator($this->createInitiator())
            ->setMedRecords([$this->createMedRecords()]);

        return $tmc;
    }

    protected function createMedicalStaff(): MedicalStaff
    {
        $medStaff = new MedicalStaff();
        $medStaff->setIdSpeciality(2)
            ->setIdPosition(59)
            ->setPerson($this->createPerson());

        return $medStaff;
    }

    protected function createParticipant(): Participant
    {
        $participant = new Participant();
        $participant->setIdRole(3)->setDoctor($this->createMedicalStaff());

        return $participant;
    }

    protected function createPerson(): Person
    {
        $humanName = new HumanName();
        $humanName->setFamilyName('Тестовый')->setGivenName('Пациент');

        $person = new Person();
        $person->setHumanName($humanName)->setIdPersonMis('1717');

        return $person;
    }

    protected function createInitiator(): Initiator
    {
        $initiator = new Initiator();
        $initiator->setInitiatorType(3)->setDoctor($this->createMedicalStaff());

        return $initiator;
    }

    /**
     * @return MedRecord[]
     */
    protected function createMedRecords(): array
    {
        $attach = new DocumentAttachment();
        $attach->setData('Данные вложения (текст, pdf, html,xml) в формате base64binary')
            ->setMimeType(MimeTypeEnum::PDF);

        $medRecord = new MedRecord();
        $medRecord->setAuthor($this->createMedicalStaff())
            ->setIdDocumentMis('9090')
            ->setCreationDate('2020-12-09T22:49:26.768Z')
            ->setHeader('Заголовок документа')
            ->setAttachments([$attach]);

        return [$medRecord];
    }
}
