<?php
namespace Gajus\Vlad\Validator;

/**
 * Validate that input value is syntactically valid email address.
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Email extends \Gajus\Vlad\Validator {
    static protected
        $message = '{input.name} is not a valid email address.';

    public function assess ($value) {
        if (!is_scalar($value)) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Input is not a scalar value.');
        }

        return !!filter_var($value, \FILTER_VALIDATE_EMAIL);
    }
}
