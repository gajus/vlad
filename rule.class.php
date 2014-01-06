<?php
namespace ay\vlad;

abstract class Rule {
	protected
		$options = [],
		$messages = [];
	
	/**
	 * @throws BadMethodCallException if either of the $options argument properties do not already exist in the instance $options array.
	 */
	final public function __construct (array $options = []) {
		$unrecognised_options = \array_diff_key($options, $this->options);
		
		if ($unrecognised_options) {
			throw new \BadMethodCallException('Unrecognised options: ' . implode(', ', array_keys($unrecognised_options)) . '.');
		}
		
		$this->options = $options + $this->options;
	}

	/**
	 * @return array
	 */
	final public function getOptions () {
		return $this->options;
	}

	/**
	 * @throws Exception if $error_name is undefined in the $messages array.
	 * @param string $error_name
	 * @return string
	 */
	final public function getMessage ($error_name) {
		if (!isset($this->messages[$error_name])) {
			throw new \Exception('Undefined error message "' . $error_name . '".');
		}
		
		return $this->messages[$error_name];
	}
	
	abstract public function validate ($input);
}