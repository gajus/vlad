<?php
class ValidatorRegexTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "pattern" property is required.
	 */
	public function testInstantiatingWithoutRequiredParameterPattern () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Regex');
	}

	public function testMatch () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Regex', ['pattern' => '/test/']);

		$assessment = $test->assess(['foo' => 'test']);

		$this->assertCount(0, $assessment);
	}

	public function testNoMatch () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Regex', ['pattern' => '/test/']);

		$assessment = $test->assess(['foo' => 'bar']);

		$this->assertCount(1, $assessment);

		$this->assertSame('no_match', $assessment[0]->getName());
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 */
	public function testBadPattern () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Regex', ['pattern' => '/']);
	}
}