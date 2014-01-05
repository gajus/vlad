<?php
namespace ay\vlad\rule;

class Not_Empty extends \ay\vlad\Rule {
	protected
		$messages = [
			'is_empty' => '{vlad.subject.name} cannot be empty.',
		];
	
	public function validate ($input) {
		if (is_null($input) || !preg_replace('/^\s+$/', '', $input)) {
			return 'is_empty';
		}
	}
}