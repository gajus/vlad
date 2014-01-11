<?php
namespace gajus\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Match extends \gajus\vlad\Validator {
	protected
		$default_options = [
			'selector' => null
		],
		$messages = [
			'not_match' => [
				'{vlad.subject.name} does not match {vlad.validator.options.selector}.',
				'Does not match "{vlad.validator.options.selector}".'
			]
		];
	
	public function validate (\gajus\vlad\Subject $subject) {
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