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
			'to' => null
		],
		$messages = [
			'not_match' => [
				'{vlad.subject.name} does not match {vlad.validator.options.to}.',
				'Does not match "{vlad.validator.options.to}".'
			]
		];
	
	public function validate (\gajus\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			throw new \Exception('Validator cannot be used with undefined input.');
		}

		$options = $this->getOptions();

		if (!isset($options['to'])) {
			throw new \Exception('"to" option cannot be left undefined.');
		}

		$second_subject = $subject->getInput()->getSubject($options['to']);

		#if (!$second_subject->isFound()) {
		#	throw new \Exception('"to" does not reference an existing input.');
		#}

		if ($subject->getValue() !== $second_subject->getValue()) {
			return 'not_match';
		}
	}
}