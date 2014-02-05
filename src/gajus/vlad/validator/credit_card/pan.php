<?php
namespace gajus\vlad\validator\credit_card;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Pan extends \gajus\vlad\Validator {
	static protected
		$messages = [
			'not_decimal' => [
				'{vlad.subject.name} must constain only digits.',
				'The input must constain only digits.'
			],
			'invalid_checksum' => [
				'{vlad.subject.name} is not a valid credit card number.',
				'The input is not a valid credit card number.'
			]
		];

	protected function validate (\gajus\vlad\Subject $subject) {
		$value = $subject->getValue();
		$options = $this->getOptions();

		if (preg_match('/[^0-9]/', $value)) {
			return 'not_decimal';
		}

		if (!$this->isValidChecksum($value)) {
			return 'invalid_checksum';
		}
	}

	/**
	 * @see http://en.wikipedia.org/wiki/Luhn_algorithm
	 * @param string $card_number The credit card number.
	 * @return boolean
	 */
	private function isValidChecksum ($card_number) {
		$card_number_checksum = '';
		
		foreach (str_split(strrev($card_number)) as $i => $d) {
			$card_number_checksum .= $i %2 !== 0 ? $d * 2 : $d;
		}
		
		return array_sum(str_split($card_number_checksum)) % 10 === 0;
	}
}