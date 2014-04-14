<?php
namespace Gajus\Vlad\Validator;

/**
 * Validate that input is a string.
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class String extends \Gajus\Vlad\Validator {
    static protected
        $default_options = [
            'strict' => false
        ],
        $message = '{input.name} is not a string.';

    public function __construct (array $options = []) {
        parent::__construct($options);

        $options = $this->getOptions();

        if (!is_bool($options['strict'])) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Boolean property assigned non-boolean value.');
        }
    }
    
    public function assess ($value) {
        $options = $this->getOptions();

        if (!$options['strict']) {
            if (is_numeric($value)) {
                $value = (string) $value;
            }
        }

        return is_string($value);
    }
}