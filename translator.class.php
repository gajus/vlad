<?php
namespace ay\vlad;

class Translator {
	protected
		$dictionary = [];
	
	public function __construct (array $dictionary = []) {
		$this->dictionary = $dictionary;
	}

	/**
	 * 
	 */
	final public function test (array $test_output, array $dictionary = []) {
		$this->validateDictionary($this->dictionary);
		$this->validateDictionary($dictionary);
		
		foreach (['translated', 'name', 'custom'] as $dictionary_name) {
			if (!isset($dictionary[$dictionary_name])) {
				$dictionary[$dictionary_name] = [];
			}
		
			$dictionary[$dictionary_name] = isset($this->dictionary[$dictionary_name]) ? array_merge($this->dictionary[$dictionary_name], $dictionary[$dictionary_name]) : $dictionary[$dictionary_name];
		}
		
		foreach ($test_output as &$to) {
			if (isset($dictionary['custom'][$to['rule']['name'] . '.' . $to['message']['name'] . ' ' . $to['input']['name']])) {
				$to['message']['message'] = $dictionary['custom'][$to['rule']['name'] . '.' . $to['message']['name'] . ' ' . $to['input']['name']];
			} else if (isset($dictionary['translated'][$to['rule']['name'] . '.' . $to['message']['name']])) {
				$to['message']['message'] = $dictionary['translated'][$to['rule']['name'] . '.' . $to['message']['name']];
			}
			
			if (isset($dictionary['name'][$to['input']['name']])) {
				$to['input']['options']['name'] = $dictionary['name'][$to['input']['name']];
			}
			
			$to['message']['message'] = $this->replacePlaceholders($to);
			
			unset($to);
		}
		
		return $test_output;
	}
	
	final private function replacePlaceholders ($to) {
		$message = $to['message']['message'];
		
		unset($to['message']['message']);
		
		$placeholders = [];
		
		foreach ($to as $k1 => $v1) {
			if (is_array($v1)) {
				foreach ($v1 as $k2 => $v2) {
					if (is_array($v2)) {
						foreach ($v2 as $k3 => $v3) {
							$placeholders['{vlad.' . $k1 . '.' . $k2 . '.' . $k3 . '}'] = $v3;							
						}
					} else {
						$placeholders['{vlad.' . $k1 . '.' . $k2 . '}'] = $v2;
					}
				}
			} else {
				$placeholders['{vlad.' . $k1 . '}'] = $v1;
			}
		}
		
		// In case there is a requirement for more than 3 levels, then use preg_replace_callback instead.
		
		return str_replace(array_keys($placeholders), array_values($placeholders), $message);
	}
	
	final private function validateDictionary (array $dictionary) {
		$unknown_properties = array_diff(array_keys($dictionary), ['translated', 'name', 'custom']);
		
		if ($unknown_properties) {
			throw new \InvalidArgumentException('Dictionary has unknown properties: "' . implode('", "', $unknown_properties) . '".');
		}
		
		if (isset($dictionary['translated'])) {
			foreach ($dictionary['translated'] as $name) {
				
			}
		}
		
		if (isset($dictionary['name'])) {
			foreach ($dictionary['name'] as $name) {
				
			}
		}
		
		if (isset($dictionary['custom'])) {
			foreach ($dictionary['custom'] as $name) {
				
			}
		}
	}
}