<?php
class InputTest extends PHPUnit_Framework_TestCase {
    public function testConstructInput () {
        return new \Gajus\Vlad\Input(['foo' => 'bar']);
    }

    /**
     * @depends testConstructInput
     */
    public function testGetExistingValue (\Gajus\Vlad\Input $input) {
        $selector = new \Gajus\Vlad\Selector('foo');

        $this->assertSame('bar', $input->getValue($selector));
    }

    /**
     * @depends testConstructInput
     */
    public function testGetNonExistingValue (\Gajus\Vlad\Input $input) {
        $selector = new \Gajus\Vlad\Selector('baz');

        $this->assertNull($input->getValue($selector));
    }
}