<?php
namespace ay\vlad;

abstract class Rule {
	protected
		$options = [],
		$messages = [];
		
	final public function __construct (array $options = []) {
		$unrecognised_options = \array_diff_key($options, $this->options);
		
		if ($unrecognised_options) {
			throw new \BadMethodCallException('Unrecognised options: ' . implode(', ', array_keys($unrecognised_options)) . '.');
		}
		
		$this->options = $options;
	}

	final public function test ($input) {
		$error_name = $this->validate($input);

		if ($error_name) {
			return $this->getMessage($error_name);
		}
	}
	
	final protected function getMessage ($error_name) {
		if (!isset($this->messages[$error_name])) {
			throw new \Exception('Undefined error message "' . $error_name . '".');
		}
		
		return [
			'name' => $error_name,
			'message' => $this->messages[$error_name]
		];
	}
	
	abstract protected function validate ($input);
}