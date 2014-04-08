<?php
namespace Gajus\Vlad\Validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class LengthMin extends \Gajus\Vlad\Validator {
	static protected
		$default_options = [
			'min' => null
		],
		$message = '{input.name} must be at least {validator.options.min} characters long.';

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();

		if (!isset($options['min'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"min" option is required.');
		}

		if (isset($options['min']) && !ctype_digit((string) $options['min'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"min" option must be a whole number.');
		}
	}
	
	public function assess ($value) {
		$options = $this->getOptions();

		return mb_strlen($value) >= $options['min'];
	}
}