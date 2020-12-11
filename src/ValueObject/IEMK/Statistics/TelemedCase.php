<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\Enum\IEMK\CaseResultEnum;
use DocDoc\RgsApiClient\Enum\IEMK\ConfidentialityEnum;
use DocDoc\RgsApiClient\Enum\IEMK\PaymentTypeEnum;
use DocDoc\RgsApiClient\Enum\IEMK\TelemedCaseFormEnum;
use DocDoc\RgsApiClient\Enum\IEMK\TelemedCaseGoalEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use DocDoc\RgsApiClient\ValueObject\IEMK\IemkValueObjectTrait;
use JsonSerializable;

class TelemedCase extends AbstractValidateValueObject implements JsonSerializable
{
    use IemkValueObjectTrait;

    /**
     * Дата открытия случая обслуживания (начала телемед-консультации)
     * @var string
     */
    private $openDate;

    /**
     * Дата закрытия случая обслуживания (окончание телемед-консультации)
     * @var string
     */
    private $closeDate;

    /**
     * Номер истории болезни/Амбулаторного талона
     * @var string
     */
    private $historyNumber;

    /**
     * Идентификатор телемед-консультации
     * @var string
     */
    private $idCaseMis;

    /**
     * Идентификатор источника финансирования (Cправочник OID: 1.2.643.2.69.1.1.1.32)
     * @var int
     */
    private $IdPaymentType;

    /**
     * Код уровня конфиденциальности по региональному справочнику (Cправочник OID: 1.2.643.2.69.1.1.1.90)
     * @var int
     */
    private $Confidentiality;

    /**
     * Код уровня конфиденциальности доктора по региональному справочнику (Cправочник OID: 1.2.643.2.69.1.1.1.90)
     * @var int
     */
    private $DoctorConfidentiality;

    /**
     * Код уровня конфиденциальности куратора по региональному справочнику (Cправочник OID: 1.2.643.2.69.1.1.1.90)
     * @var int
     */
    private $CuratorConfidentiality;

    /**
     * Идентификатор исхода заболевания (Справочник OID: 1.2.643.5.1.13.2.1.1.688)
     * @var int
     */
    private $IdCaseResult;

    /**
     * Текст заключения из эпикриза и/или другую важную медицинскую информацию в неструктурированном виде,
     * например, текст медицинского протокола. (Длина не ограничена)
     * @var string
     */
    private $Comment;

    /**
     * Информация о лечащем враче
     * @var MedicalStaff
     */
    private $DoctorInCharge;

    /**
     * Лицо, подписывающее или визирующее формируемый набор медицинской информации
     * @var Participant
     */
    private $Authenticator;

    /**
     * Лицо, являющееся автором передаваемого набора медицинской информации (как правило, лечащий врач)
     * @var Participant
     */
    private $Author;

    /**
     * Внешний идентификатор пациента (External id)
     * @var string
     */
    private $IdPatientMis;

    /**
     * Глобальный идентификатор направления в Телемедицинской подсистеме.
     * Идентификатор телемед-консультации.
     * @var string
     */
    private $TmcID;

    /**
     * Форма телемедицинской консультации (Справочник OID: 1.2.643.2.69.1.1.1.54)
     * @var int
     */
    private $TmcForm;

    /**
     * Цель телемедицинской консультации (Cправочник OID: 1.2.643.2.69.1.1.1.128)
     * @var int
     */
    private $TmcGoal;

    /**
     * Инициатор телемедицинской консультации
     * @var Initiator
     */
    private $Initiator;

    /**
     * Массив информации и содержания заключений по результатам консультации
     * @var MedRecord[]
     */
    private $MedRecords;

