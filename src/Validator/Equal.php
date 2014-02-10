<?php
namespace Gajus\Vlad\Validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Equal extends \Gajus\Vlad\Validator {
	static protected
		$default_options = [
			'to' => null
		],
		$messages = [
			'not_equal' => [
				'{vlad.subject.name} is not a equal to "{vlad.validator.options.to}".',
				'The input is not a equal to "{vlad.validator.options.to}".'
			]
		];

	public function __construct (array $options = []) {
		parent::__construct($options);

		if (!isset($options['to'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Missing required option.');
		}
	}
	
	protected function validate (\Gajus\Vlad\Subject $subject) {
		$options = $this->getOptions();

		$value = $subject->getValue();

		if ($options['to'] !== $value) {
			return 'not_equal';
		}
	}
}