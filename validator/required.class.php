<?php
namespace ay\vlad\validator;

class Required extends \ay\vlad\Validator {
	protected
		$messages = [
			'no_match' => [
				'{vlad.subject.name} is required.',
				'The input is required.'
			]
		];
	
	public function validate (\ay\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			return 'no_match';
		}
	}
}