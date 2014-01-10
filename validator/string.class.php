<?php
namespace ay\vlad\validator;

class String extends \ay\vlad\Validator {
	protected
		$messages = [
			'not_string' => [
				'{vlad.subject.name} is not a string.',
				'The input is not a string.'
			]
		];
	
	public function validate (\ay\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			throw new \Exception('Validator cannot be used with undefined input.');
		}

		if (!is_string($subject->getValue())) {
			return 'not_string';
		}
	}
}