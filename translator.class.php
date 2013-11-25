<?php
namespace ay\vlad;

class Translator {
	public function test (array $test_output, array $dictionary = []) {
		foreach ($test_output as &$to) {
			if (isset($dictionary['custom'][$to['rule']['name'] . '.' . $to['message']['name'] . ' ' . $to['input']['name']])) {
				$to['message']['message'] = $dictionary['custom'][$to['rule']['name'] . '.' . $to['message']['name'] . ' ' . $to['input']['name']];
			} else if (isset($dictionary['translated'][$to['rule']['name'] . '.' . $to['message']['name']])) {
				$to['message']['message'] = $dictionary['translated'][$to['rule']['name'] . '.' . $to['message']['name']];
			}
			
			if (isset($dictionary['name'][$to['input']['name']])) {
				$to['input']['name'] = 'Test'; # $dictionary['name'][$to['input']['name']];
			}
			
			$to['message']['message'] = $this->replacePlaceholders($to);
			
			unset($to);
		}
		
		return $test_output;
	}
	
	final protected function replacePlaceholders ($to) {
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
		
		// In case this would evolvo and require more than 3 levels, then preg_replace_callback should be used instead.
		
		return str_replace(array_keys($placeholders), array_values($placeholders), $message);
	}
}