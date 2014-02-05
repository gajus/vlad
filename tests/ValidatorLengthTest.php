<?php
class ValidatorLengthTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage "min" and/or "max" option is required.
	 */
	public function testMissingRequiredParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length');
	}

	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage "min" option must be a whole number.
	 */
	public function testInvalidMinParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length', ['min' => 'test']);
	}

	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage "max" option must be a whole number.
	 */
	public function testInvalidMaxParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length', ['max' => 'test']);
	}

	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage "min" option cannot be greater than "max".
	 */
	public function testMinOptionCannotBeGreaterThanMax () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length', ['min' => 20, 'max' => 10]);
	}

	public function testTooShort () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length', ['min' => 10]);
		
		$assessment = $test->assess(['foo' => 'bar']);
		
		$this->assertCount(1, $assessment);
		$this->assertSame('min', $assessment[0]->getName());
	}

	public function testNotTooShort () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length', ['min' => 10]);
		
		$assessment = $test->assess(['foo' => 'barbarbarbar']);
		
		$this->assertCount(0, $assessment);
	}

	public function testTooLong () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length', ['max' => 10]);
		
		$assessment = $test->assess(['foo' => 'barbarbarbar']);
		
		$this->assertCount(1, $assessment);
		$this->assertSame('max', $assessment[0]->getName());
	}

	public function testNotTooLong () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length', ['max' => 10]);
		
		$assessment = $test->assess(['foo' => 'bar']);
		
		$this->assertCount(0, $assessment);
	}
}