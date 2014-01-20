<?php
namespace gajus\vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Error {
	private
		/**
		 * @var Validator
		 */
		$validator,
		/**
		 * @var Subject
		 */
		$subject,
		/**
		 * @var string
		 */
		$name;

	public function __construct (Validator $validator, Subject $subject, $name) {
		$this->validator = $validator;
		$this->subject = $subject;
		$this->name = $name;
	}

	public function getSubject () {
		return $this->subject;
	}

	public function getValidator () {
		return $this->validator;
	}

	public function getName () {
		return $this->name;
	}

	public function getMessage () {
		return $this->validator->getErrorMessage($this->name);
	}
}