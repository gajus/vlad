<?php
namespace ay\vlad\validator;

class String extends \ay\vlad\Validator {
	protected
		$messages = [
			'invalid_type' => [
				'{vlad.subject.name} must be a string.',
				'The input must be a string.'
			]
		];
	
	public function validate (\ay\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			throw new \Exception('Validator cannot be used with undefined input.');
		}

		if (!is_string($subject->getValue())) {
			return 'invalid_type';
		}
	}
}