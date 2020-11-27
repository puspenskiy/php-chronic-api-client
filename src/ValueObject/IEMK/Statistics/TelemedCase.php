<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\Enum\IEMK\CaseResultEnum;
use DocDoc\RgsApiClient\Enum\IEMK\ConfidentialityEnum;
use DocDoc\RgsApiClient\Enum\IEMK\PaymentTypeEnum;
use DocDoc\RgsApiClient\Enum\IEMK\TelemedCaseFormEnum;
use DocDoc\RgsApiClient\Enum\IEMK\TelemedCaseGoalEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

class TelemedCase extends AbstractValidateValueObject implements JsonSerializable
{
    /**
     * Дата открытия случая обслуживания (начала телемед-консультации)
     * @var string
     */
    private $OpenDate;

    /**
     * Дата закрытия случая обслуживания (окончание телемед-консультации)
     * @var string
     */
    private $CloseDate;

    /**
     * Номер истории болезни/Амбулаторного талона
     * @var string
     */
    private $HistoryNumber;

    /**
     * Идентификатор телемед-консультации
     * @var string
     */
    private $IdCaseMis;

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
     * @var MedicalStaff
     */
    private $DoctorInCharge;

    /**
     * @var Participant
     */
    private $Authenticator;

    /**
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
     * @var Initiator
     */
    private $Initiator;

    /**
     * Список ошибок валидации
     *
     * @var array <int, MedRecord>
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
        return $this->OpenDate;
    }

    /**
     * @param string $OpenDate
     */
    public function setOpenDate(string $OpenDate): void
    {
        $this->OpenDate = $OpenDate;
    }

    /**
     * @return string
     */
    public function getCloseDate(): string
    {
        return $this->CloseDate;
    }

    /**
     * @param string $CloseDate
     */
    public function setCloseDate(string $CloseDate): void
    {
        $this->CloseDate = $CloseDate;
    }

    /**
     * @return string
     */
    public function getHistoryNumber(): string
    {
        return $this->HistoryNumber;
    }

    /**
     * @param string $HistoryNumber
     */
    public function setHistoryNumber(string $HistoryNumber): void
    {
        $this->HistoryNumber = $HistoryNumber;
    }

    /**
     * @return string
     */
    public function getIdCaseMis(): string
    {
        return $this->IdCaseMis;
    }

    /**
     * @param string $IdCaseMis
     */
    public function setIdCaseMis(string $IdCaseMis): void
    {
        $this->IdCaseMis = $IdCaseMis;
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
     */
    public function setIdPaymentType(int $IdPaymentType): void
    {
        $this->IdPaymentType = $IdPaymentType;
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
     */
    public function setConfidentiality(int $Confidentiality): void
    {
        $this->Confidentiality = $Confidentiality;
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
     */
    public function setDoctorConfidentiality(int $DoctorConfidentiality): void
    {
        $this->DoctorConfidentiality = $DoctorConfidentiality;
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
     */
    public function setCuratorConfidentiality(int $CuratorConfidentiality): void
    {
        $this->CuratorConfidentiality = $CuratorConfidentiality;
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
     */
    public function setIdCaseResult(int $IdCaseResult): void
    {
        $this->IdCaseResult = $IdCaseResult;
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
     */
    public function setComment(string $Comment): void
    {
        $this->Comment = $Comment;
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
     */
    public function setDoctorInCharge(MedicalStaff $DoctorInCharge): void
    {
        $this->DoctorInCharge = $DoctorInCharge;
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
     */
    public function setAuthenticator(Participant $Authenticator): void
    {
        $this->Authenticator = $Authenticator;
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
     */
    public function setAuthor(Participant $Author): void
    {
        $this->Author = $Author;
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
     */
    public function setIdPatientMis(string $IdPatientMis): void
    {
        $this->IdPatientMis = $IdPatientMis;
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
     */
    public function setTmcID(string $TmcID): void
    {
        $this->TmcID = $TmcID;
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
     */
    public function setTmcForm(int $TmcForm): void
    {
        $this->TmcForm = $TmcForm;
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
     */
    public function setTmcGoal(int $TmcGoal): void
    {
        $this->TmcGoal = $TmcGoal;
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
     */
    public function setInitiator(Initiator $Initiator): void
    {
        $this->Initiator = $Initiator;
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
     */
    public function setMedRecords(array $MedRecords): void
    {
        $this->MedRecords = $MedRecords;
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
