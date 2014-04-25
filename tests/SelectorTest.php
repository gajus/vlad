<?php
class SelectorTest extends PHPUnit_Framework_TestCase {
    public function testGetName () {
        $selector = new \Gajus\Vlad\Selector('foo[bar]');

        $this->assertSame('foo[bar]', $selector->getName());
    }

    /**
     * @dataProvider getPathProvider
     */
    public function testGetPath ($selector, $path) {
        $selector = new \Gajus\Vlad\Selector($selector);

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