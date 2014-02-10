<?php
namespace Gajus\Vlad\Validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Match extends \Gajus\Vlad\Validator {
	static protected
		$default_options = [
			'selector' => null
		],
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
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"selector" option cannot be left undefined.');
		}
	}
	
	protected function validate (\Gajus\Vlad\Subject $subject) {
		$options = $this->getOptions();

		$second_subject = $subject->getInput()->getSubject($options['selector']);

		if ($subject->getValue() !== $second_subject->getValue()) {
			return 'not_match';
		}
	}
}