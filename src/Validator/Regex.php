<?php
namespace Gajus\Vlad\Validator;

/**
 * Validate that input is matched using a regular expression.
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Regex extends \Gajus\Vlad\Validator {
    static protected
        $default_options = [
            'pattern' => null
        ],
        $message = '{input.name} does not match against pattern "{vlad.validator.options.pattern}".';

    public function __construct (array $options = []) {
        parent::__construct($options);

        $options = $this->getOptions();
        
        if (!isset($options['pattern'])) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('"pattern" property is required.');
        }

        if (@preg_match($options['pattern'], 'test') === false) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Pattern "' . $options['pattern'] . '" failed (' . array_flip(get_defined_constants(true)['pcre'])[preg_last_error()] . ').');
        }
    }

    public function assess ($value) {
        $options = $this->getOptions();

        $match = preg_match($options['pattern'], $value);

        return $match === 1;
    }
}
