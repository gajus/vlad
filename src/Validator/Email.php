<?php
namespace Gajus\Vlad\Validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Email extends \Gajus\Vlad\Validator {
	static protected
		$messages = [
			'invalid_syntax' => [
				'{vlad.subject.name} is not a valid email address.',
				'The input is not a valid email address.'
			]
		];
	
	protected function validate (\Gajus\Vlad\Subject $subject) {
		$value = $subject->getValue();

		if (!is_scalar($value)) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Input is not a scalar value.');
		}

		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			return 'invalid_syntax';
		}
	}
}