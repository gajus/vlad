<?php
namespace ay\vlad\rule;

class String extends \ay\vlad\Rule {
	public function isValid () {
		return is_string($this->value);
	}
	
	protected function getMessage () {
		return [
			'name' => 'invalid_type',
			'message' => 'The input is not a string.'
		];
	}
}