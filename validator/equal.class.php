<?php
namespace ay\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Equal extends \ay\vlad\Validator {
	protected
		$default_options = [
			'to' => null
		],
		$messages = [
			'not_equal' => [
				'{vlad.subject.name} is not a equal to "{vlad.validator.options.to}".',
				'The input is not a equal to "{vlad.validator.options.to}".'
			]
		];
	
	public function validate (\ay\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			throw new \Exception('Validator cannot be used with undefined input.');
		}

		// @todo Decide how to treat non-scallar values.

		$options = $this->getOptions();

		$value = $subject->getValue();

		if ($options['to'] !== $value) {
			return 'not_equal';
		}
	}
}