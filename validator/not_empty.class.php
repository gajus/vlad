<?php
namespace ay\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Not_Empty extends \ay\vlad\Validator {
	protected
		$messages = [
			'is_empty' => [
				'{vlad.subject.name} is empty.',
				'The input is empty.'
			]
		];
	
	public function validate (\ay\vlad\Subject $subject) {
		$value = $subject->getValue();

		if (!is_null($value) && !is_string($value) && !is_int($value) && !is_float($value) && !is_bool($value) && !is_array($value) && !is_object($value)) {
			throw new \InvalidArgumentException('Invalid type given. String, integer, float, boolean or array expected');
		}

		if (is_null($value) || !preg_replace('/^\s+$/', '', $value)) {
			return 'is_empty';
		}
	}
}