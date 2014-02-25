<?php
class ValidatorRangeTest extends PHPUnit_Framework_TestCase {
	
	public function testMinExclusive () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', ['min_exclusive' => 10]);
		$assessment = $test->assess(['foo' => 11]);

		$this->assertCount(0, $assessment);
	}

	public function testLessThanMinExclusive () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', ['min_exclusive' => 10]);
		$assessment = $test->assess(['foo' => 10]);

		$this->assertCount(1, $assessment);
		$this->assertSame('min_exclusive', $assessment[0]->getName());
	}

	public function testMinInclusive () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', ['min_inclusive' => 10]);
		$assessment = $test->assess(['foo' => 10]);

		$this->assertCount(0, $assessment);
	}

	public function testLessThanMinInclusive () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', ['min_inclusive' => 10]);
		$assessment = $test->assess(['foo' => 9]);

		$this->assertCount(1, $assessment);
		$this->assertSame('min_inclusive', $assessment[0]->getName());
	}

	public function testMaxExclusive () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', ['max_exclusive' => 10]);
		$assessment = $test->assess(['foo' => 9]);

		$this->assertCount(0, $assessment);
	}

	public function testMoreThanMaxExclusive () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', ['max_exclusive' => 10]);
		$assessment = $test->assess(['foo' => 10]);

		$this->assertCount(1, $assessment);
		$this->assertSame('max_exclusive', $assessment[0]->getName());
	}

	public function testMaxInclusive () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', ['max_inclusive' => 10]);
		$assessment = $test->assess(['foo' => 10]);

		$this->assertCount(0, $assessment);
	}

	public function testMoreThanMaxInclusive () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', ['max_inclusive' => 10]);
		$assessment = $test->assess(['foo' => 11]);

		$this->assertCount(1, $assessment);
		$this->assertSame('max_inclusive', $assessment[0]->getName());
	}


	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 */
	public function testMissingRequiredParameter () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range');
	}

	/**
	 * @dataProvider optionsOverlapProvider
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 */
	public function testOptionsOverlap ($options) {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', $options);
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
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 */
	public function testInvalidOptionType ($options) {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', $options);
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
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Minimum bountry cannot be greater than the maximum boundry.
	 */
	public function testIllogicOptionCombination () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Range', ['min_exclusive' => 10, 'max_inclusive' => 5]);
	}
}