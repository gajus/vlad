<?php
namespace ay\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Required extends \ay\vlad\Validator {
	protected
		$messages = [
			'not_present' => [
				'{vlad.subject.name} is not present.',
				'The input is not present.'
			]
		];
	
	public function validate (\ay\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			return 'not_present';
		}
	}
}