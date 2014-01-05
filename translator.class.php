<?php
namespace ay\vlad;

class Translator {	
	private
		$dictionary = [
			'selector' => [
				// Replace 'vladfoo' to Vlad Foo.
				'vladfoo' => 'Vlad Foo'
			],
			'rule_error' => [
				// Replace the default email invalid_format error message.
				'ay\vlad\email.vladfoo' => '{vlad.input.name} must be a valid email address.'
			],
			'rule_error_selector' => [
				// Replace the default email invalid_format error message for a specific selector.
				'ay\vlad\email.invalid_format vladfoo' => 'Oops. Email address does not seem to be valid.'
			]
		];

	/**
	 * The selector not is retrieved either from the $dictionary,
	 * or derived from the $selector itself.
	 *
	 * @see Translator::deriveSelectorName()
	 */
	public function getSelectorName ($selector) {
		if (isset($this->dictionary['selector'][$selector])) {
			return $this->dictionary['selector'][$selector];
		}

		return $this->deriveSelectorName($this->parseSelectorPath($selector));
	}

	/**
	 * The error message is retrieved from the $dictionary.
	 * 'rule_error' is the most generic translation of the rule
	 * error. The latter is used either to replace the default error
	 * message system-wise or for i18l purposes.
	 * 'rule_error_selector' is selector specific rule error message.
	 *
	 * @param Error $error
	 * @param Rule $rule
	 * @param Subject $subject
	 */
	public function getErrorMessage (Error $error, Rule $rule, Subject $subject) {
		$rule_error = mb_strtolower( get_class($rule) ) . '.' . $error->getName();
		$rule_error_selector = $rule_error . ' ' . $subject->getSelector();

		if (isset($this->dictionary['rule_error_selector'][$rule_error_selector])) {
			return $this->dictionary['rule_error_selector'][$rule_error_selector];
		} else if (isset($this->dictionary['rule_error'][$rule_error])) {
			return $this->dictionary['rule_error'][$rule_error];
		}

		return $error->getMessage();
	}

	/**
	 * @param string $selector foo_bar[baz][qux] => ['foo_bar', 'baz', 'qux'].
	 */
	private function parseSelectorPath ($selector) {
		return explode('[', str_replace(']', '', $selector));
	}

	/**
	 * @param array $selector_path ['baz', 'foo_bar'] => Bar Foo Bar.
	 */
	private function deriveSelectorName (array $selector_path) {
		return ucwords(implode(' ', explode('_', implode('_', $selector_path))));
	}
}