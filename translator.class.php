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
			'rule_error' => [
				// Replace the default email invalid_format error message.
				'ay\vlad\rule\email.invalid_format' => '{vlad.subject.name} must be a valid email address.'
			],
			'rule_error_selector' => [
				// Replace the default email invalid_format error message for a specific selector.
				'ay\vlad\rule\email.invalid_format vladfoo' => 'Oops. Email address does not seem to be valid.'
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
		if (array_diff(array_keys($dictionary), ['selector', 'rule_error', 'rule_error_selector'])) {
			throw new \BadMethodCallException('$dictionary must be an array containing at least one sub-array defining "selector", "rule_error" or "rule_error_selector".');
		}

		foreach ($dictionary as $type => $translations) {
			foreach ($translations as $t) {
				if (!is_string($t)) {
					throw new \BadMethodCallException('Individual translations must be a string.');
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
	 * Retrieve error message from the $dictionary or use the default Rule error message.
	 * Replace variables in the resulting error message.
	 *
	 * @param Error $error
	 * @param Rule $rule
	 * @param Subject $subject
	 * @return string
	 */
	public function getErrorMessage ($error_name, Rule $rule, Subject $subject) {
		$rule_error = mb_strtolower( get_class($rule) ) . '.' . $error_name;
		$rule_error_selector = $rule_error . ' ' . $subject->getSelector();

		// Enforce check presense of the error message in the original Rule.
		$message = $rule->getMessage($error_name);

		if (isset($this->dictionary['rule_error_selector'][$rule_error_selector])) {
			$message = $this->dictionary['rule_error_selector'][$rule_error_selector];
		} else if (isset($this->dictionary['rule_error'][$rule_error])) {
			$message = $this->dictionary['rule_error'][$rule_error];
		}

		$message = preg_replace_callback('/\{vlad\.([a-z\.]+)}/i', function ($e) use ($subject, $rule) { // \.(?:a-z\.)+\}
			$path = explode('.', $e[1]);

			if ($path[0] === 'subject' && $path[1] === 'name') {
				return $subject->getName();
			} else if ($path[0] === 'rule' && $path[1] === 'options') {
				$options = $rule->getOptions();

				if (isset($path[2]) && isset($options[$path[2]]) && is_scalar($options[$path[2]])) {
					return $options[$path[2]];
				}
			}

			throw new Exception('Unknown variable ' . $e[0] . '.');
		}, $message);

		return $message;
	}

	
}