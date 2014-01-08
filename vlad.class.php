<?php
namespace ay\vlad;

/**
 * Vlad is a convenience wrapper used to build Tests. Vlad instance carries a Translator instance that will be passed to
 * all of the derived Test cases.
 *
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Vlad {
	private
		$translator;

	/**
	 * Unless overwritten down the chain this Translator will be
	 * used to construct all the Tests.
	 *
	 * @param Translator $translator
	 */
	final public function __construct (Translator $translator = null) {
		$this->translator = $translator === null ? new Translator() : $translator;
	}
	
	/**
	 * Build a test suite.
	 *
	 * @param array $script Test validators defined in a format [ [ ['selector1', 'selector2'], ['validator1', 'validator2', 'validator3'] ] ].
	 * The first array indicates a script containing batches of selector and validator arrays. For every selector, each validator
	 * from withint the batch is applied. Validator array accepts names of the classes.
	 *
	 * You can change the validator processing type (see \ay\vlad\Test::Validator) by injecting either of the valid type properties
	 * followed by a collomun into the validators array, e.g. ['soft:', 'validator1', 'hard:', 'validator2', 'validator3', 'break:', 'validator4'].
	 *
	 * You can pass properties to the validators by assigning an array, e.g. ['validator1', 'validator2' => ['min' => 10, 'max' => 20]].
	 */
	public function test (array $script) {
		$test = new Test($this->translator);

		foreach ($script as $batch) {
			if ($batch[0] != array_unique($batch[0])) {
				throw new \InvalidArgumentException('Validator selectors must be unique.');
			}

			foreach ($batch[0] as $selector) {
				$failure_scenario = 'hard';

				foreach ($batch[1] as $context) {
					if (is_array($context)) {
						if (empty($context)) {
							throw new \InvalidArgumentException('Empty array in the validator chain.');
						}

						if (!isset($context[0])) {
							// This is options array, e.g. ['fail' => 'break']
							if (array_diff(array_keys($context), ['fail'])) {
								\ay($context);

								throw new \InvalidArgumentException('Unknown options in the validator chain: ' . implode(', ', $context) . '.');
							}

							$failure_scenario = $context['fail'];

							continue;
						} else {
							// This is a Validator with options.
							$validator_name = array_shift($context);
							$options = $context;
						}
					} else {
						$validator_name = $context;
						$options = [];
					}

					if (!is_string($validator_name)) {
						// @todo Allow passing instance of the validator.
						throw new \Exception('Validator must be a string.');
					}

					if (strpos($validator_name, '\\') === false) {
						$validator_name = 'ay\vlad\validator\\' . $validator_name;
					}
					
					if (!class_exists($validator_name)) {
						throw new \Exception('Validator cannot be found.');
					} else if (!is_subclass_of($validator_name, 'ay\vlad\Validator')) {
						throw new \Exception('Validator must extend ay\vlad\Validator.');
					}

					$test->addValidator($selector, new $validator_name($options), $failure_scenario);
				}
			}
		}

		return $test;
	}
}