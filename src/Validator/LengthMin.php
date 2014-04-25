<?php
namespace Gajus\Vlad\Validator;

/**
 * Validate that input string representation is not shorter than the specified length.
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class LengthMin extends \Gajus\Vlad\Validator {
    static protected
        $default_options = [
            'length' => null
        ],
        $message = '{input.name} must be at least {validator.options.length} characters long.';

    public function __construct (array $options = []) {
        parent::__construct($options);

        $options = $this->getOptions();

        if (!isset($options['length'])) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('"length" option is required.');
        }

        if (!ctype_digit((string) $options['length'])) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('"length" option must be a whole number.');
        }
    }
    
    public function assess ($value) {
        $options = $this->getOptions();

        return mb_strlen($value) >= $options['length'];
    }
}