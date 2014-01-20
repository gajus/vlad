<?php
namespace gajus\vlad\validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class In extends \gajus\vlad\Validator {
	static protected
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
			'c14n' => true,
			'recursive' => false
		],
		$messages = [
			'not_in' => [
				'{vlad.subject.name} is not found in the haystack.',
				'The input is not found in the haystack.'
			]
		];

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();
		
		if (!isset($options['haystack'])) {
			throw new \BadMethodCallException('"haystack" option is required.');
		} else if (!is_array($options['haystack'])) {
			throw new \InvalidArgumentException('"haystack" option must be an array.');
		}

		if (!is_bool($options['strict']) || !is_bool($options['c14n']) || !is_bool($options['recursive'])) {
			throw new \InvalidArgumentException('Boolean property assigned non-boolean value.');
		}
	}

	protected function validate (\gajus\vlad\Subject $subject) {
		$value = $subject->getValue();

		$options = $this->getOptions();
		
		if ($options['recursive']) {
			foreach ($subject->getSelector()->getPath() as $crumble) {
				if (!isset($options['haystack'][$crumble]) || !is_array($options['haystack'][$crumble])) {
					throw new \RuntimeException('Path does not resolve an array within the haystack.');
				}

				$options['haystack'] = $options['haystack'][$crumble];
			}
		}

		if (is_string($value) && !array_filter($options['haystack'], 'is_array') && $options['strict'] && $options['c14n']) {
			$options['haystack'] = array_map('strval', $options['haystack']);

			if (!in_array($value, $options['haystack'], true)) {
				return 'not_in';
			}
		} else if (!in_array($value, $options['haystack'], $options['strict'])) {
			return 'not_in';
		}
	}
}

