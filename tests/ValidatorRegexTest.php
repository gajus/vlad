<?php
class ValidatorRegexTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException BadMethodCallException
	 */
	public function testInstantiatingWithoutRequiredParameterPattern () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'regex');
	}

	public function testMatch () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'regex', ['pattern' => '/test/']);

		$assessment = $test->assess(['foo' => 'test']);

		$this->assertCount(0, $assessment);
	}

	public function testNoMatch () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'regex', ['pattern' => '/test/']);

		$assessment = $test->assess(['foo' => 'bar']);

		$this->assertCount(1, $assessment);

		$this->assertSame('no_match', $assessment[0]->getName());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testBadPattern () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'regex', ['pattern' => '/']);
	}
}