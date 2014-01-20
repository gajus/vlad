<?php
namespace gajus\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Not_Empty extends \gajus\vlad\Validator {
	static protected
		$requires_value = false,
		$messages = [
			'empty' => [
				'{vlad.subject.name} is empty.',
				'The input is empty.'
			]
		];
	
	protected function validate (\gajus\vlad\Subject $subject) {
		$value = $subject->getValue();
		
		if (!is_null($value) && !is_scalar($value) && !is_array($value) && !is_object($value)) {
			throw new \InvalidArgumentException('Value is not null, string, integer, float, boolean or array.');
		}

		if (!preg_replace('/^\s+$/', '', $value)) {
			return 'empty';
		}
	}
}