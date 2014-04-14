<?php
namespace Gajus\Vlad\Validator;

/**
 * Validate that a numeric input is at least of the given size (exclusive).
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class RangeMinExclusive extends \Gajus\Vlad\Validator {
    static protected
        $default_options = [
            'range' => null
        ],
        $message = '{input.name} is not more than {validator.options.range}.';

    public function __construct (array $options = []) {
        parent::__construct($options);

        $options = $this->getOptions();

        if (!isset($options['range'])) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('"range" option is required.');
        }

        if (!is_numeric($options['range'])) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Minimum boundary option must be numeric.');
        }
    }
    
    public function assess ($value) {
        $options = $this->getOptions();

        return $value > $options['range'];
    }
}