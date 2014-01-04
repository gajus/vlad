<?php
namespace ay\vlad;

class Result {
	private
		$translator,
		$result = [];

	final public function __construct (Translator $translator) {
		$this->translator = $translator;
	}

	public function add ($selector, $value, \ay\vlad\Rule $rule) {
		
		$outcome = $rule->test($value);

		$this->result[] = [
			'input' => [
				'name' => $selector,
				'value' => $value,
				'options' => []
			],
			'rule' => $rule,
			'message' => 
		];
	}

	public function getFailed () {

	}

	public function getPassed () {

	}
}