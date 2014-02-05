<?php
class ValidatorMatchTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage "selector" option cannot be left undefined.
	 */
	public function testMissingRequiredParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'match');
	}

	public function testMatch () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'match', ['selector' => 'bar']);

		$assessment = $test->assess(['foo' => 'test', 'bar' => 'test']);

		$this->assertCount(0, $assessment);
	}

	public function testNotMatch () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'match', ['selector' => 'bar']);

		$assessment = $test->assess(['foo' => 'test', 'bar' => 'baz']);

		$this->assertCount(1, $assessment);
		$this->assertSame('not_match', $assessment[0]->getName());
	}
}