<?php
class ValidatorLengthTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException BadMethodCallException
	 */
	public function testMissingRequiredParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'length');
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