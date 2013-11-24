<?php
namespace ay\vlad\rule;

class Email extends \ay\vlad\Rule {
	protected
		$messages = [
			'invalid_format' => '{vlad.name} must be a valid email address.'
		];
	
	protected function validate () {
		if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
			$this->error_name = 'invalid_format';
		}
	}
}