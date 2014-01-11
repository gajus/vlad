<?php
namespace gajus\vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Assessment {
	private
		$subject,
		$validator,
		$error;

	public function __construct (Subject $subject, Validator $validator, Translator $translator) {
		$this->subject = $subject;
		$this->validator = $validator;

		$error_name = $validator->validate($subject);

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