    /**
     * Проверка валидности значений объекта.
     */
    public function validate(): bool
    {
        parent::validate();
        if (PaymentTypeEnum::getValue($this->IdPaymentType) === null) {
            $this->errors['IdPaymentType'] = 'Недопустимое значение поля "Идентификатор источника финансирования"';
        }

        if (ConfidentialityEnum::getValue($this->Confidentiality) === null) {
            $this->errors['Confidentiality'] = 'Недопустимое значение поля "Конфиденциальность"';
        }

        if (ConfidentialityEnum::getValue($this->DoctorConfidentiality) === null) {
            $this->errors['DoctorConfidentiality'] = 'Недопустимое значение поля "Конфиденциальность доктора"';
        }

        if (ConfidentialityEnum::getValue($this->CuratorConfidentiality) === null) {
            $this->errors['CuratorConfidentiality'] = 'Недопустимое значение поля "Конфиденциальность куратора"';
        }

        if (CaseResultEnum::getValue($this->IdCaseResult) === null) {
            $this->errors['IdCaseResult'] = 'Недопустимое значение поля "Идентификатор исхода заболевания"';
        }
        if (TelemedCaseFormEnum::getValue($this->TmcForm) === null) {
            $this->errors['TmcForm'] = 'Недопустимое значение поля "Форма телемед-консультации"';
        }
        if (TelemedCaseGoalEnum::getValue($this->TmcGoal) === null) {
            $this->errors['TmcGoal'] = 'Недопустимое значение поля "Цель телемед-консультации"';
        }

        return !(bool)$this->errors;
    }

    /**
     * @return string
     */
    public function getOpenDate(): string
    {
        return $this->openDate;
    }

