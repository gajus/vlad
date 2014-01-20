<?php
class ValidatorLengthTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage "min" and/or "max" option is required.
	 */
	public function testMissingRequiredParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length');
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage "min" option must be numeric.
	 */
	public function testInvalidMinParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length', ['min' => 'test']);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage "max" option must be numeric.
	 */
	public function testInvalidMaxParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length', ['max' => 'test']);
	}

	/**
	 * @expectedException InvalidArgumentException
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