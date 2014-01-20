<?php
namespace gajus\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class In extends \gajus\vlad\Validator {
	protected
		$default_options = [
			'haystack' => null,
			'strict' => true,
			/**
			 * This option is relavent only with strict option true and input type string.
			 * Performers quasi-strict comparison: haystack members are casted to string to avoid 'abc' == 0 false/positive
			 * that would otherwise occur using non-strict comparison, but '123' input will match 123 haystact member.
			 *
			 * @param boolean
			 */
			'c14n' => true
		],
		$messages = [
			'not_in' => [
				'{vlad.subject.name} is not found in the haystack.',
				'The input is not found in the haystack.'
			]
		];

	public function validate (\gajus\vlad\Subject $subject) {
		$value = $subject->getValue();

		$options = $this->getOptions();
		
		if (!isset($options['haystack'])) {
			throw new \BadMethodCallException('"haystack" option is required.');
		} else if (!is_array($options['haystack'])) {
			throw new \InvalidArgumentException('"haystack" option must be an array.');
		}

		if (!is_bool($options['strict'])) {
			throw new \InvalidArgumentException('Invalid option "strict" type. Expecting boolean.');
		}

		#var_dump('###', $options);

		if (is_string($value) && $options['strict'] && $options['c14n']) {
			$haystack = array_map('strval', $options['haystack']);

			if (!in_array($value, $haystack, true)) {
				return 'not_in';
			}
		} else if (!in_array($value, $options['haystack'], $options['strict'])) {
			return 'not_in';
		}
	}
}

