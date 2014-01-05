<?php
namespace ay\vlad;

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
	 * @param array $script Test rules defined in a format [ [ ['selector1', 'selector2'], ['rule1', 'rule2', 'rule3'] ] ].
	 * The first array indicates a script containing batches of selector and rule arrays. For every selector, each rule
	 * from withint the batch is applied. Rule array accepts names of the classes.
	 *
	 * You can change the rule processing type (see \ay\vlad\Ad::Rule) by injecting either of the valid type properties
	 * followed by a collomun into the rules array, e.g. ['soft:', 'rule1', 'hard:', 'rule2', 'rule3', 'break:', 'rule4'].
	 *
	 * You can pass properties to the rules by assigning an array, e.g. ['rule1', 'rule2' => ['min' => 10, 'max' => 20]].
	 */
	public function test (array $script) {
		$test = new Test($this->translator);

		foreach ($script as $batch) {
			if ($batch[0] != array_unique($batch[0])) {
				throw new \BadMethodCallException('Rule selectors must be unique.');
			}

			foreach ($batch[0] as $selector) {
				$processing_type = 'hard';

				foreach ($batch[1] as $context1 => $context2) {
					if (is_int($context1)) {
						$rule_name = $context2;
						$options = [];
					} else {
						$rule_name = $context1;
						$options = $context2;
					}

					if (!is_string($rule_name)) {
						// @todo Allow passing instance of the rule.
						throw new \Exception('Rule must be a string.');
					}

					if (in_array($rule_name, ['soft:', 'hard:', 'break:'])) {
						$processing_type = substr($rule_name, 0, -1);

						continue;
					}

					if (strpos($rule_name, '\\') === false) {
						$rule_name = 'ay\vlad\rule\\' . $rule_name;
					}
					
					if (!class_exists($rule_name)) {
						throw new \Exception('Rule cannot be found.');
					} else if (!is_subclass_of($rule_name, 'ay\vlad\Rule')) {
						throw new \Exception('Rule must extend ay\vlad\Rule.');
					}

					$test->addRule($selector, new $rule_name($options), $processing_type);
				}
			}
		}

		return $test;
	}
}