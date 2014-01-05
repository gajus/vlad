<?php
namespace ay\vlad;

class Result {
	private
		$test,
		$result = [];

	final public function __construct (Test $test, $input, Translator $translator) {
		$this->assess($test, $input, $translator);
	}

	private function assess (Test $test, $input, Translator $translator) {
		$script = $test->getScript();

		foreach ($script as $selector => $batch) {
			$subject = new Subject($selector, $input, $translator);

			foreach ($batch as $operation) {
				$assessment = new Assessment($subject, $operation['rule'], $translator);

				$this->result[] = $assessment;
				
				if ($assessment->getError()) {
					if ($operation['processing_type'] === 'hard') {
						break;
					} else if ($operation['processing_type'] === 'break') {
						break(2);
					}
				}
			}
		}
	}

	public function getFailed () {
		return array_filter($this->result, function ($r) {
			return $r->getError();
		});
	}

	public function getPassed () {
		return array_filter($this->result, function ($r) {
			return !$r->getError();
		});
	}

	public function getAll () {
		return $this->result;
	}
}