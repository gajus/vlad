<?php
class ValidatorNotEmptyTest extends PHPUnit_Framework_TestCase {
	private
		$input,
		$validator;

	public function setUp () {
		$this->input = new \gajus\vlad\Input([
			//'foo0' => '',
			'foo1' => '',
			'foo2' => null,
			'bar0' => 'bar',
			'bar1' => ['test'],
			'bar1' => 1
		]);

		$this->validator = new \gajus\vlad\validator\Not_Empty();
	}

	/**
	 * @dataProvider testEmptyInputProvider
	 */
	public function testEmptyInput ($selector) {
		$subject = $this->input->getSubject($selector);

		$error = $this->validator->assess($subject);

		$this->assertNotNull($error);
		$this->assertSame('empty', $error->getName());
	}

	public function testEmptyInputProvider () {
		return [
			['foo0'],
			['foo1'],
			['foo2']
		];
	}

	/**
	 * @dataProvider testNotEmptyInputProvider
	 */
	public function testNotEmptyInput ($selector) {
		$subject = $this->input->getSubject($selector);

		$this->assertNull($this->validator->assess($subject));
	}

	public function testNotEmptyInputProvider () {
		return [
			['bar0'],
			['bar1']
		];
	}
}