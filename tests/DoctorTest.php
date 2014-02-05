<?php
class DoctorTest extends PHPUnit_Framework_TestCase {
	public function testBuildTestWithMultipleSubtests () {
		$doctor = new \gajus\vlad\Doctor();
		$test = $doctor->test([
			[
				['foo', 'bar'],
				['not_empty', 'email']
			],
			[
				['baz'],
				['string']
			]
		]);

		$test_script = $test->getScript();

		$this->assertCount(3, $test_script);
	}

	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage Validator options must be an array.
	 */
	public function testValidatorOptionsNotArray () {
		$doctor = new \gajus\vlad\Doctor();
		$test = $doctor->test([
			[
				['foo'],
				['equal' => 'foo!']
			]
		]);
	}

	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage Selector must be an array.
	 */
	public function testSelectorNotArray () {
		$doctor = new \gajus\vlad\Doctor();
		$doctor->test([
			[
				'selector',
				['email']
			]
		]);
	}

	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage Test has duplicate selector declarations. Each selector can be declared only once per test.
	 */
	public function testHasDuplicateSelectorDeclartion () {
		$doctor = new \gajus\vlad\Doctor();
		$doctor->test([
			[
				['selector'],
				['not_empty']
			],
			[
				['selector'],
				['email']
			],
		]);
	}
}