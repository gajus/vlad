<?php
namespace Gajus\Vlad\Validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class NotEmpty extends \Gajus\Vlad\Validator {
	static protected
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
	
	public function validate ($value) {
		$options = $this->getOptions();

		if (empty($value) || $options['trim'] && is_string($value) && !strlen(trim($value))) {
			return 'empty';
		}
	}
}