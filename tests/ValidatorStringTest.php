<?php
class ValidatorStringTest extends PHPUnit_Framework_TestCase {
	public function testDefaultInstanceOptions () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'string');

		$this->assertCount(1, $test->getScript());
		$this->assertSame(['strict' => false], $test->getScript()['foo'][0]['options']);
	}

	/**
	 * @dataProvider notStrictStringProvider
	 */
	public function testNotStrictString ($value) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'string');

		$assessment = $test->assess(['foo' => $value]);

		$this->assertCount(0, $assessment);
	}

	public function notStrictStringProvider () {
		return [
			[123],
			['123'],
			[0x539]
		];
	}

	/**
	 * @dataProvider notStrictNotStringProvider
	 */
	public function testNotStrictNotString ($value) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'string');

		$assessment = $test->assess(['foo' => $value]);

		$this->assertCount(1, $assessment);
		$this->assertSame('not_string', $assessment[0]->getName());
	}

	public function notStrictNotStringProvider () {
		return [
			[[]],
			[false],
			[true],
			[null],
			[new stdClass]
		];
	}

	/**
	 * @dataProvider strictStringProvider
	 */
	public function testStrictString ($value) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'string');

		$assessment = $test->assess(['foo' => $value]);

		$this->assertCount(0, $assessment);
	}

	public function strictStringProvider () {
		return [
			['123']
		];
	}

	/**
	 * @dataProvider notStrictNotStringProvider
	 */
	public function testStrictNotString ($value) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'string');

		$assessment = $test->assess(['foo' => $value]);

		$this->assertCount(1, $assessment);
		$this->assertSame('not_string', $assessment[0]->getName());
	}

	public function strictNotStringProvider () {
		return [
			[[]],
			[false],
			[true],
			[null],
			[new stdClass]
		];
	}
}