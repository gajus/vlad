<?php
namespace gajus\vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Input {
	private
		$input,
		$translator,
		$selector_index = [],
		$subject_index = [];

	public function __construct (array $input, Translator $translator) {
		$this->input = $input;
		$this->translator = $translator;
	}

	public function getSubject ($selector) {
		if (!is_string($selector)) {
			throw new \InvalidArgumentException('Selector must be a string.');
		}

		if (isset($selector_index[$selector])) {
			$selector = $selector_index[$selector];
		} else {
			$selector = $selector_index[$selector] = new Selector($selector);
		}

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