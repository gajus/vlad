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
			ay($error_name);


			$this->error = new Error($subject, $rule, $translator);
		}


		/*$this->error = $rule->assess($subject->getValue(), $translator);

		if ($this->error) {
			$this->error = $translator->getErrorMessage($this->error, $rule, $subject);
		}*/
	}

	public function getSubject () {
		return $this->subject;
	}

	public function getRule () {
		return $this->rule;
	}

	public function getError() {
		return $ther->error;
	}
}