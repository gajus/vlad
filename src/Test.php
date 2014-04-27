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
     * Add an assertion about a $selector_name to the test.
     *
     * @param string $selector_name
     * @return Gajus\Vlad\Assertion
     */
    public function assert ($selector_name) {
        $assertion = new \Gajus\Vlad\Assertion();

        $this->test[$selector_name][] = $assertion;

        return $assertion;
    }

    /**
     * @param array $source
     * @return array Errors.
     */
    public function assess (array $source) {
        $input = new \Gajus\Vlad\Input($source);

        $errors = [];

        foreach ($this->test as $selector_name => $assertions) {
            $selector = new \Gajus\Vlad\Selector($selector_name);
            $value = $input->getValue($selector);

            foreach ($assertions as $assertion) {
                $assertion = $assertion->assess($value);

                if ($assertion) {
                    if (isset($assertion['options']['message'])) {
                        $errors[$selector_name] = $assertion['options']['message'];
                    } else {
                        $errors[$selector_name] = $this->translator->translateMessage($assertion['validator'], $selector);
                    }

                    break;
                }
                
            }
        }

        return array_values($errors);
    }

    /**
     * @param string $selector_name
     * @param mixed $value
     * @return array Error.
     */
    public function assertion ($selector_name, $value) {
        if (!isset($this->test[$selector_name])) {
            return;
        }

        $selector = new \Gajus\Vlad\Selector($selector_name);

        foreach ($this->test[$selector_name] as $assertion) {
            $assertion = $assertion->assess($value);

            if ($assertion) {
                if (isset($assertion['options']['message'])) {
                    return $assertion['options']['message'];
                } else {
                    return $this->translator->translateMessage($assertion['validator'], $selector);
                }
            }
        }
    }
}