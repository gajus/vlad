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
				
				if ($error) {
					if ($operation['processing_type'] === 'hard') {
						break;
					} else if ($operation['processing_type'] === 'break') {
						break(2);
					}
				}
			}
		}

		ay($this->result);
	}

	public function getFailed () {

	}

	public function getPassed () {

	}

	public function getAll () {

	}
}