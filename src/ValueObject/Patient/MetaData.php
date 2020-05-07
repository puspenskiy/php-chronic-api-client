<?php

namespace DocDoc\RgsApiClient\ValueObject\Patient;

/**
 * Объект мета данных пациента.
 * Эти данные будут получатся по запросу данных о клиенте.
 */
class MetaData implements \JsonSerializable
{
	/** @var int - id продукта b2b */
	private $productId;

	/** @var int - id контракта b2b */
	private $contractId;

	/**
	 * @param int $productId
	 * @param int $contractId
	 */
	public function __construct(int $productId, int $contractId)
	{
		$this->productId = $productId;
		$this->contractId = $contractId;
	}

	/**
	 * Id продукта b2b
	 *
	 * @return int
	 */
	public function getProductId(): int
	{
		return $this->productId;
	}

	/**
	 * Id контракта b2b
	 *
	 * @return int
	 */
	public function getContractId(): int
	{
		return $this->contractId;
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
}
