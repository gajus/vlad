<?php
namespace ay\vlad\validator;

class Email extends \ay\vlad\Validator {
	protected
		$messages = [
			'invalid_format' => [
				'{vlad.subject.name} is not a valid email address.',
				'The input is not a valid email address.'
			]
		];
	
	public function validate ($input) {
		if (!is_string($input)) {
			throw new \InvalidArgumentException('$input is expected to be string. "' . gettype($input) . '" given instead.');
		}

		if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
			return 'invalid_format';
		}
	}
}