<?php
class ValidatorLengthTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "min" and/or "max" option is required.
	 */
	public function testMissingRequiredParameter () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Length');
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "min" option must be a whole number.
	 */
	public function testInvalidMinParameter () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Length', ['min' => 'test']);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "max" option must be a whole number.
	 */
	public function testInvalidMaxParameter () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Length', ['max' => 'test']);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "min" option cannot be greater than "max".
	 */
	public function testMinOptionCannotBeGreaterThanMax () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Length', ['min' => 20, 'max' => 10]);
	}

	public function testTooShort () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Length', ['min' => 10]);
		
		$assessment = $test->assess(['foo' => 'bar']);
		
		$this->assertCount(1, $assessment);
		$this->assertSame('min', $assessment[0]->getName());
	}

	public function testNotTooShort () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Length', ['min' => 10]);
		
		$assessment = $test->assess(['foo' => 'barbarbarbar']);
		
		$this->assertCount(0, $assessment);
	}

	public function testTooLong () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Length', ['max' => 10]);
		
		$assessment = $test->assess(['foo' => 'barbarbarbar']);
		
		$this->assertCount(1, $assessment);
		$this->assertSame('max', $assessment[0]->getName());
	}

	public function testNotTooLong () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Length', ['max' => 10]);
		
		$assessment = $test->assess(['foo' => 'bar']);
		
		$this->assertCount(0, $assessment);
	}
}