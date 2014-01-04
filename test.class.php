<?php
namespace ay\vlad;

class Test {
	private
		$translator,
		$selector_rules = [];

	final public function __construct (Translator $translator = null) {
		$this->translator = $translator === null ? new Translator(): $translator;
	}

	public function addRule ($selector, \ay\vlad\Rule $rule) {
		if (!isset($this->selector_rules[$selector])) {
			$this->selector_rules[$selector] = [];
		}

		$this->selector_rules[$selector][] = $rule;
	}

	public function input (array $input) {
		$result = new Result($this->translator);

		foreach ($this->selector_rules as $selector => $rules) {
			$selector_path = $this->getPath($selector);
			$selector_value = $this->getValue($selector_path, $input);

			foreach ($rules as $rule) {

				$result->add($selector, $selector_value, $rule);

				#ay( $selector, $selector_value, $rule );

				//$test_outcome = $rule->validate($selector_value);
				//$result->addRule($selector, $test_outcome);
				//ay($selector, $rule);
			}
		}

		return $result;
	}

	private function getPath ($selector) {
		return explode('[', str_replace(']', '', $selector));
	}
	
	private function getValue (array $path, array $input) {
		// @todo regex (use http_build_str to flatten data array and recursive array walk to get rid of the long values)
		
		$value = $input;
		
		foreach ($path as $name) {
			if (array_key_exists($name, $value)) {
				$value = $value[$name];
			} else {
				$value = null;
				
				break;
			}
		}
		
		return $value;
	}
}