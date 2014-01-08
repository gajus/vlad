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
	
	public function validate (\ay\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			throw new \Exception('Validator cannot be used with undefined input.');
		}

		$value = $subject->getValue();

		if (!is_string($value)) {
			throw new \InvalidArgumentException('$input is expected to be string. "' . gettype($value) . '" given instead.');
		}

		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			return 'invalid_format';
		}
	}
}