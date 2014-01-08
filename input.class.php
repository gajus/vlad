<?php
namespace ay\vlad;

class Input {
	private
		$input,
		$translator,
		$subject_index = [];

	public function __construct (array $input, Translator $translator) {
		$this->input = $input;
		$this->translator = $translator;
	}

	public function getSubject (Selector $selector) {
		if (isset($this->subject_index[$selector->getSelector()])) {
			return $this->subject_index[$selector->getSelector()];
		}

		// Find value matching the selector in the $input.
		$value = $this->input;
		$found = true;

		foreach ($selector->getPath() as $name) {
			if (array_key_exists($name, $value)) {
				$value = $value[$name];
			} else {
				$value = null;
				$found = false;
				
				break;
			}
		}

		$subject = new Subject($this, $selector, $this->translator->getSelectorName($selector), $value, $found);

		$this->subject_index[$selector->getSelector()] = $subject;

		return $subject;
	}

	public function getInput () {
		// @todo return array of all input elements matching $used_selectors.
	}

	private function parseSelectorPath ($selector) {
		return explode('[', str_replace(']', '', $selector));
	}
}