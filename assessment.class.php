<?php
namespace ay\vlad;

class Assessment {
	private
		$subject,
		$validator,
		$error;

	public function __construct (Subject $subject, Validator $validator, Translator $translator) {
		$this->subject = $subject;
		$this->validator = $validator;

		$error_name = $validator->validate($subject->getValue());

		if ($error_name) {
			$this->error = $translator->getErrorMessage($error_name, $validator, $subject);
		}
	}

	public function getSubject () {
		return $this->subject;
	}

	public function getValidator () {
		return $this->validator;
	}

	public function getError () {
		return $this->error;
	}
}