<?php
namespace gajus\vlad;

/**
 * Translator instance is passed to Result instance and is used to translate individual error messages
 * and give names to the selectors.
 *
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Translator {	
	private
		/**
		 * Dictionary carries all of the translations. By default, $dictionary
		 * is populated by the constructor upon initiating the Translator.
		 * 
		 * @var array
		 */
		$dictionary = [
			'selector' => [],
			'validator_error' => [],
			'validator_error_selector' => []
		];

	final public function __construct (array $dictionary = []) {
		$this->populate($dictionary);
	}

	public function getDictionary () {
		return $this->dictionary;
	}

	/**
	 * Validate array to ensure compatible dictionary structure and overwrite the internal $dictionary.
	 *
	 * @todo Validate that all message resolve an existing validator error.
	 * @return void
	 */
	private function populate (array $dictionary) {
		if (array_diff(array_keys($dictionary), ['selector', 'validator_error', 'validator_error_selector'])) {
			throw new \InvalidArgumentException('$dictionary must be an array containing at least one sub-array defining "selector", "validator_error" or "validator_error_selector".');
		}

		if (isset($dictionary['selector'])) {
			foreach ($dictionary['selector'] as $message) {
				if (!is_string($message)) {
					throw new \InvalidArgumentException('"selector" translation must be a string.');
				}
			}
		}

		if (isset($dictionary['validator_error_selector'])) {
			foreach ($dictionary['validator_error_selector'] as $validator_error_selector => $message) {
				$validator_error_selector = explode(' ', $validator_error_selector);

				if (count($validator_error_selector) != 3) {
					throw new \InvalidArgumentException('"validator_error_selector" translation query must break into exactly 3 parts (validator, error, selector).');
				}

				if (!class_exists($validator_error_selector[0])) {
					throw new \InvalidArgumentException('Validator in the "validator_error_selector" dictionary does not exist.');
				} else if (!is_subclass_of($validator_error_selector[0], 'gajus\vlad\Validator')) {
					throw new \InvalidArgumentException('Validator in the "validator_error_selector" dictionary does not extend gajus\vlad\Validator.');
				}

				if (!isset($validator_error_selector[0]::getMessages()[$validator_error_selector[1]])) {
					throw new \InvalidArgumentException('Error in the "validator_error_selector" translation does not refer to a known error.');
				}

				if (!is_string($message)) {
					throw new \InvalidArgumentException('"validator_error_selector" error translation must be a string.');
				}
			}
		}

		if (isset($dictionary['validator_error'])) {
			foreach ($dictionary['validator_error'] as $validator_name => $errors) {
				if (!class_exists($validator_name)) {
					throw new \InvalidArgumentException('Validator in the "validator_error" dictionary does not exist.');
				} else if (!is_subclass_of($validator_name, 'gajus\vlad\Validator')) {
					throw new \InvalidArgumentException('Validator in the "validator_error" dictionary does not extend gajus\vlad\Validator.');
				}

				if (!is_array($errors)) {
					throw new \InvalidArgumentException('"validator_error" entry must include an array of validators, containing an array of errors, containing an array of messages.');
				}

				foreach ($errors as $error_name => $message_collection) {
					if (!isset($validator_name::getMessages()[$error_name])) {
						throw new \InvalidArgumentException('Error in the "validator_error" translation does not refer to a known error.');
					}
					
					if (!is_array($message_collection)) {
						throw new \InvalidArgumentException('"validator_error" message must be an array containing two messages.');
					} else if (count($message_collection) != 2) {
						throw new \InvalidArgumentException('"validator_error" message array must contain two messages.');
					}

					foreach ($message_collection as $message) {
						if (!is_string($message)) {
							throw new \InvalidArgumentException('Individual "validator_error" messages must be a string.');
						}
					}
				}				
			}
		}

		$this->dictionary = $dictionary;
	}

	/**
	 * Retrieve selector name from the $dictionary.
	 *
	 * @return string
	 */
	public function getSelectorName (Selector $selector) {
		if (isset($this->dictionary['selector'][$selector->getSelector()])) {
			return $this->dictionary['selector'][$selector->getSelector()];
		}

		// Convert array selector representation (['baz', 'foo_bar']) to English friendly representation (Bar Foo Bar).
		return ucwords(implode(' ', explode('_', implode('_', $selector->getpath()))));
	}

	/**
	 * Retrieve error message from the $dictionary or use the default Validator error message.
	 * Replace variables in the resulting error message.
	 *
	 * @param Error $error
	 * @param Validator $validator
	 * @param Subject $subject
	 * @return string
	 */
	public function getErrorMessage (Error $error) {
		$error_name = $error->getName();
		$subject = $error->getSubject();
		$validator = $error->getValidator();

		$validator_error = [mb_strtolower( get_class($validator) ), $error_name];
		$validator_error_selector = mb_strtolower( get_class($validator) ) . ' ' . $error_name . ' ' . $subject->getSelector()->getSelector();

		// Enforce check presense of the error message in the original Validator.
		$message = $validator->getMessage($error_name);

		if (isset($this->dictionary['validator_error_selector'][$validator_error_selector])) {
			$message = $this->dictionary['validator_error_selector'][$validator_error_selector];
			
			// This is input specific error already.
			$message = [$message, null];
		} else if (isset($this->dictionary['validator_error'][$validator_error[0]][$validator_error[1]])) {
			$message = $this->dictionary['validator_error'][$validator_error[0]][$validator_error[1]];
		}

		$message = preg_replace_callback('/\{vlad\.([a-z\.]+)}/i', function ($e) use ($subject, $validator) { // \.(?:a-z\.)+\}
			$path = explode('.', $e[1]);

			if ($path[0] === 'subject' && $path[1] === 'name') {
				return $subject->getName();
			} else if ($path[0] === 'validator' && $path[1] === 'options') {
				$options = $validator->getOptions();

				if (isset($path[2]) && isset($options[$path[2]]) && is_scalar($options[$path[2]])) {
					return $options[$path[2]];
				}
			}

			throw new \InvalidArgumentException('Unknown variable ' . $e[0] . '.');
		}, $message);

		return $message;
	}
}