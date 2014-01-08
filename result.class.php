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
	 * – 'soft' will record an error and progress to the next Validator.
	 * – 'hard' (default) will record an error and exclude the selector from the rest of the Test.
	 * – 'break' will record an error and interrupt the Test.
	 *
	 * @see Test::addValidator()
	 * @return void
	 */
	final private function assess (Test $test, array $input, Translator $translator) {
		$script = $test->getScript();

		foreach ($script as $selector => $batch) {
			$subject = new Subject($selector, $input, $translator);

			foreach ($batch as $operation) {
				$assessment = new Assessment($subject, $operation['validator'], $translator);

				$this->result[] = $assessment;
				
				if ($assessment->getError()) {
					if ($operation['failure_scenario'] === 'hard') {
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
	 * @param string $format
	 * @return array
	 */
	public function getFailed ($format = 'default') {
		$result = array_filter($this->result, function ($r) {
			return $r->getError();
		});

		$result = $this->format($result, $format);		

		return $result;
	}

	/**
	 * Return array of passed Assessments.
	 *
	 * @param string $format
	 * @return array
	 */
	public function getPassed ($format = 'default') {
		return array_filter($this->result, function ($r) {
			return !$r->getError();
		});

		$result = $this->format($result, $format);

		return $result;
	}

	/**
	 * Return array of all Assessments.
	 *
	 * @param string $format
	 * @return array
	 */
	public function getAll () {
		return $this->format($this->result, $format);
	}

	/**
	 * @param array $result
	 * @param string $format default|debug
	 * @return array
	 */
	private function format ($result, $format = 'default') {
		if ($format === 'debug') {
			return $result;
		}

		$result = array_map(function ($r) {
			$subject = $r->getSubject();

			return [
				'selector' => $subject->getSelector(),
				'message' => $r->getError()
			];
		}, $result);

		return $result;
	}
}