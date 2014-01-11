<?php
namespace ay\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class In extends \ay\vlad\Validator {
	protected
		$default_options = [
			'haystack' => null
		],
		$messages = [
			'not_in' => [
				'{vlad.subject.name} is not found in the haystack.',
				'The input is not found in the haystack.'
			]
		];

	public function validate (\ay\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			throw new \Exception('Validator cannot be used with undefined input.');
		}

		$value = $subject->getValue();

		$options = $this->getOptions();
		
		if (!is_scalar($value)) {
			throw new \InvalidArgumentException('Value type is expected to be scalar. "' . gettype($value) . '" given instead.');
		}

		if (!isset($options['haystack'])) {
			throw new \BadMethodCallException('"haystack" option is.');
		}

		if (!in_array($value, $options['haystack'])) {
			return 'not_in';
		}
	}
}

