<?php
namespace ay\vlad;

class Input {
	private
		$selector,
		$selector_path = [],
		$value;

	public function __construct ($selector, array $input) {
		$this->selector = $selector;
		
		$this->selector_path = explode('[', str_replace(']', '', $selector));
		
		// @todo regex (use http_build_str to flatten data array and recursive array walk to get rid of the long values)
		
		$this->value = $input;
		
		foreach ($this->selector_path as $name) {
			if (array_key_exists($name, $this->value)) {
				$this->value = $value[$name];
			} else {
				$this->value = null;
				
				break;
			}
		}
	}

	public function getSelector () {
		return $this->selector;
	}

	public function getSelectorPath () {
		return $this->selector_path;
	}
	
	public function getValue () {
		return $this->value;
	}
}