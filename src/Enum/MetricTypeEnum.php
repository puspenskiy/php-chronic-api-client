<?php

namespace DocDoc\RgsApiClient\Enum;
/**
 * Тип метрики в понимании РГС сервиса (период получения данных)
 */
class MetricTypeEnum extends AbstractBaseEnum
{
	public const DAY = 'day';
	public const WEEK = 'week';
	public const MONTH = 'month';
}
