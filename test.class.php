<?php
namespace ay\vlad;

class Test {
	private
		$translator,
		$script = [];

	final public function __construct (Translator $translator = null) {
		$this->translator = $translator === null ? new Translator(): $translator;
	}

	/**
	 * Rule $type determines how to progress the Test in case of a failure:
	 * – 'soft' will record an error and progress to the next Rule.
	 * – 'hard' (default) will record an error and exclude the selector from the rest of the Test.
	 * – 'break' will record an error and interrupt the Test.
	 *
	 * @param string $processing_type soft|hard|break
	 */
	public function addRule ($selector, \ay\vlad\Rule $rule, $processing_type = 'hard') {
		if (!isset($this->test[$selector])) {
			$this->test[$selector] = [];
		}

		if (!in_array($processing_type, ['soft', 'hard', 'break'])) {
			throw new \BadMethodCallException('Rule $processing_type must be soft, hard or break.');
		}

		$this->script[$selector][] = [
			'processing_type' => $processing_type,
			'rule' => $rule
		];
	}

	public function getScript () {
		return $this->script;
	}

	/**
	 * @param array $input The input to run the test against.
	 */
	public function assess (array $input = null) {
		if ($input === null) {
			$input = $_POST;
		}

		return new Result($this, $input, $this->translator);
	}
}