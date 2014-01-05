<?php
namespace ay\vlad\rule;

class Required extends \ay\vlad\Rule {
	protected
		$messages = [
			'is_null' => '{vlad.subject.name} is required.'
		];
	
	public function validate () {
		if (is_null($this->value)) {
			return 'is_null';
		}
	}
}