<?php
namespace Gajus\Vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Assertion {
    private
        $test,
        $selector,
        $assertions = [];

    /**
     * @param Gajus\Vlad\Test $test
     * @param Gajus\Vlad\Selector $selector
     */
    public function __construct (\Gajus\Vlad\Test $test, \Gajus\Vlad\Selector $selector) {
        $this->test = $test;
        $this->selector = $selector;
    }

    /**
     * @param string $validator_name
     * @param array $validator_options
     * @param array $condition_options
     * @return Gajus\Vlad\Assertion
     */
    public function is ($validator_name, array $validator_options = null, array $condition_options = []) {
        if ($validator_options === null) {
            $validator_options = [];
        }

        if (!is_string($validator_name)) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Validator name must be a string.');
        }

        if (strpos($validator_name, '\\') === false) {
            $validator_name = 'Gajus\Vlad\Validator\\' . $validator_name;
        }
        
        if (!class_exists($validator_name)) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Validator not found.');
        } else if (!is_subclass_of($validator_name, 'Gajus\Vlad\Validator')) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Validator must extend Gajus\Vlad\Validator.');
        }

        $this->assertions[] = [
            'validator' => new $validator_name ($validator_options),
            'options' => $condition_options
        ];

        return $this;
    }

    public function getSelector () {
        return $this->selector;
    }

    /**
     * @param Gajus\Vlad\Input $input
     * @return null|array Failed assertion.
     */
    public function assess (\Gajus\Vlad\Input $input) {
        $value = $input->getValue($this->selector);

        foreach ($this->assertions as $assertion) {
            if (!$assertion['validator']->assess($value)) {
                return $assertion;
            }
        }
    }
}