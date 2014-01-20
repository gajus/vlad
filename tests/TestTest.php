<?php
class TestTest extends PHPUnit_Framework_TestCase {
	public function testGetTestScript () {
		$test = new \gajus\vlad\Test();

		$test->assert('foo', 'length', ['min' => 3]);
		$test->assert('foo', 'not_empty');

		$expected_test_script = [
			'foo' => [
				[
					'name' => 'gajus\vlad\validator\length',
					'options' => ['min' => 3]
				],
				[
					'name' => 'gajus\vlad\validator\not_empty',
					'options' => []
				]
			]
		];

		$this->assertSame($expected_test_script, $test->getScript());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidValidatorNameParameters () {
		$test = new \gajus\vlad\Test();

		$test->assert('foo', []);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNotFoundValidator () {
		$test = new \gajus\vlad\Test();

		$test->assert('foo', 'NotFound');
	}

	public function testUsingImplicitInput () {
		$_POST['foo'] = 'test';

		$test = new \gajus\vlad\Test();

		$test->assert('foo', 'string');

		$assessment = $test->assess();

		$this->assertCount(0, $assessment);
	}
}