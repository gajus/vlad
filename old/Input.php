<?php
namespace Gajus\Vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Input {
	private
		$input,
		$translator,
		$subject_index = [];

	public function __construct (array $input, Translator $translator = null) {
		$this->input = $input;

		if (!$translator) {
			$translator = new Translator();
		}

		$this->translator = $translator;
	}

	/**
	 * @param string
	 */
	public function getSubject ($selector) {
		if (isset($this->subject_index[$selector])) {
			return $this->subject_index[$selector];
		}

		$selector = new Selector($selector);		

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

	#public function getInput () {
	#	// @todo return array of all input elements matching $used_selectors.
	#}
}