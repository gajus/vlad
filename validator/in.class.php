<?php
namespace ay\vlad\validator;

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

