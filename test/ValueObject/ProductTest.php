<?php

declare(strict_types=1);

namespace DocDoc\RgsApiClient\test\ValueObject;

use DocDoc\RgsApiClient\Enum\RobotTypeEnum;
use DocDoc\RgsApiClient\Exception\ValidationException;
use DocDoc\RgsApiClient\ValueObject\Product\Product;
use PHPUnit\Framework\TestCase;

/**
 * Данные продукта для передачи в сервис мониторинга РГС
 *
 * @coversDefaultClass \DocDoc\RgsApiClient\ValueObject\Product\Product
 */
class ProductTest extends TestCase
{
	/**
	 * Проверка правильности валидации
	 * @covers ::validate
	 *
	 * @param string $robotType
	 * @param bool   $expectValidate
	 *
	 * @dataProvider productDataProvider
	 */
	public function testValidation(string $robotType, bool $expectValidate): void
	{
		$product = new Product(2017, $robotType);
		self::assertEquals(
			$expectValidate,
			$product->validate(),
			'Валидация продукта прошла не так как ожидалось.'
		);
	}

	/**
	 * Тест преобразование объекта в json
	 * @covers ::jsonSerialize
	 *
	 * @dataProvider productDataProvider
	 *
	 * @param string $robotType
	 * @param bool   $expectValidate
	 */
	public function testJsonSerialize(string $robotType, bool $expectValidate): void
	{
		$product = new Product(2017, $robotType);
		if ($expectValidate === true) {
			self::assertIsString(json_encode($product), 'После преобразования в продукта в json результат не строка');
		} else {
			$this->expectException(ValidationException::class);
			$result = json_encode($product);
		}

		unset($result);
	}

	/**
	 * Данные для сборки различных продуктов
	 */
	public function productDataProvider(): array
	{
		$result = [];
		foreach (RobotTypeEnum::getAllValues() as $value) {
			$result[] = [$value, true];
		}
		$result[] = ['не_существует_такой_робот', false];
		return $result;
	}
}
