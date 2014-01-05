<?php
namespace ay\vlad\rule;

class String extends \ay\vlad\Rule {
	protected
		$messages = [
			'invalid_type' => '{vlad.subject.name} must be a string.'
		];
	
	public function validate () {
		if (!is_string($this->value)) {
			return 'invalid_type';
		}
	}
}