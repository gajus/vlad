<?php
namespace gajus\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Length extends \gajus\vlad\Validator {
	protected
		$default_options = [
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

	public function validate (\gajus\vlad\Subject $subject) {
		if (!$subject->isFound()) {
			throw new \Exception('Validator cannot be used with undefined input.');
		}

		$value = $subject->getValue();

		$options = $this->getOptions();
		
		if (!is_string($value)) {
			throw new \InvalidArgumentException('Value is expected to be string. "' . gettype($value) . '" given instead.');
		}

		if (!isset($options['min']) && !isset($options['max'])) {
			throw new \BadMethodCallException('"min" and/or "max" option is required.');
		}
		
		if (isset($options['min']) && !is_numeric($options['min'])) {
			throw new \InvalidArgumentException('"min" option must be numeric.');
		}
		
		if (isset($options['max']) && !is_numeric($options['max'])) {
			throw new \InvalidArgumentException('"max" option must be numeric.');
		}
		
		if (isset($options['min'], $options['max']) && $options['min'] > $options['max']) {
			throw new \InvalidArgumentException('"min" option cannot be greater than "max".');
		}
		
		if (isset($options['min'], $options['max']) && (mb_strlen($value) < $options['min'] || mb_strlen($value) > $options['max'])) {
			return 'between';
		} else if (isset($options['min']) && mb_strlen($value) < $options['min']) {
			return 'min';
		} else if (isset($options['max']) && mb_strlen($value) > $options['max']) {
			return 'max';
		}
	}
}

