<?php
namespace gajus\vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Error {
	private
		$validator,
		$subject,
		$error_name;

	public function __construct (Validator $validator, Subject $subject, $error_name) {
		$this->validator = $validator;
		$this->subject = $subject;
		$this->error_name = $error_name;
	}

	public function getSubject () {
		return $this->subject;
	}

	public function getValidator () {
		return $this->validator;
	}

	public function getErrorName () {
		return $this->error_name;
	}

	public function getErrorMessage () {
		return $this->validator->getErrorMessage($this->error_name);
	}
}