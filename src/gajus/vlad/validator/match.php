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
		];
	
	static protected
		$messages = [
			'not_match' => [
				'{vlad.subject.name} does not match {vlad.validator.options.selector}.',
				'Does not match "{vlad.validator.options.selector}".'
			]
		];

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();

		if (!isset($options['selector'])) {
			throw new \InvalidArgumentException('"selector" option cannot be left undefined.');
		}
	}
	
	public function validate (\gajus\vlad\Subject $subject) {
		$options = $this->getOptions();

		$second_subject = $subject->getInput()->getSubject($options['selector']);

		if ($subject->getValue() !== $second_subject->getValue()) {
			return 'not_match';
		}
	}
}