<?php
namespace ay\vlad;

class Assessment {
	private
		$subject,
		$rule,
		$error;

	public function __construct (Subject $subject, Rule $rule, Translator $translator) {
		$this->subject = $subject;
		$this->rule = $rule;

		$error_name = $rule->validate($subject->getValue());

		if ($error_name) {
			$this->error = $translator->getErrorMessage($error_name, $rule, $subject);
		}
	}

	public function getSubject () {
		return $this->subject;
	}

	public function getRule () {
		return $this->rule;
	}

	public function getError () {
		return $this->error;
	}
}