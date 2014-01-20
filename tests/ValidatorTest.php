<?php
class ValidatorTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException RuntimeException
	 */
	public function testValidatorWithoutRequiredValue () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'email');

		$test->assess([]);
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
	 * @expectedException InvalidArgumentException
	 */
	public function testGetNonExistingMessage () {
		$validator = new \gajus\vlad\validator\String();

		$validator->getMessage('foo');
	}
}