<?php
namespace Gajus\Vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Test {
    private
        $translator,
        $test = [];

    /**
     * @param Gajus\Vlad\Translator $translator
     */
    public function __construct (\Gajus\Vlad\Translator $translator = null) {
        if ($translator) {
            $this->translator = $translator;
        } else {
            $this->translator = new \Gajus\Vlad\Translator;
        }
    }

    /**
     * Add an assertion to the test.
     *
     * @param string $selector
     * @return Gajus\Vlad\Assertion
     */
    public function assert ($selector) {
        $assertion = new \Gajus\Vlad\Assertion($this, new \Gajus\Vlad\Selector($selector));

        $this->test[] = [
            'assertion' => $assertion
        ];

        return $assertion;
    }

    /**
     * @param array $source
     * @return array Errors.
     */
    public function assess (array $source) {
        $input = new \Gajus\Vlad\Input($source);

        $errors = [];

        foreach ($this->test as $test) {
            $selector = $test['assertion']->getSelector();

            if (isset($errors[$selector->getName()])) {
                continue;
            }

            if ($assertion = $test['assertion']->assess($input)) {
                if (isset($assertion['options']['message'])) {
                    $errors[$selector->getName()] = $assertion['options']['message'];
                } else {
                    $errors[$selector->getName()] = $this->translator->translateMessage($assertion['validator'], $selector);
                }
            }
        }

        return array_values($errors);
    }
}