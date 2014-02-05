<?php
class ValidatorTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException gajus\vlad\exception\Runtime_Exception
	 */
	public function testValidatorWithoutRequiredValue () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'email');

		$test->assess([]);
	}

	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage Unrecognised option.
	 */
	public function testValidatorWithUnrecognisedOption () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'email', ['foo' => 'bar']);
	}

	public function testGetValidatorOptions () {
		$validator = new \gajus\vlad\validator\String();

		$this->assertNotEmpty($validator->getOptions());
	}

	public function testGetMessages () {
		$validator = new \gajus\vlad\validator\String();

		$this->assertNotEmpty($validator->getMessages());
	}

	public function testGetMessage () {
		$validator = new \gajus\vlad\validator\String();

		foreach ($validator->getMessages() as $name => $message) {
			$this->assertSame($message, $validator->getMessage($name));
		}
	}

	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage Undefined error message.
	 */
	public function testGetNonExistingMessage () {
		$validator = new \gajus\vlad\validator\String();

		$validator->getMessage('foo');
	}
}