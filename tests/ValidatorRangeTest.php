<?php
class ValidatorRangeTest extends PHPUnit_Framework_TestCase {
	
	public function testMinExclusive () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', ['min_exclusive' => 10]);
		$assessment = $test->assess(['foo' => 11]);

		$this->assertCount(0, $assessment);
	}

	public function testLessThanMinExclusive () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', ['min_exclusive' => 10]);
		$assessment = $test->assess(['foo' => 10]);

		$this->assertCount(1, $assessment);
		$this->assertSame('min_exclusive', $assessment[0]->getName());
	}

	public function testMinInclusive () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', ['min_inclusive' => 10]);
		$assessment = $test->assess(['foo' => 10]);

		$this->assertCount(0, $assessment);
	}

	public function testLessThanMinInclusive () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', ['min_inclusive' => 10]);
		$assessment = $test->assess(['foo' => 9]);

		$this->assertCount(1, $assessment);
		$this->assertSame('min_inclusive', $assessment[0]->getName());
	}

	public function testMaxExclusive () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', ['max_exclusive' => 10]);
		$assessment = $test->assess(['foo' => 9]);

		$this->assertCount(0, $assessment);
	}

	public function testMoreThanMaxExclusive () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', ['max_exclusive' => 10]);
		$assessment = $test->assess(['foo' => 10]);

		$this->assertCount(1, $assessment);
		$this->assertSame('max_exclusive', $assessment[0]->getName());
	}

	public function testMaxInclusive () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', ['max_inclusive' => 10]);
		$assessment = $test->assess(['foo' => 10]);

		$this->assertCount(0, $assessment);
	}

	public function testMoreThanMaxInclusive () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', ['max_inclusive' => 10]);
		$assessment = $test->assess(['foo' => 11]);

		$this->assertCount(1, $assessment);
		$this->assertSame('max_inclusive', $assessment[0]->getName());
	}


	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 */
	public function testMissingRequiredParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range');
	}

	/**
	 * @dataProvider optionsOverlapProvider
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
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
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
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
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage Minimum bountry cannot be greater than the maximum boundry.
	 */
	public function testIllogicOptionCombination () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range', ['min_exclusive' => 10, 'max_inclusive' => 5]);
	}
}