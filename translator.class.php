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
		$final_dictionary = [];
		
		foreach (['translated', 'name', 'custom'] as $group) {
			$final_dictionary[$group] = isset($this->dictionary[$group]) ? $this->dictionary[$group] : [];
			
			if (isset($dictionary[$group])) {
				$final_dictionary[$group] = array_merge($final_dictionary[$group], $dictionary[$group]);
			}
		}
		
		foreach ($test_output as &$to) {
			if (isset($dictionary['custom'][$to['rule']['name'] . '.' . $to['message']['name'] . ' ' . $to['input']['name']])) {
				$to['message']['message'] = $final_dictionary['custom'][$to['rule']['name'] . '.' . $to['message']['name'] . ' ' . $to['input']['name']];
			} else if (isset($dictionary['translated'][$to['rule']['name'] . '.' . $to['message']['name']])) {
				$to['message']['message'] = $final_dictionary['translated'][$to['rule']['name'] . '.' . $to['message']['name']];
			}
			
			if (isset($final_dictionary['name'][$to['input']['name']])) {
				$to['input']['name'] = 'Test';
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
}