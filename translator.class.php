<?php
namespace ay\vlad;

/**
 * Translator instance is passed to Result instance
 * and is used to translate individual error messages
 * and give names to the selectors.
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
			'selector' => [
				// Give 'vladfoo' selector 'Vlad Foo' name.
				'vladfoo' => 'Vlad Foo'
			],
			'validator_error' => [
				// Replace the default email invalid_format error message.
				'ay\vlad\validator\email.invalid_format' => [
					'{vlad.subject.name} must be a valid email address.',
					'The input must be a valid email address.'
				]
			],
			'validator_error_selector' => [
				// Replace the default email invalid_format error message for a specific selector.
				'ay\vlad\validator\email.invalid_format vladfoo' => 'Oops. Email address does not seem to be valid.'
			]
		];

	final public function __construct (array $dictionary = []) {
		$this->populate($dictionary);
	}

	/**
	 * Validate array to ensure compatible dictionary
	 * structure and overwrite the internal $dictionary.
	 *
	 * @return void
	 */
	final private function populate (array $dictionary) {
		if (array_diff(array_keys($dictionary), ['selector', 'validator_error', 'validator_error_selector'])) {
			throw new \BadMethodCallException('$dictionary must be an array containing at least one sub-array defining "selector", "validator_error" or "validator_error_selector".');
		}

		if (isset($dictionary['selector'])) {
			foreach ($dictionary['selector'] as $translation) {
				if (!is_string($translation)) {
					throw new \BadMethodCallException('Selector translation must be a string.');
				}
			}
		}

		if (isset($dictionary['validator_error_selector'])) {
			foreach ($dictionary['validator_error_selector'] as $translation) {
				if (!is_string($translation)) {
					throw new \BadMethodCallException('Selector specific validation translation must be a string.');
				}
			}
		}

		if (isset($dictionary['validator_error'])) {
			foreach ($dictionary['validator_error'] as $translation) {
				if (!is_array($translation)) {
					throw new \Exception('Error message must be an array.');
				} else if (count($translation) != 2) {
					throw new \Exception('Error message array must be exactly two messages long.');
				} else if (!isset($translation[0], $translation[1]) || !is_string($translation[0]) || !is_string($translation[1])) {
					throw new \Exception('Invalid error message format.');
				}
			}
		}

		$this->dictionary = $dictionary;
	}

	/**
	 * Retrieve selector name from the $dictionary.
	 *
	 * @return string|void
	 */
	public function getSelectorName ($selector) {
		if (isset($this->dictionary['selector'][$selector])) {
			return $this->dictionary['selector'][$selector];
		}
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
	public function getErrorMessage ($error_name, Validator $validator, Subject $subject) {
		$validator_error = mb_strtolower( get_class($validator) ) . '.' . $error_name;
		$validator_error_selector = $validator_error . ' ' . $subject->getSelector();

		// Enforce check presense of the error message in the original Validator.
		$message = $validator->getMessage($error_name);

		if (isset($this->dictionary['validator_error_selector'][$validator_error_selector])) {
			$message = $this->dictionary['validator_error_selector'][$validator_error_selector];
			
			if (!is_string($message)) {
				throw new \Exception('Selector specific error message must be a string.');
			
			}
			// This is input specific error already.
			$message = [$message, null];
		} else if (isset($this->dictionary['validator_error'][$validator_error])) {
			$message = $this->dictionary['validator_error'][$validator_error];
		}

		if (!is_array($message)) {
			throw new \Exception('Error message must be an array.');
		} else if (count($message) != 2) {
			throw new \Exception('Error message array must be exactly two messages long.');
		} else if (!isset($message[0], $message[1]) || !is_string($message[0]) || !is_string($message[1])) {
			// validator_error_selector is allowed to omit the generic message.
			if (!isset($this->dictionary['validator_error_selector'][$validator_error_selector]) || !is_null($message[1])) {
				throw new \Exception('Invalid error message format.');
			}			
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

			throw new \Exception('Unknown variable ' . $e[0] . '.');
		}, $message);

		return $message;
	}

	
}