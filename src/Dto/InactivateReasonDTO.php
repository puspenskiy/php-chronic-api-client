<?php

namespace DocDoc\RgsApiClient\Dto;

/**
 * Причина отключения пользователя в системе РГС
 */
class InactivateReasonDTO
{
	/** @var int */
	private $id;

	/** @var string */
	private $name;

	public function __construct(int $id, string $name)
	{
		$this->id = $id;
		$this->name = $name;
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

}
