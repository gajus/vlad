<?php
namespace ay\vlad\rule;

class String extends \ay\vlad\Rule {
	protected
		$messages = [
			'invalid_type' => '{vlad.subject.name} must be a string.'
		];
	
	public function validate ($input) {
		if (!is_string($input)) {
			return 'invalid_type';
		}
	}
}