<?php
namespace ay\vlad\rule;

class Not_Empty extends \ay\vlad\Rule {
	public function isValid () {
		return strlen(trim($this->value));
	}
	
	public function getMessage () {
		return [
			'name' => 'is_empty',
			'message' => 'Value is required and can\'t be empty.'
		];
	}
}