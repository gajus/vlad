<?php
namespace ay\vlad;

/**
 * Assess the Test script against the input. The resulting object
 * instance is used to retrieve outcome of all Test cases.
 */
class Result {
	private
		$result = [];

	final public function __construct (Test $test, array $input, Translator $translator) {
		$this->assess($test, $input, $translator);
	}

	/**
	 * Assess the Test script against the used input.
	 *
	 * failure_scenario determines how to progress the Test in case of a failure:
	 * - 'silent' exclude input from the current validator chain.
	 * – 'soft' record an error and progress to the next Validator.
	 * – 'hard' (default) record an error and exclude the selector from the rest of the Test.
	 * – 'break' record an error and interrupt the Test.
	 *
	 * @see Test::addValidator()
	 * @param array $input
	 * @return void
	 */
	final private function assess (Test $test, array $input, Translator $translator) {
		$script = $test->getScript();

		$selectors_with_hard_failure = [];

		$input = new Input($input, $translator);

		foreach ($script as $selector => $batch) {
			if (in_array($selector, $selectors_with_hard_failure)) {
				continue;
			}

			$subject = $input->getSubject(new Selector($selector));

			foreach ($batch as $operation) {
				$assessment = new Assessment($subject, $operation['validator'], $translator);

				if ($assessment->getError()) {
					if ($operation['failure_scenario'] === 'silent') {
						break;
					}
					
					$this->result[] = $assessment;

					if ($operation['failure_scenario'] === 'hard') {
						$selectors_with_hard_failure[] = $selector;

						break;
					} else if ($operation['failure_scenario'] === 'break') {
						break(2);
					}
				}
			}
		}
	}

	/**
	 * Return array of failed Assessments.
	 *
	 * @param string $format default|debug
	 * @return array
	 */
	public function getFailed ($format = 'default') {
		if ($format === 'default') {
			$result = array_map(function ($r) {
				$subject = $r->getSubject();

				return [
					'selector' => $subject->getSelector(),
					'message' => $r->getError()
				];
			}, $this->result);
		} else if ($format !== 'debug') {
			throw new \InvalidArgumentException('Unknown format "' . $format . '".');
		}

		

		return $result;
	}
}