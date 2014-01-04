<?php
namespace ay\vlad;

class Test {
	private
		$translator,
		$test = [];

	final public function __construct (Translator $translator = null) {
		$this->translator = $translator === null ? new Translator(): $translator;
	}

	/**
	 * Rule $type determines how to progress the Test in case of a failure:
	 * – 'soft' will progress to the next Rule.
	 * – 'hard' (default) will exclude the selector from the rest of the Test.
	 * – 'break' will interrupt the Test.
	 *
	 * @param string $processing_type soft|hard|break
	 */
	public function addRule ($selector, \ay\vlad\Rule $rule, $processing_type = 'hard') {
		if (!isset($this->test[$selector])) {
			$this->test[$selector] = [];
		}

		$this->test[$selector][] = [
			'rocessing_type' => $processing_type,
			'rule' => $rule
		];
	}

	public function input (array $input_source = null) {
		if ($input_source === null) {
			$input_source = $_POST;
		}

		$result = new Result($this->translator);

		foreach ($this->test as $selector => $rules) {
			$input = new Input($selector, $input_source);

			ay( $input );

			foreach ($rules as $rule) {




				$error = $rule['rule']->input($input);

				$result->addOutcome($selector, $value, $rule['rule'], $rule['rocessing_type'], $error);

				if ($error) {
					if ($rule['rocessing_type'] === 'hard') {
						break;
					} else if ($rule['rocessing_type'] === 'break') {
						break(2);
					}
				}
			}
		}

		return $result;
	}

	
}