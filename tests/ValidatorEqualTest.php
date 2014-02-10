<?php
class ValidatorEqualTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Missing required option.
	 */
	public function testMissingRequiredParameter () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Equal');
	}

	public function testEqual () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Equal', ['to' => 'test']);

		$assessment = $test->assess(['foo' => 'test']);

		$this->assertCount(0, $assessment);
	}

	public function testNotEqual () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Equal', ['to' => 'test']);

		$assessment = $test->assess(['foo' => 'not test']);

		$this->assertCount(1, $assessment);
		$this->assertSame('not_equal', $assessment[0]->getName());
	}
}