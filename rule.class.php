<?php
namespace ay\vlad;

abstract class Rule {
	protected
		$value;
	
	final public function __construct ($value) {
		$this->value = $value;
	}
	
	abstract public function isValid ();
	
	abstract public function getMessage ();
}