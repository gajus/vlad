<?php
namespace ay\vlad\rule;

class Not_Empty extends \ay\vlad\Rule {
	protected
		$messages = [
			'is_empty' => '{vlad.input.options.name} is required and can\'t be empty.'
		];
	
	protected function validate () {
		if (!strlen($this->value)) {
			$this->error_name = 'is_empty';
		}
	}
}