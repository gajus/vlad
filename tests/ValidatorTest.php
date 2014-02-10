<?php
class ValidatorTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException Gajus\Vlad\exception\RuntimeException
	 */
	public function testValidatorWithoutRequiredValue () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Email');

		$test->assess([]);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Unrecognised option.
	 */
	public function testValidatorWithUnrecognisedOption () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'Email', ['foo' => 'bar']);
	}

	public function testGetValidatorOptions () {
		$validator = new \Gajus\Vlad\Validator\String();

		$this->assertNotEmpty($validator->getOptions());
	}

	public function testGetMessages () {
		$validator = new \Gajus\Vlad\Validator\String();

		$this->assertNotEmpty($validator->getMessages());
	}

	public function testGetMessage () {
		$validator = new \Gajus\Vlad\Validator\String();

		foreach ($validator->getMessages() as $name => $message) {
			$this->assertSame($message, $validator->getMessage($name));
		}
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Undefined error message.
	 */
	public function testGetNonExistingMessage () {
		$validator = new \Gajus\Vlad\Validator\String();

		$validator->getMessage('foo');
	}
}