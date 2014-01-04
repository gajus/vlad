<?php
namespace ay\vlad;

class Result {
	private
		$translator,
		$result = [];

	final public function __construct (Translator $translator) {
		$this->translator = $translator;
	}

	public function addOutcome ($selector, $value, \ay\vlad\Rule $rule, $processing_type, array $error = null) {
		$rule_name = mb_strtolower(get_class($rule));

		$outcome = [
			'input' => [
				'selector' => $selector,
				'label' => $this->translator->getInputName($selector),
				'value' => $value
			],
			'rule' => [
				'name' => $rule_name,
				'options' => $rule->getOptions(),
				'processing_type' => $processing_type
			]
		];

		if ($error) {
			$this->translator->getRuleMessage($rule_name, $error['name'], $outcome);
		}

		$outcome['error'] = $error;

		$this->result[] = $outcome;
	}

	public function getFailed () {
		ay($this->result);
	}

	public function getPassed () {

	}

	public function getAll () {
		
	}
}