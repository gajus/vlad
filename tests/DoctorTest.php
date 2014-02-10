<?php
class DoctorTest extends PHPUnit_Framework_TestCase {
	public function testBuildTestWithMultipleSubtests () {
		$doctor = new \Gajus\Vlad\Doctor();
		$test = $doctor->test([
			[
				['foo', 'bar'],
				['NotEmpty', 'Email']
			],
			[
				['baz'],
				['String']
			]
		]);

		$test_script = $test->getScript();

		$this->assertCount(3, $test_script);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Validator options must be an array.
	 */
	public function testValidatorOptionsNotArray () {
		$doctor = new \Gajus\Vlad\Doctor();
		$test = $doctor->test([
			[
				['foo'],
				['Equal' => 'foo!']
			]
		]);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Selector must be an array.
	 */
	public function testSelectorNotArray () {
		$doctor = new \Gajus\Vlad\Doctor();
		$doctor->test([
			[
				'selector',
				['Email']
			]
		]);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Test has duplicate selector declarations. Each selector can be declared only once per test.
	 */
	public function testHasDuplicateSelectorDeclartion () {
		$doctor = new \Gajus\Vlad\Doctor();
		$doctor->test([
			[
				['selector'],
				['NotEmpty']
			],
			[
				['selector'],
				['Email']
			],
		]);
	}
}