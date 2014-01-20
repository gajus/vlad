<?php
namespace gajus\vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
abstract class Validator {
	private
		$instance_options = [];
	
	static protected
		$requires_value = true,
		$default_options = [],
		$messages = [];

	/**
	 * @throws BadMethodCallException if either of the $options argument properties do not already exist in the instance $options array.
	 */
	public function __construct (array $options = []) {
		$unrecognised_options = \array_diff_key($options, static::$default_options);
		
		if ($unrecognised_options) {
			throw new \InvalidArgumentException('Unrecognised option.');
		}
		
		$this->instance_options = $options + array_filter(static::$default_options, function ($e) { return !is_null($e); });
	}

	/**
	 * @return array
	 */
	public function getOptions () {
		return $this->instance_options;
	}

	/**
	 * @param string $error_name
	 * @return string
	 */
	static public function getMessage ($error_name) {
		if (!isset(static::$messages[$error_name])) {
			throw new \InvalidArgumentException('Undefined error message.');
		}
		
		return static::$messages[$error_name];
	}

	/**
	 * Return all possible error messages. This is used by the Translator to test the translator input array.
	 *
	 * @return array
	 */
	static public function getMessages () {
		return static::$messages;
	}

	public function assess (Subject $subject) {
		if (static::$requires_value && !$subject->isFound()) {
			throw new \RuntimeException('Validator cannot be used with undefined input.');
		}

		$error_name = $this->validate($subject);

		if ($error_name) {
			return new \gajus\vlad\Error($this, $subject, $error_name, static::getMessage($error_name));
		}
	}
	
	abstract protected function validate (Subject $subject);
}