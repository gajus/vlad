<?php
namespace gajus\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Email extends \gajus\vlad\Validator {
	static protected
		$messages = [
			'invalid_syntax' => [
				'{vlad.subject.name} is not a valid email address.',
				'The input is not a valid email address.'
			]
		];
	
	protected function validate (\gajus\vlad\Subject $subject) {
		$value = $subject->getValue();

		if (!is_scalar($value)) {
			throw new \gajus\vlad\exception\Invalid_Argument_Exception('Input is not a scalar value.');
		}

		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			return 'invalid_syntax';
		}
	}
}