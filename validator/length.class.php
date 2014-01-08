<?php
namespace ay\vlad\validator;

class Length extends \ay\vlad\Validator {
	protected
		$options = [
			'min' => null,
			'max' => null
		],
		$messages = [
			'min' => [
				'{vlad.subject.name} must be at least {vlad.validator.options.min} characters long.',
				'The input must be at least {vlad.validator.options.min} characters long.'
			],
			'max' => [
				'{vlad.subject.name} must be at most {vlad.validator.options.max} characters long.',
				'The input must be at most {vlad.validator.options.max} characters long.'
			],
			'between' => [
				'{vlad.subject.name} must be between {vlad.validator.options.min} and {vlad.validator.options.max} characters long.',
				'The input must be between {vlad.validator.options.min} and {vlad.validator.options.max} characters long.'
			],
		];

	public function validate (\ay\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			throw new \Exception('Validator cannot be used with undefined input.');
		}

		$value = $subject->getValue();

		if (!is_string($value)) {
			throw new \InvalidArgumentException('Value is expected to be string. "' . gettype($value) . '" given instead.');
		}

		if (!isset($this->options['min']) && !isset($this->options['max'])) {
			throw new \BadMethodCallException('"min" and/or "max" option is required.');
		}
		
		if (isset($this->options['min']) && !is_numeric($this->options['min'])) {
			throw new \InvalidArgumentException('"min" option must be numeric.');
		}
		
		if (isset($this->options['max']) && !is_numeric($this->options['max'])) {
			throw new \InvalidArgumentException('"max" option must be numeric.');
		}
		
		if (isset($this->options['min'], $this->options['max']) && $this->options['min'] > $this->options['max']) {
			throw new \InvalidArgumentException('"min" option cannot be greater than "max".');
		}
		
		if (isset($this->options['min'], $this->options['max']) && (mb_strlen($value) < $this->options['min'] || mb_strlen($value) > $this->options['max'])) {
			return 'between';
		} else if (isset($this->options['min']) && mb_strlen($value) < $this->options['min']) {
			return 'min';
		} else if (isset($this->options['max']) && mb_strlen($value) > $this->options['max']) {
			return 'max';
		}
	}
}

