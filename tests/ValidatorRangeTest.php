<?php
class ValidatorRangeTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testMissingRequiredParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range');
	}

	/**
	 * @dataProvider optionsOverlapProvider
	 * @expectedException InvalidArgumentException
	 */
	public function testOptionsOverlap ($options) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', $options);
	}

	public function optionsOverlapProvider () {
		return [
			[
				['min_exclusive' => 1, 'min_inclusive' => 2],
			],
			[
				['max_exclusive' => 1, 'max_inclusive' => 2]
			]
		];
	}

	/**
	 * @dataProvider invalidOptionTypeProvider
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidOptionType ($options) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', $options);
	}

	public function invalidOptionTypeProvider () {
		return [
			[
				['min_exclusive' => 'a10']
			],
			[
				['min_inclusive' => 'b10']
			],
			[
				['max_exclusive' => 'c10']
			],
			[
				['max_inclusive' => 'd10']
			]
		];
	}

	/**
	 * @dataProvider illogicOptionCombinationProvider
	 * @expectedException InvalidArgumentException
	 */
	public function testIllogicOptionCombination ($options) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', $options);
	}

	public function illogicOptionCombinationProvider () {
		return [
			[
				['min_exclusive' => 10, 'max_inclusive' => 5],
			],
			[
				['min_inclusive' => 10, 'max_exclusive' => 5],
			],
			[
				['min_inclusive' => 10, 'max_inclusive' => 5],
			]
		];
	}
}