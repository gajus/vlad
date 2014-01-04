<?php
namespace ay\vlad;

class Translator {	
	private
		$dictionary = [];

	public function __construct () {}

	public function getInputName ($selector) {
		if (isset($this->dictionary['input_name'][$selector])) {
			return $this->dictionary['input_name'][$selector];
		}

		return $this->deriveInputName($this->parsePath($selector));
	}

	public function getRuleMessage ($rule_name, $error_name, $pack) {
		//$this->dictionary['rule'][$rule_name][$error_name]

		//ay( $rule_name, $error_name, $pack );
	}

	/**
	 * @param string $selector foo_bar[baz][qux] => ['foo_bar', 'baz', 'qux'].
	 */
	private function parsePath ($selector) {
		return explode('[', str_replace(']', '', $selector));
	}

	/**
	 * @param array $selector_path ['baz', 'foo_bar'] => Bar Foo Bar.
	 */
	private function deriveInputName (array $selector_path) {
		return ucwords(implode(' ', explode('_', implode('_', $selector_path))));
	}
}