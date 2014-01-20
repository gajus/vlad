<?php
class ValidatorEqualTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testMissingRequiredParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range');
	}

	public function testEqual () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'equal', ['to' => 'test']);

		$assessment = $test->assess(['foo' => 'test']);

		$this->assertCount(0, $assessment);
	}

	public function testNotEqual () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'equal', ['to' => 'test']);

		$assessment = $test->assess(['foo' => 'not test']);

		$this->assertCount(1, $assessment);
		$this->assertSame('not_equal', $assessment[0]->getName());
	}
}