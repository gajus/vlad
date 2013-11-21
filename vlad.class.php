<?php
namespace ay\vlad;

class Vlad {
	private
		$input;

	public function __construct (array $input = null) {
		if ($input === null) {
			$input = $_POST;
		}
	
		$this->input = $input;
	}
	
	private function parseTest () {
		$rule = [
			[
				'rule' => ['name' => 'is_eq_a'],
				'input' => [
					[
						'selector' => 'user[name]',
						'options' => [
							'scope' => 'group'
						]
					]
				]
			]
		];
		
		return $rule;
	}
	
	public function test () {
		$failed = [];
	
		$test = $this->parseTest();
		
		foreach ($test as $rule) {
			$rule_name = $rule['rule']['name'];
		
			if (strpos($rule['rule']['name'], '/') === false) {
				$rule_name = 'ay\vlad\rule\\' . $rule_name;
			}
			
			if (!class_exists($rule_name)) {
				throw new \Exception('Rule cannot be found.');
			} else if (!is_subclass_of($rule_name, 'ay\vlad\Rule')) {
				throw new \Exception('Rule must extend ay\vlad\Rule.');
			}
			
			foreach ($rule['input'] as $input) {
				if (isset($failed[$input['selector']])) {
					continue;
				}
			
				$path = $this->getPath($input['selector']);
				$value = $this->getValue($path);
				
				#$input = new Input($this->input, $input['selector']);
				#ay( $path, $value, $input->getValue(), $input->getSelector(), $input->getPath() );
				
				$rule_instance = new $rule_name( $value );
				
				if (!$rule_instance->isValid()) {
					$failed[$input['selector']] = [
						// @todo pattern matching 'selector' => $input['selector'],
						'name' => $input['selector'],
						'rule' => $rule['rule']['name'],
						'message' => $rule_instance->getMessage()
					];
				}
			}
		}
		
		return array_values($failed);
	}
	
	private function getPath ($selector) {
		return explode('[', str_replace(']', '', $selector));
	}
	
	public function getValue (array $path) {
		// @todo regex (use http_build_str to flatten data array and recursive array walk to get rid of the possibly long values)
		
		$value = $this->input;
		
		foreach ($path as $name) {
			if (array_key_exists($name, $value)) {
				$value = $value[$name];
			} else {
				$value = null;
				
				break;
			}
		}
		
		return $value;
	}
}