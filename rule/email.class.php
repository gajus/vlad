<?php
namespace ay\vlad\rule;

class Email extends \ay\vlad\Rule {
	public function isValid () {
		return filter_var($this->value, FILTER_VALIDATE_EMAIL);
	}
	
	protected function getMessage () {
		return [
			'name' => 'invalid_format',
			'message' => 'The input is not a valid email address.'
		];
	}
}