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
	
	private function parseTest ($test_script) {
		// Remove empty lines.
		$test_script = array_values(array_filter(explode(PHP_EOL, $test_script), function ($e) {
			return trim($e);
		}));
		
		if (empty($test_script)) {
			throw new \InvalidArgumentException('Test script has no rules.');
		}
		
		// Number of tabs in the first non-empty line set the indentation_offset.
		// It is assumed that tab does not occur in the line beyond the initial indentation.
		$indentation_offset = mb_strrpos($test_script[0], "\t");
		$indentation_offset = $indentation_offset === false ? 0 : $indentation_offset + 1;
		
		$parsed_test = [];
		
		foreach ($test_script as $ts) {
			$offset = mb_strrpos($ts, "\t");
			$offset = $offset === false ? 0 : $offset + 1;
			
			ay($offset);
			
			
			
			if ($tl_offset === $indentation_offset) {
				$rule = [
					'rule' => [
						'name' => trim($tl)
					]
				];		
			} else if ($tl_offset === $indentation_offset + 1) {
				if (!isset($rule['input'])) {
					$rule['input'] = [];
				}
				
				$input = [
					'selector' => trim($tl)
				];
				
				
				
				$rule['input'][] = $input;
			} else {
				throw new \InvalidArgumentException('Invalid rule format.');
			}
			
			if ($tl_offset !== $indentation_offset) {
				$next_offset = null;
				
				if (isset($test[$i + 1])) {
					$next_offset = mb_strrpos($test[$i + 1], "\t");
		
					$next_offset = $next_offset === false ? 0 : $next_offset + 1;
				}
				
				if ($next_offset === $offset || !isset($test[$i + 1])) {
					if (isset($rule['rule']['name'], $rule['input'])) {
						$parsed_test[] = $rule;
					} else {
						throw new \InvalidArgumentException('Rule without input selector.');
					}
				}
			}
		}
		
		return $parsed_test;
	}
	
	public function test ($test_str) {
		$failed = [];
	
		$test = $this->parseTest($test_str);
		
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
				
				$rule_instance = new $rule_name( $value );
				
				if (!$rule_instance->isValid()) {
					$failed[$input['selector']] = [
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