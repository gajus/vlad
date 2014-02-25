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
		$default_options = [],
		$messages = [];

	/**
	 * @param array $options
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

	/**
	 * @return null|string
	 */
	abstract public function assess ($value);
}