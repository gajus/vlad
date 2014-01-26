<?php
namespace gajus\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Range extends \gajus\vlad\Validator {
	static protected
		$default_options = [
			'min_exclusive' => null,
			'min_inclusive' => null,
			'max_exclusive' => null,
			'max_inclusive' => null
		],
		$messages = [
			/*'invalid_type' => [
				'{vlad.subject.name} is not more than {vlad.validator.options.min_exclusive}.',
				'The input is not more than {vlad.validator.options.min_exclusive}.'
			],*/
			'min_exclusive' => [
				'{vlad.subject.name} is not more than {vlad.validator.options.min_exclusive}.',
				'The input is not more than {vlad.validator.options.min_exclusive}.'
			],
			'min_inclusive' => [
				'{vlad.subject.name} is not equal or more than {vlad.validator.options.min_inclusive}.',
				'The input is not equal or more than {vlad.validator.options.min_inclusive}'
			],
			'max_exclusive' => [
				'{vlad.subject.name} is not less than {vlad.validator.options.max_exclusive}.',
				'The input is not less than {vlad.validator.options.max_exclusive}.'
			],
			'max_inclusive' => [
				'{vlad.subject.name} is not equal or less than {vlad.validator.options.max_inclusive}.',
				'The input is not equal or less than {vlad.validator.options.max_inclusive}'
			]
		];

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();

		if (!isset($options['min_exclusive']) && !isset($options['min_inclusive']) && !isset($options['max_exclusive']) && !isset($options['max_inclusive'])) {
			throw new \InvalidArgumentException('Missing required parameter.');
		}

		if (isset($options['min_exclusive'], $options['min_inclusive'])) {
			throw new \InvalidArgumentException('Cannot use "min_exclusive" and "min_inclusive" options together.');
		}

		if (isset($options['max_exclusive'], $options['max_inclusive'])) {
			throw new \InvalidArgumentException('Cannot use "max_exclusive" and "max_inclusive" options together.');
		}

		$min = isset($options['min_exclusive']) ? $options['min_exclusive'] : null;

		if ($min === null) {
			$min = isset($options['min_inclusive']) ? $options['min_inclusive'] : null;
		}

		$max = isset($options['max_exclusive']) ? $options['max_exclusive'] : null;

		if ($max === null) {
			$max = isset($options['max_inclusive']) ? $options['max_inclusive'] : null;
		}

		if (isset($min) && !is_numeric($min)) {
			throw new \InvalidArgumentException('Minimum boundry option must be numeric.');
		}

		if (isset($max) && !is_numeric($max)) {
			throw new \InvalidArgumentException('Minimum boundry option must be numeric.');
		}

		if (isset($min, $max) && $min > $max) {
			throw new \InvalidArgumentException('Minimum bountry cannot be greater than the maximum boundry.');
		}
	}

	public function validate (\gajus\vlad\Subject $subject) {
		$value = $subject->getValue();

		$options = $this->getOptions();
		
		if (!is_numeric($value)) {
			throw new \InvalidArgumentException('Value is expected to be numeric. "' . gettype($value) . '" given instead.');
		}

		if (isset($options['min_exclusive'])) {
			if ($value <= $options['min_exclusive']) {
				return 'min_exclusive';
			}
		} else if (isset($options['max_exclusive'])) {
			if ($value >= $options['max_exclusive']) {
				return 'max_exclusive';
			}
		} else if (isset($options['min_inclusive'])) {
			if ($value < $options['min_inclusive']) {
				return 'min_inclusive';
			}
		} else if (isset($options['max_inclusive'])) {
			if ($value > $options['max_inclusive']) {
				return 'max_inclusive';
			}
		}
	}
}

