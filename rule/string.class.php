<?php
namespace ay\vlad\rule;

class String extends \ay\vlad\Rule {
	protected
		$messages = [
			'invalid_type' => '{vlad.input.options.name} must be a string.'
		];
	
	protected function validate () {
		if (!is_string($this->value)) {
			$this->error_name = 'invalid_type';
		}
	}
}