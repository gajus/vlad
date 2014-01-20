<?php
class SubjectTest extends PHPUnit_Framework_TestCase {
	public function testGetInput () {
		$input = new \gajus\vlad\Input([]);
		$subject = $input->getSubject('foo[bar]');

		$this->assertSame($input, $subject->getInput());
	}

	public function testGetSelector () {
		$input = new \gajus\vlad\Input([]);
		$subject = $input->getSubject('foo[bar]');

		$this->assertSame('foo[bar]', $subject->getSelector()->getSelector());
	}

	/**
	 * @dataProvider getNameProvider
	 */
	public function testGetName ($selector, $name) {
		$input = new \gajus\vlad\Input([]);
		$subject = $input->getSubject($selector);

		$this->assertSame($name, $subject->getName());
	}

	public function getNameProvider () {
		return [
			['foo[bar]', 'Foo Bar'],
			['foo_bar', 'Foo Bar'],
			['foo_bar[baz]', 'Foo Bar Baz']
		];
	}

	public function testGetValue () {
		$input = new \gajus\vlad\Input(['foo' => ['bar' => 'baz']]);
		$subject = $input->getSubject('foo[bar]');

		$this->assertSame('baz', $subject->getValue());
	}

	public function testIsFound () {
		$input = new \gajus\vlad\Input(['foo' => ['bar' => 'baz']]);
		$subject = $input->getSubject('foo[bar]');

		$this->assertTrue($subject->isFound());
	}

	public function testIsNotFound () {
		$input = new \gajus\vlad\Input(['foo' => ['bar' => 'baz']]);
		$subject = $input->getSubject('foo[baz]');

		$this->assertFalse($subject->isFound());
	}
}