<?php
namespace gajus\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Regex extends \gajus\vlad\Validator {
	protected
		$default_options = [
			'pattern' => null
		],
		$messages = [
			'no_match' => [
				'{vlad.subject.name} does not match against pattern "{vlad.validator.options.pattern}".',
				'The input does not match against pattern "{vlad.validator.options.pattern}".'
			]
		];

	public function validate (\gajus\vlad\Subject $subject) {
		$value = $subject->getValue();

		$options = $this->getOptions();
		
		if (!isset($options['pattern'])) {
			throw new \InvalidArgumentException('"pattern" property is required.');
		}

		$match = preg_match($options['pattern'], $value);

		if ($match === false) {
			throw new \InvalidArgumentException('Pattern "' . $options['pattern'] . '" failed (' . array_flip(get_defined_constants(true)['pcre'])[preg_last_error()] . ') against the supplied input "' . $value . '".');
		} else if ($match === 0) {
			return 'no_match';
		}
	}
}

