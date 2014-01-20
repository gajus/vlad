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
	 * @expectedException InvalidArgumentException
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
	 * @expectedException InvalidArgumentException
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
	 * @expectedException InvalidArgumentException
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