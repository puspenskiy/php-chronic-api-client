<?php

namespace DocDoc\RgsApiClient\Enum;

use ReflectionClass;

/**
 * Базовый класс Enum
 */
abstract class AbstractBaseEnum
{
	/**
	 * Возвращает перечисление в формате
	 * [key => value]
	 * Где key   - название константы
	 *     value - значение константы
	 *
	 * @return array
	 * @throws
	 */
	public static function getAllKeyValues(): array
	{
		$reflection = new ReflectionClass(static::class);
		return $reflection->getConstants();
	}

	/**
	 * Возвращает все значения перечисления
	 *
	 * @return array
	 * @throws
	 */
	public static function getAllValues(): array
	{
		return array_values(static::getAllKeyValues());
	}

	/**
	 * Возвращает все ключи перечисления
	 *
	 * @return array
	 * @throws
	 */
	public static function getAllKeys(): array
	{
		return array_keys(static::getAllKeyValues());
	}

	/**
	 * Возвращает значение перечисления по ключу
	 *
	 * @param $key
	 *
	 * @return int|string|null
	 */
	public static function getValue($key)
	{
		$key = mb_strtoupper($key);

		return static::getAllKeyValues()[$key] ?? null;
	}

	/**
	 * Возвращает ключ перечисления по значению
	 *
	 * @param      $value
	 * @param bool $toLower Вернуть в нижнем регистре
	 *
	 * @return string
	 */
	public static function getKey($value, $toLower = true): ?string
	{
		$all = array_flip(static::getAllKeyValues());

		if (!isset($all[$value])) {
			return null;
		}

		$key = $all[$value];

		if ($toLower) {
			return mb_strtolower($key);
		}

		return $key;
	}

	/**
	 * @param int $value
	 *
	 * @return string
	 */
	public static function getName(int $value): string
	{
		return static::getAllValueNames()[$value] ?? static::getKey($value);
	}

	/**
	 * @return array
	 */
	public static function getAllValueNames(): array
	{
		return array_flip(static::getAllKeyValues());
	}
}
