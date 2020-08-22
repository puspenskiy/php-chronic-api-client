<?php

declare(strict_types=1);

namespace DocDoc\RgsApiClient\Enum;

/**
 * Список возможных роботов для сценария звонков пациенту
 */
class RobotTypeEnum extends AbstractBaseEnum
{
	public const ROBOVOICE = 'robovoice';
	public const CRT = 'crt';

	/**
	 * @return array<string,string>
	 */
	public static function getAllValueNames(): array
	{
		return [
			self::ROBOVOICE => 'Робовойс',
			self::CRT => 'ЦРТ',
		];
	}
}
