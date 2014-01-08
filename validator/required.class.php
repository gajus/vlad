<?php
namespace ay\vlad\validator;

class Required extends \ay\vlad\Validator {
	protected
		$messages = [
			'is_null' => [
				'{vlad.subject.name} is required.',
				'The input is required.'
			]
		];
	
	public function validate ($input) {
		if (is_null($input)) {
			return 'is_null';
		}
	}
}