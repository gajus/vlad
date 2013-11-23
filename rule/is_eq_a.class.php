<?php
namespace ay\vlad\rule;

class Is_Eq_A extends \ay\vlad\Rule {
	public function isValid () {
		return $this->value === 'a';
	}
	
	public function getMessage () {
		return ['name' => 'isNotEqA', 'message' => 'Value must be eq to "a".'];
	}
}