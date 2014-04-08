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
     */
    public function is ($validator_name, array $validator_options = [], array $condition_options = []) {
        if (!is_string($validator_name)) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Validator name must be a string.');
        }

        #if (strpos($validator_name, '\\') === false || strpos($validator_name, 'File\\') === 0 || strpos($validator_name, 'CreditCard\\') === 0) {
            $validator_name = 'Gajus\Vlad\Validator\\' . $validator_name;
        #}
        
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

    /**
     * @param Gajus\Vlad\Input $input
     * @return null|string Error message.
     */
    public function assess (\Gajus\Vlad\Input $input) {
        $value = $input->getValue($this->selector);

        foreach ($this->assertions as $assertion) {
            $assessment = $assertion['validator']->assess($value);

            if ($assessment) {
                if (isset($assertion['options']['message'])) {
                    return $assertion['options']['message'];
                }

                $message = $assertion['validator']::getMessage($assessment);

                die(var_dump($message));

                return $message;
            }
        }
    }
}