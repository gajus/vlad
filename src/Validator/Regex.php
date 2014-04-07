<?php
namespace Gajus\Vlad\Validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Regex extends \Gajus\Vlad\Validator {
	static protected
		$default_options = [
			'pattern' => null
		],
		$messages = [
			'no_match' => [
				'{vlad.subject.name} does not match against pattern "{vlad.validator.options.pattern}".',
				'The input does not match against pattern "{vlad.validator.options.pattern}".'
			]
		];

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();
		
		if (!isset($options['pattern'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"pattern" property is required.');
		}

		if (@preg_match($options['pattern'], 'test') === false) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Pattern "' . $options['pattern'] . '" failed (' . array_flip(get_defined_constants(true)['pcre'])[preg_last_error()] . ').');
		}
	}

	public function validate (\gajus\vlad\Subject $subject) {
		$value = $subject->getValue();

		$options = $this->getOptions();

		$match = preg_match($options['pattern'], $value);

		if ($match === 0) {
			return 'no_match';
		}
	}
}
