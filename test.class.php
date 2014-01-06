<?php
namespace ay\vlad;

/**
 * Test instance is carrying selectors and rules.
 * Test case be used to assess input, which will produce Result.
 */
class Test {
	private
		/**
		 * @var Translator
		 */
		$translator,
		/**
		 * Carries test script, which defines selectors, rules and rule processing type.
		 *
		 * @see Test::addRule
		 * @var array
		 */
		$script = [];

	final public function __construct (Translator $translator = null) {
		$this->translator = $translator === null ? new Translator(): $translator;
	}

	/**
	 * Add a Rule with assigned selector and processing type to the Test script.
	 * 
	 * @see Result::assess()
	 * @param string $processing_type soft|hard|break
	 * @return Test
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

		return $this;
	}

	public function getScript () {
		return $this->script;
	}

	/**
	 * Instantiate Result instance using the test script and user input.
	 *
	 * @param array $input The input to run the test against. If null, defaults to $_POST.
	 * @return Result
	 */
	public function assess (array $input = null) {
		if ($input === null) {
			$input = $_POST;
		}

		return new Result($this, $input, $this->translator);
	}
}