<?php
namespace gajus\vlad;

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
	public function addValidator ($selector, \gajus\vlad\Validator $validator, $failure_scenario = 'hard') {
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

	/**
	 * The exported test script is used for integration with the client-side validation.
	 *
	 * @return array
	 */
	public function getScript () {
		return $this->script;
	}

	/**
	 * Asses the test script against user input.
	 *
	 * "failure_scenario" determines how to progress the Test in case of a failure:
	 * - 'silent' exclude input from the current validator chain.
	 * – 'soft' record an error and progress to the next Validator.
	 * – 'hard' (default) record an error and exclude the selector from the rest of the Test.
	 * – 'break' record an error and interrupt the Test.
	 *
	 * @param array $input The input to run the test against. If null, defaults to $_POST.
	 * @return Result
	 */
	public function assess (array $input = null) {
		if ($input === null) {
			$input = $_POST;
		}

		$input = new Input($input, $this->translator);
		
		$script = $this->getScript();

		$result = [];

		$selectors_with_hard_failure = [];

		foreach ($script as $selector => $batch) {
			if (in_array($selector, $selectors_with_hard_failure)) {
				continue;
			}

			$subject = $input->getSubject($selector);

			foreach ($batch as $operation) {
				$error = $operation['validator']->assess($subject);

				if ($error) {
					if ($operation['failure_scenario'] === 'silent') {
						break;
					}
					
					$result[] = $error;

					if ($operation['failure_scenario'] === 'hard') {
						$selectors_with_hard_failure[] = $selector;

						break;
					} else if ($operation['failure_scenario'] === 'break') {
						break(2);
					}
				}
			}
		}

		return new Result($result, $this->translator);
	}
}