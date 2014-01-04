<?php
namespace ay\vlad;

class Vlad {
	private
		$translator;

	final public function __construct (Translator $translator = null) {
		$this->translator = $translator === null ? new Translator(): $translator;
	}
	
	public function test (array $script) {
		$test = new Test($this->translator);

		foreach ($script as $batch) {
			if ($batch[0] != array_unique($batch[0])) {
				throw new \BadMethodCallException('Rule selectors must be unique.');
			}

			foreach ($batch[0] as $selector) {
				$processing_type = 'hard';

				foreach ($batch[1] as $rule_name) {
					// @todo $rule will be an array when options are passed.

					if (!is_string($rule_name)) {
						// @todo Allow passing instance of the rule.
						throw new \Exception('Rule must be a string.');
					}

					if (in_array($rule_name, ['soft:', 'hard:', 'break:'])) {
						$processing_type = substr($rule_name, 0, -1);

						continue;
					}

					$rule_class_name = $rule_name;
			
					if (strpos($rule_name, '\\') === false) {
						$rule_class_name = 'ay\vlad\rule\\' . $rule_name;
					}
					
					if (!class_exists($rule_class_name)) {
						throw new \Exception('Rule cannot be found.');
					} else if (!is_subclass_of($rule_class_name, 'ay\vlad\Rule')) {
						throw new \Exception('Rule must extend ay\vlad\Rule.');
					}

					$test->addRule($selector, new $rule_class_name, $processing_type);
				}
			}
		}

		return $test;
	}
}