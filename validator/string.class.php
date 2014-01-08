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
	
	public function validate ($input) {
		if (!is_string($input)) {
			return 'invalid_type';
		}
	}
}