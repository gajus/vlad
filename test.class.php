<?php
namespace ay\vlad;

/**
 * Test instance is carrying selectors and validators.
 * Test case be used to assess input, which will produce Result.
 *
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Test {
	private
		/**
		 * @var Translator
		 */
		$translator,
		/**
		 * 
		 *
		 * @see Test::addValidator
		 * @var array
		 */
		$script = [];

	final public function __construct (Translator $translator = null) {
		$this->translator = $translator === null ? new Translator(): $translator;
	}

	/**
	 * Add a Validator with assigned selector and processing type to the Test script.
	 * 
	 * @see Result::assess()
	 * @param string $failure_scenario soft|hard|break
	 * @return Test
	 */
	public function addValidator ($selector, \ay\vlad\Validator $validator, $failure_scenario = 'hard') {
		if (!isset($this->test[$selector])) {
			$this->test[$selector] = [];
		}

		if (!in_array($failure_scenario, ['silent', 'soft', 'hard', 'break'])) {
			throw new \BadMethodCallException('Validator $failure_scenario must be soft, hard or break.');
		}

		$this->script[$selector][] = [
			'failure_scenario' => $failure_scenario,
			'validator' => $validator
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