<?php
namespace ay\vlad\validator;

class Not_Empty extends \ay\vlad\Validator {
	protected
		$messages = [
			'is_empty' => [
				'{vlad.subject.name} cannot be empty.',
				'The input cannot be empty.'
			]
		];
	
	public function validate ($input) {
		if (!is_null($input) && !is_string($input) && !is_int($input) && !is_float($input) && !is_bool($input) && !is_array($input) && !is_object($input)) {
			throw new \InvalidArgumentException('Invalid type given. String, integer, float, boolean or array expected');
		}

		if (is_null($input) || !preg_replace('/^\s+$/', '', $input)) {
			return 'is_empty';
		}
	}
}