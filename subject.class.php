<?php
namespace ay\vlad;

/**
 * Subject refers to a selector and derived value from the input matching
 * the selector.
 */
class Subject {
	private
		/**
		 * Data resource locator representend using query-parameter, e.g. foo[bar][tar].
		 *
		 * @var string
		 */
		$selector,
		$name,
		$value;

	public function __construct ($selector, array $input, Translator $translator) {
		$this->selector = $selector;
		
		// @todo regex (use http_build_str to flatten data array and recursive array walk to get rid of the long values).
		
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

		if (!$this->name) {
			$this->name = $this->deriveSelectorName();
		}
	}

	/**
	 * @return string
	 */
	public function getName () {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getSelector () {
		return $this->selector;
	}

	/**
	 * Convert string selector representation (foo_bar[baz][qux]) to array representation (['foo_bar', 'baz', 'qux']).
	 *
	 * @param string $selector
	 * @return array
	 */
	private function getSelectorPath () {
		return explode('[', str_replace(']', '', $this->selector));
	}

	/**
	 * Convert array selector representation (['baz', 'foo_bar']) to English friendly representation (Bar Foo Bar).
	 *
	 * @see Translator::parseSelectorPath
	 * @param array $selector_path
	 * @return string
	 */
	private function deriveSelectorName () {
		return ucwords(implode(' ', explode('_', implode('_', $this->getSelectorPath()))));
	}

	/**
	 * Return value retrieved from $input using the $selector.
	 * If no value is found, null is returned.
	 * This value is used by the {@link Validator::validate()}.
	 *
	 * @todo Have a flag indicating whether the value is a genuine null value or selector path did not resolve to anything.
	 * @return mixed
	 */
	public function getValue () {
		return $this->value;
	}
}