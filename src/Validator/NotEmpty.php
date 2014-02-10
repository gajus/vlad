<?php
namespace Gajus\Vlad\Validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class NotEmpty extends \Gajus\Vlad\Validator {
	static protected
		$requires_value = false,
		$default_options = [
			// Trim string values
			'trim' => true,
		],
		$messages = [
			'empty' => [
				'{vlad.subject.name} is empty.',
				'The input is empty.'
			]
		];

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();

		if (!is_bool($options['trim'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Boolean property assigned non-boolean value.');
		}
	}
	
	protected function validate (\Gajus\Vlad\Subject $subject) {
		$value = $subject->getValue();

		$options = $this->getOptions();

		if ($value === '0') {
			return;
		}

		if (empty($value) || $options['trim'] && is_string($value) && !strlen(trim($value))) {
			return 'empty';
		}
	}
}