<?php
namespace ay\vlad;

// Not in use.

class Input {
	private
		$input,
		$selector,
		$path;

	public function __construct (array $input, $selector) {
		$this->input = $input;
		$this->selector = $selector;
	}
	
	public function getSelector () {
		return $this->selector;
	}
	
	public function getPath () {
		return explode('[', str_replace(']', '', $this->selector));
	}
	
	public function getValue () {
		// @todo regex (use http_build_str to flatten data array and recursive array walk to get rid of the possibly long values)
		
		$path = $this->getPath();
		$value = $this->input;
		
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