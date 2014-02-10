<?php
namespace Gajus\Vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
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
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Unrecognised option.');
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
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Undefined error message.');
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
			throw new \Gajus\Vlad\Exception\RuntimeException('Validator cannot be used with undefined input.');
		}

		$error = $this->validate($subject);

		if (is_string($error)) {
			return new \Gajus\Vlad\Error($this, $subject, $error, static::getMessage($error));
		} else if (is_null($error)) {
			return;
		}

		throw new \Gajus\Vlad\Exception\LogicException('Invalid validator response.');
	}
	
	/**
	 * @param gajus\vlad\Subject $subject
	 * @return string|null
	 */
	abstract protected function validate (Subject $subject);
}