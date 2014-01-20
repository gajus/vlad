<?php
class SelectorTest extends PHPUnit_Framework_TestCase {
	public function testGetSelector () {
		$selector = new \gajus\vlad\Selector('foo[bar]');

		$this->assertSame('foo[bar]', $selector->getSelector());
	}

	/**
	 * @dataProvider getPathProvider
	 */
	public function testGetPath ($selector, $path) {
		$selector = new \gajus\vlad\Selector($selector);

		$this->assertSame($path, $selector->getPath());
	}

	public function getPathProvider () {
		return [
			['foo', ['foo']],
			['foo[bar]', ['foo', 'bar']],
			['foo[bar][1]', ['foo', 'bar', '1']],
			['foo[bar][]', ['foo', 'bar', '']]
		];
	}
}