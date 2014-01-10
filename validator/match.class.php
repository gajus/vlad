<?php
namespace ay\vlad\validator;

class Match extends \ay\vlad\Validator {
	protected
		$options = [
			'selector' => null
		],
		$messages = [
			'not_match' => [
				'{vlad.subject.name} does not match {vlad.validator.options.selector}.',
				'Does not match "{vlad.validator.options.selector}".'
			]
		];
	
	public function validate (\ay\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			throw new \Exception('Validator cannot be used with undefined input.');
		}

		$options = $this->getOptions();

		if (!isset($options['selector'])) {
			throw new \Exception('Selector option cannot be left undefined.');
		}

		$second_subject = $subject->getInput()->getSubject($options['selector']);

		if (!$second_subject->isFound()) {
			throw new \Exception('Selector does not reference an existing input.');
		}

		if ($subject->getValue() !== $second_subject->getValue()) {
			return 'not_match';
		}
	}
}