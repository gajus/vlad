<?php
namespace ay\vlad\rule;

class Not_Empty extends \ay\vlad\Rule {
	protected
		$messages = [
			'is_empty' => '{vlad.subject.name} is cannot be empty.',
		];
	
	public function validate ($input) {
		// Empty input is considered null, '', "/^\s+$/" // exclude (see http://www.regular-expressions.info/shorthand.html)
		// Not empty 0, 0.00, false, [], (object) []

		if (is_null($this->value) || !preg_replace('/^\s+$/', '', $this->value)) {
			return 'is_empty';
		}
	}
}