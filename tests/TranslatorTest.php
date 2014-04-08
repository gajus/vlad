<?php
class TranslatorTest extends PHPUnit_Framework_TestCase {
    /**
     * @dataProvider deriveInputNameProvider
     */
    public function testDeriveInputName ($selector, $name) {
        $selector = new \Gajus\Vlad\Selector($selector);

        $this->assertSame($name, \Gajus\Vlad\Translator::deriveSelectorName($selector));
    }

    public function deriveInputNameProvider () {
        return [
            ['foo', 'Foo'],
            ['foo_id', 'Foo'],
            ['foo_bar', 'Foo Bar'],
            ['foo[bar]', 'Foo Bar'],
            ['foo[bar_tar]', 'Foo Bar Tar']
        ];
    }
}