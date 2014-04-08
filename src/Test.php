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
     * @param Gajus\Vlad\Input $input
     * @return array Errors.
     */
    public function assess (\Gajus\Vlad\Input $input) {
        $errors = [];

        foreach ($this->test as $test) {
            if ($error = $test['assertion']->assess($input)) {

                
                die(var_dump( $error ));

                //$errors[] = $this->translator->translateMessage($error);
            }
        }

        return $errors;
    }
}