    /**
     * @param string $openDate
     *
     * @return TelemedCase
     */
    public function setOpenDate(string $openDate): TelemedCase
    {
        $this->openDate = $openDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCloseDate(): string
    {
        return $this->closeDate;
    }

    /**
     * @param string $closeDate
     *
     * @return TelemedCase
     */
    public function setCloseDate(string $closeDate): TelemedCase
    {
        $this->closeDate = $closeDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getHistoryNumber(): string
    {
        return $this->historyNumber;
    }

    /**
     * @param string $historyNumber
     *
     * @return TelemedCase
     */
    public function setHistoryNumber(string $historyNumber): TelemedCase
    {
        $this->historyNumber = $historyNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdCaseMis(): string
    {
        return $this->idCaseMis;
    }

    /**
     * @param string $idCaseMis
     *
     * @return TelemedCase
     */
    public function setIdCaseMis(string $idCaseMis): TelemedCase
    {
        $this->idCaseMis = $idCaseMis;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdPaymentType(): int
    {
        return $this->IdPaymentType;
    }

    /**
     * @param int $IdPaymentType
     *
     * @return TelemedCase
     */
    public function setIdPaymentType(int $IdPaymentType): TelemedCase
    {
        $this->IdPaymentType = $IdPaymentType;

        return $this;
    }

    /**
     * @return int
     */
    public function getConfidentiality(): int
    {
        return $this->Confidentiality;
    }

    /**
     * @param int $Confidentiality
     *
     * @return TelemedCase
     */
    public function setConfidentiality(int $Confidentiality): TelemedCase
    {
        $this->Confidentiality = $Confidentiality;

        return $this;
    }

    /**
     * @return int
     */
    public function getDoctorConfidentiality(): int
    {
        return $this->DoctorConfidentiality;
    }

    /**
     * @param int $DoctorConfidentiality
     *
     * @return TelemedCase
     */
    public function setDoctorConfidentiality(int $DoctorConfidentiality): TelemedCase
    {
        $this->DoctorConfidentiality = $DoctorConfidentiality;

        return $this;
    }

    /**
     * @return int
     */
    public function getCuratorConfidentiality(): int
    {
        return $this->CuratorConfidentiality;
    }

    /**
     * @param int $CuratorConfidentiality
     *
     * @return TelemedCase
     */
    public function setCuratorConfidentiality(int $CuratorConfidentiality): TelemedCase
    {
        $this->CuratorConfidentiality = $CuratorConfidentiality;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdCaseResult(): int
    {
        return $this->IdCaseResult;
    }

    /**
     * @param int $IdCaseResult
     *
     * @return TelemedCase
     */
    public function setIdCaseResult(int $IdCaseResult): TelemedCase
    {
        $this->IdCaseResult = $IdCaseResult;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->Comment;
    }

    /**
     * @param string $Comment
     *
     * @return TelemedCase
     */
    public function setComment(string $Comment): TelemedCase
    {
        $this->Comment = $Comment;

        return $this;
    }

    /**
     * @return MedicalStaff
     */
    public function getDoctorInCharge(): MedicalStaff
    {
        return $this->DoctorInCharge;
    }

    /**
     * @param MedicalStaff $DoctorInCharge
     *
     * @return TelemedCase
     */
    public function setDoctorInCharge(MedicalStaff $DoctorInCharge): TelemedCase
    {
        $this->DoctorInCharge = $DoctorInCharge;

        return $this;
    }

    /**
     * @return Participant
     */
    public function getAuthenticator(): Participant
    {
        return $this->Authenticator;
    }

    /**
     * @param Participant $Authenticator
     *
     * @return TelemedCase
     */
    public function setAuthenticator(Participant $Authenticator): TelemedCase
    {
        $this->Authenticator = $Authenticator;

        return $this;
    }

    /**
     * @return Participant
     */
    public function getAuthor(): Participant
    {
        return $this->Author;
    }

    /**
     * @param Participant $Author
     *
     * @return TelemedCase
     */
    public function setAuthor(Participant $Author): TelemedCase
    {
        $this->Author = $Author;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdPatientMis(): string
    {
        return $this->IdPatientMis;
    }

    /**
     * @param string $IdPatientMis
     *
     * @return TelemedCase
     */
    public function setIdPatientMis(string $IdPatientMis): TelemedCase
    {
        $this->IdPatientMis = $IdPatientMis;

        return $this;
    }

    /**
     * @return string
     */
    public function getTmcID(): string
    {
        return $this->TmcID;
    }

    /**
     * @param string $TmcID
     *
     * @return TelemedCase
     */
    public function setTmcID(string $TmcID): TelemedCase
    {
        $this->TmcID = $TmcID;

        return $this;
    }

    /**
     * @return int
     */
    public function getTmcForm(): int
    {
        return $this->TmcForm;
    }

    /**
     * @param int $TmcForm
     *
     * @return TelemedCase
     */
    public function setTmcForm(int $TmcForm): TelemedCase
    {
        $this->TmcForm = $TmcForm;

        return $this;
    }

    /**
     * @return int
     */
    public function getTmcGoal(): int
    {
        return $this->TmcGoal;
    }

    /**
     * @param int $TmcGoal
     *
     * @return TelemedCase
     */
    public function setTmcGoal(int $TmcGoal): TelemedCase
    {
        $this->TmcGoal = $TmcGoal;

        return $this;
    }

    /**
     * @return Initiator
     */
    public function getInitiator(): Initiator
    {
        return $this->Initiator;
    }

    /**
     * @param Initiator $Initiator
     *
     * @return TelemedCase
     */
    public function setInitiator(Initiator $Initiator): TelemedCase
    {
        $this->Initiator = $Initiator;

        return $this;
    }

    /**
     * @return array
     */
    public function getMedRecords(): array
    {
        return $this->MedRecords;
    }

    /**
     * @param array $MedRecords
     *
     * @return TelemedCase
     */
    public function setMedRecords(array $MedRecords): TelemedCase
    {
        $this->MedRecords = $MedRecords;

        return $this;
    }

    /**
     * Список ошибок валидации
     *
     * @return array <string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @inheritDoc
     */
    protected function getRequiredFields(): array
    {
        $fields = $this->getFields();
        unset($fields['MedRecords']);

        return $fields;
    }

    /**
     * @inheritDoc
     */
    protected function getFields(): array
    {
        if ($this->fields !== null) {
            return $this->fields;
        }
        $fields = get_object_vars($this);
        unset($fields['errors'], $fields['fields']);

        if ($this->MedRecords === null) {
            unset($fields['MedRecords']);
        }

        $this->fields = $fields;
        return $this->fields;
    }
}
