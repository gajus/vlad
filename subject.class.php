<?php
namespace ay\vlad;

class Subject {
	private
		$selector,
		$name,
		$value;

	public function __construct ($selector, array $input, Translator $translator) {
		$this->selector = $selector;
		
		// @todo regex (use http_build_str to flatten data array and recursive array walk to get rid of the long values)
		
		$this->value = $input;
		
		foreach ($this->getSelectorPath() as $name) {
			if (array_key_exists($name, $this->value)) {
				$this->value = $this->value[$name];
			} else {
				$this->value = null;
				
				break;
			}
		}

		// @todo Instead of defaulting to treating null as an empty value/not found value, there should be a flag indicating whether it is a valid value.

		$this->name = $translator->getSelectorName($selector);
	}

	public function getName () {
		return $this->name;
	}

	public function getSelector () {
		return $this->selector;
	}

	public function getSelectorPath () {
		return explode('[', str_replace(']', '', $this->selector));
	}
	
	public function getValue () {
		return $this->value;
	}
}