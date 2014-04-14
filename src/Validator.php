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
		$message;

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
	 * @return string
	 */
	static public function getMessage () {
		return static::$message;
	}

	/**
	 * @param mixed $value
	 * @return boolean
	 */
	abstract public function assess ($value);
}