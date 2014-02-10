<?php
class TestTest extends PHPUnit_Framework_TestCase {
	public function testGetTestScript () {
		$test = new \gajus\vlad\Test();

		$test->assert('foo', 'Length', ['min' => 3]);
		$test->assert('foo', 'NotEmpty');

		$expected_test_script = [
			'foo' => [
				[
					'name' => 'Gajus\Vlad\Validator\Length',
					'options' => ['min' => 3]
				],
				[
					'name' => 'Gajus\Vlad\Validator\NotEmpty',
					'options' => ['trim' => true]
				]
			]
		];

		$this->assertSame($expected_test_script, $test->getScript());
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Validator name must be a string.
	 */
	public function testInvalidValidatorNameParameters () {
		$test = new \gajus\vlad\Test();

		$test->assert('foo', []);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Validator not found "Gajus\Vlad\Validator\NotFound".
	 */
	public function testNotFoundValidator () {
		$test = new \gajus\vlad\Test();

		$test->assert('foo', 'NotFound');
	}

	public function testUsingImplicitInput () {
		$_POST['foo'] = 'test';

		$test = new \gajus\vlad\Test();

		$test->assert('foo', 'String');

		$assessment = $test->assess();

		$this->assertCount(0, $assessment);
	}
}