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
		
		$test = [];
		$parsed_test = [];
		
		foreach ($test_script as $i => $ts) {
			$offset = mb_strrpos($ts, "\t");
			$offset = $offset === false ? 0 : $offset + 1;
			
			if ($offset === $indentation_offset) {
				$rule_line = explode(' ', trim($ts), 2);
				
				$rule = [
					'name' => $rule_line[0],
					'options' => []
				];
				
				if (isset($rule_line[1])) {
					$rule['options'] = $this->parseOptions($rule_line[1]);
				}
				
				$test['rule'][] = $rule;
			} else if ($offset === $indentation_offset + 1) {
				if (!isset($test['input'])) {
					$test['input'] = [];
				}
				
				$input_line = explode(' ', trim($ts), 2);
				
				$input = [
					'selector' => $input_line[0],
					'options' => []
				];
				
				if (isset($input_line[1])) {
					$input['options'] = $this->parseAttributes($input_line[1]);
				}
				
				$test['input'][] = $input;
			} else {
				throw new \InvalidArgumentException('Invalid rule format.');
			}
			
			if ($offset !== $indentation_offset) {
				$next_ts_offset = null;
				
				if (isset($test_script[$i + 1])) {
					$next_ts_offset = mb_strrpos($test_script[$i + 1], "\t");
					$next_ts_offset = $next_ts_offset === false ? 0 : $next_ts_offset + 1;
				}
				
				if ($next_ts_offset === $indentation_offset || !isset($test_script[$i + 1])) {
					$parsed_test[] = $test;
					
					$test = [];
					
				}
			}
		}
		
		return $parsed_test;
	}
	
	public function test ($test_script) {
		$failed_test_script = [];
	
		$test_script = $this->parseTest($test_script);
		
		foreach ($test_script as $test) {
			$failed_test = [];
			
			foreach ($test['rule'] as $rule) {
				$rule_class_name = $rule['name'];
				
				if (strpos($rule['name'], '/') === false) {
					$rule_class_name = 'ay\vlad\rule\\' . $rule['name'];
				}
				
				if (!class_exists($rule_class_name)) {
					throw new \Exception('Rule cannot be found.');
				} else if (!is_subclass_of($rule_class_name, 'ay\vlad\Rule')) {
					throw new \Exception('Rule must extend ay\vlad\Rule.');
				}
				
				foreach ($test['input'] as $input) {
					if (isset($failed_test_script[$input['selector']]) || isset($failed_test[$input['selector']])) {
						continue;
					}
				
					$path = $this->getPath($input['selector']);
					$value = $this->getValue($path);
					
					$rule_instance = new $rule_class_name( $value );
					
					if (!$rule_instance->isValid()) {
						$failed_test[$input['selector']] = [
							'name' => $input['selector'],
							'value' => $value,
							'rule' => $rule,
							'message' => $rule_instance->getMessage()
						];
					}
				}
			}
			
			// Before merging test results with the test script results, remove input that did not pass "mute" rules.
			foreach ($failed_test as $input_name => $result) {
				if (!array_key_exists('mute', $result['rule']['options'])) {
					$failed_test_script[$input_name] = $result;
				}
			}
		}
		
		return array_values($failed_test_script);
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
	
	/**
	 * @author https://gist.github.com/rodneyrehm/3070128
	 */
	private function parseOptions ($text) {
		$options = [];
		$pattern = '#(?(DEFINE)
				(?<name>[a-zA-Z][\.a-zA-Z0-9-:]*)
				(?<value_double>"[^"]+")
				(?<value_single>\'[^\']+\')
				(?<value_none>[^\s>]+)
				(?<value>((?&value_double)|(?&value_single)|(?&value_none)))
			)
			(?<n>(?&name))(=(?<v>(?&value)))?#xs';
	 
		if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$options[$match['n']] = isset($match['v']) ? trim($match['v'], '\'"') : null;
			}
		}
		
		return $options;
	}
}