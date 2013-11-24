<?php
namespace ay\vlad;

abstract class Rule {
	protected
		$value,
		$options = [],
		$error_name;
	
	final public function __construct ($value, array $options = []) {
		$this->value = $value;
		
		$unrecognised_options = \array_diff_key($options, $this->options);
		
		if ($unrecognised_options) {
			throw new \BadMethodCallException('Unrecognised options: ' . implode(', ', array_keys($unrecognised_options)) . '.');
		}
		
		$this->options = $options;
		
		$this->validate();
	}
	
	final public function isValid () {
		return !$this->error_name;
	}
	
	final public function getMessage () {
		if (!isset($this->messages[$this->error_name])) {
			throw new \Exception('Undefined error message "' . $this->error_name . '".');
		}
		
		return [
			'name' => $this->error_name,
			'message' => $this->messages[$this->error_name]
		];
	}
	
	abstract protected function validate ();
}