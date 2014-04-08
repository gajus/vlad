<?php
namespace Gajus\Vlad\Validator;

/**
 * Validate that input is a string.
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Integer extends \Gajus\Vlad\Validator {
	static protected
		$default_options = [
			'strict' => false
		],
		$message = '{input.name} is not an integer.';

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();

		if (!is_bool($options['strict'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Boolean property assigned non-boolean value.');
		}
	}
	
	public function assess ($value) {
		$options = $this->getOptions();

		if ($options['strict']) {
			return is_int($value);
		} else {
			return ctype_digit(ltrim((string) $value, '-'));
		}
	}
}