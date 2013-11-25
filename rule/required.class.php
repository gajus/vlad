<?php
namespace ay\vlad\rule;

class Required extends \ay\vlad\Rule {
	protected
		$messages = [
			'is_null' => '{vlad.input.options.name} is required.',
			'is_empty' => '{vlad.input.options.name} cannot be empty.'
		];
	
	protected function validate () {
		if (is_null($this->value)) {
			$this->error_name = 'is_null';
		} else if (!strlen($this->value)) {
			$this->error_name = 'is_empty';
		}
	}
}