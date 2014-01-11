<?php
namespace ay\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Email extends \ay\vlad\Validator {
	protected
		$messages = [
			'invalid_syntax' => [
				'{vlad.subject.name} is not a valid email address.',
				'The input is not a valid email address.'
			]
		];
	
	public function validate (\ay\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			throw new \Exception('Validator cannot be used with undefined input.');
		}

		$value = $subject->getValue();

		if (!is_string($value)) {
			throw new \InvalidArgumentException('$input is expected to be string. "' . gettype($value) . '" given instead.');
		}

		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			return 'invalid_syntax';
		}
	}
}