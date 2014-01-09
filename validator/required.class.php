<?php
namespace ay\vlad\validator;

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