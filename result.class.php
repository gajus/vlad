<?php
namespace ay\vlad;

class Result {
	private
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

	public function getFailed ($format = 'default') {
		$result = array_filter($this->result, function ($r) {
			return $r->getError();
		});

		$result = $this->format($result, $format);		

		return $result;
	}

	public function getPassed ($format = 'default') {
		return array_filter($this->result, function ($r) {
			return !$r->getError();
		});

		$result = $this->format($result, $format);

		return $result;
	}

	public function getAll () {
		return $this->format($this->result, $format);
	}

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