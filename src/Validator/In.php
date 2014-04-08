<?php
namespace Gajus\Vlad\Validator;

/**
 * Validate that input value is in the haystack.
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class In extends \Gajus\Vlad\Validator {
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
			#'recursive' => false,
			#'inverse' => false
		],
		$message = '{input.name} is not found in the haystack.';

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();
		
		if (!isset($options['haystack'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"haystack" option is missing.');
		} else if (!is_array($options['haystack'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"haystack" option must be an array.');
		}

		if (!is_bool($options['strict']) || !is_bool($options['c14n'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Boolean property assigned non-boolean value.');
		}
	}

	public function assess ($value) {
		$options = $this->getOptions();
			
		/*if ($options['recursive']) {
			foreach ($subject->getSelector()->getPath() as $crumble) {
				if (!isset($options['haystack'][$crumble]) || !is_array($options['haystack'][$crumble])) {
					throw new \Gajus\Vlad\Exception\InvalidArgumentException('Selector path does not resolve an array within the haystack.');
				}

				$options['haystack'] = $options['haystack'][$crumble];
			}
		}

		if ($options['inverse']) {
			$options['haystack'] = array_flip($options['haystack']);
		}*/

		if ((is_string($value) || is_int($value)) && !array_filter($options['haystack'], 'is_array') && $options['strict'] && $options['c14n']) {
			$value = (string) $value;
			$options['haystack'] = array_map('strval', $options['haystack']);

			if (!in_array($value, $options['haystack'], true)) {
				return false;
			}
		} else if (!in_array($value, $options['haystack'], $options['strict'])) {
			return false;
		}

		return true;
	}
}