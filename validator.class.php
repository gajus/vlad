<?php
namespace ay\vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
abstract class Validator {
	private
		$instance_options = [];
	
	protected
		$default_options = [],
		$messages = [];
	
	/**
	 * @throws BadMethodCallException if either of the $options argument properties do not already exist in the instance $options array.
	 */
	final public function __construct (array $options = []) {
		$unrecognised_options = \array_diff_key($options, $this->default_options);
		
		if ($unrecognised_options) {
			throw new \BadMethodCallException('Unrecognised options: ' . implode(', ', array_keys($unrecognised_options)) . '.');
		}
		
		$this->instance_options = $options + $this->default_options;
	}

	/**
	 * @return array
	 */
	final public function getOptions () {
		return $this->instance_options;
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
	
	abstract public function validate (Subject $subject);
}