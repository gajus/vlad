<?php
namespace Gajus\Vlad\Validator;

/**
 * Validates that string can be parsed using a date format.
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Date extends \Gajus\Vlad\Validator {
    static protected
        $default_options = [
            'format' => null
        ],
        $message = '{input.name} cannot be parsed using "{validator.options.format}" date format.';

    public function __construct (array $options = []) {
        parent::__construct($options);

        $options = $this->getOptions();
        
        if (!isset($options['format'])) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('"format" property is required.');
        }
    }

    public function assess ($value) {
        $options = $this->getOptions();

        return !!\DateTime::createFromFormat($options['format'], $value);
    }
}
