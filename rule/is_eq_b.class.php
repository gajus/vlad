<?php
namespace ay\vlad\rule;

class Is_Eq_B extends \ay\vlad\Rule {
	public function isValid () {
		return $this->value === 'b';
	}
	
	public function getMessage () {
		return ['name' => 'isNotEqA', 'message' => 'Value must be eq to "b".'];
	}
}