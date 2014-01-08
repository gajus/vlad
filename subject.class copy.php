<?php
namespace ay\vlad;

/**
 * Subject refers to a selector and derived value from the input matching
 * the selector.
 */
class Subject {
	private
		$input_node,
		$name,
		$value;

	public function __construct (Input_Node $input_node, Translator $translator) {
		$this->input_node = $input_node;
		
		// @todo regex (use http_build_str to flatten data array and recursive array walk to get rid of the long values).
		
		$this->name = $translator->getSelectorName($input_node->getSelector());

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
	 * Convert string selector representation (foo_bar[baz][qux]) to array representation (['foo_bar', 'baz', 'qux']).
	 *
	 * @param string $selector
	 * @return array
	 */
	private function getSelectorPath ($selector) {
		return explode('[', str_replace(']', '', $selector));
	}

	/**
	 * Convert array selector representation (['baz', 'foo_bar']) to English friendly representation (Bar Foo Bar).
	 *
	 * @see Translator::parseSelectorPath
	 * @param array $selector_path
	 * @return string
	 */
	private function deriveSelectorName () {
		$selector_path = $this->input_node->getSelector();

		return ucwords(implode(' ', explode('_', implode('_', $selector_path))));
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
		return $this->input_node->getValue();
	}

	public function getInputNode () {
		return $this->input_node;
	}
}