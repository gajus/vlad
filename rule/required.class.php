<?php
namespace ay\vlad\rule;

class Required extends \ay\vlad\Rule {
	protected
		$messages = [
			'is_null' => '{vlad.subject.name} is required.'
		];
	
	public function validate ($input) {
		if (is_null($input)) {
			return 'is_null';
		}
	}
}