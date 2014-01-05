<?php
namespace ay\vlad\rule;

class Email extends \ay\vlad\Rule {
	protected
		$messages = [
			'invalid_format' => '{vlad.subject.name} must be a valid email address.'
		];
	
	public function validate ($input) {
		if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
			return 'invalid_format';
		}
	}
}