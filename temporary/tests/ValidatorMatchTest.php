<?php
class ValidatorMatchTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "selector" option cannot be left undefined.
	 */
	public function testMissingRequiredParameter () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Match');
	}

	public function testMatch () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Match', ['selector' => 'bar']);

		$assessment = $test->assess(['foo' => 'test', 'bar' => 'test']);

		$this->assertCount(0, $assessment);
	}

	public function testNotMatch () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Match', ['selector' => 'bar']);

		$assessment = $test->assess(['foo' => 'test', 'bar' => 'baz']);

		$this->assertCount(1, $assessment);
		$this->assertSame('not_match', $assessment[0]->getName());
	}
}