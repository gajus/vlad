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

    public function testTranslateInputName () {
        $selector = new \Gajus\Vlad\Selector('foo_bar');

        $translator = new \Gajus\Vlad\Translator();
        $translator->setInputName($selector->getName(), 'Foo Bar!');

        $this->assertSame('Foo Bar!', $translator->getInputName($selector));
    }

    public function testTranslateInputNameInTest () {
        $translator = new \Gajus\Vlad\Translator();
        $translator->setInputName('foo_bar', 'Foo Bar!');

        $test = new \Gajus\Vlad\Test($translator);
        $test
            ->assert('foo_bar')
            ->is('NotEmpty');

        $assessment = $test->assess([]);

        $this->assertCount(1, $assessment);
        $this->assertSame('Foo Bar! is empty.', $assessment[0]);
    }

    public function testTranslateErrorMessage () {
        $translator = new \Gajus\Vlad\Translator();
        $translator->setValidatorMessage('NotEmpty', '{input.name} cannot be left empty.');

        $test = new \Gajus\Vlad\Test($translator);
        $test
            ->assert('foo_bar')
            ->is('NotEmpty');

        $assessment = $test->assess([]);

        $this->assertCount(1, $assessment);
        $this->assertSame('Foo Bar cannot be left empty.', $assessment[0]);
    }

    /**
     * Technically, this does not utilise the Translator.
     * However, it is part of the message translation logic.
     */
    public function testTranslateAssertionErrorMessage () {
        $test = new \Gajus\Vlad\Test();
        $test
            ->assert('foo_bar')
            ->is('NotEmpty', null, ['message' => 'You must provide Foo Bar value.']);

        $assessment = $test->assess([]);

        $this->assertCount(1, $assessment);
        $this->assertSame('You must provide Foo Bar value.', $assessment[0]);
    }
}