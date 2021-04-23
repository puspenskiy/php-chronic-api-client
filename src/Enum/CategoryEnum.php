<?php

namespace DocDoc\RgsApiClient\Enum;

/**
 * Список категорий мониторинга
 */
class CategoryEnum extends AbstractBaseEnum
{
	public const COVID = 'covid';
	public const HYPERTONIC = 'hypertonic';
	public const DIABETIC = 'diabetic';
	public const CORONARY_ARTERY = 'coronary_artery';
	public const HEART_FAILURE = 'heart_failure';
	public const WARFARIN = 'warfarin';
}
