<?php
namespace gajus\vlad;

/**
 *
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Assessment {
	private
		/**
		 * @var Input
		 */
		$input,
		/**
		 * @var Translator
		 */
		$translator,
		/**
		 * @var array
		 */
		$errors;

	/**
	 * @param Input $input
	 * @param Translator $translator
	 * @param array $errors
	 */
	final public function __construct (Input $input, Translator $translator, array $errors) {
		$this->input = $input;
		$this->translator = $translator;
		$this->errors = $errors;
	}

	public function getErrors () {
		return $this->errors;
	}

	public function getInput () {
		return $this->input;
	}
}