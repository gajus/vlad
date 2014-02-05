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
			],
			/*'unsupported_card' => [
				'{vlad.subject.name} is not a supported card type.',
				'The input is not a supported card type.'
			]*/
		];/*,
		$default_options = [
			'type' => ['visa', 'mastercard', 'amex', 'maestro']
		],*/
		/**
		 * @see Visa, MasterCard, American Express (http://www.regular-expressions.info/creditcard.html), Maestro (http://regexlib.com/REDetails.aspx?regexp_id=1626)
		 */
		/*$card_pattern = [
			'visa' => '/^4[0-9]{12}(?:[0-9]{3})?$/',
			'mastercard' => '/^5[1-5][0-9]{14}$/',
			'amex' => '/^3[47][0-9]{13}$/',
			'maestro' => '/
				(^(5[0678])\d{11,18}$) |
				(^(6[^0357])\d{11,18}$) |
				(^(601)[^1]\d{9,16}$) |
				(^(6011)\d{9,11}$) |
				(^(6011)\d{13,16}$) |
				(^(65)\d{11,13}$) |
				(^(65)\d{15,18}$) |
				(^(633)[^34](\d{9,16}$)) |
				(^(6333)[0-4](\d{8,10}$)) |
				(^(6333)[0-4](\d{12}$)) |
				(^(6333)[0-4](\d{15}$)) |
				(^(6333)[5-9](\d{8,10}$)) |
				(^(6333)[5-9](\d{12}$)) |
				(^(6333)[5-9](\d{15}$)) |
				(^(6334)[0-4](\d{8,10}$)) |
				(^(6334)[0-4](\d{12}$)) |
				(^(6334)[0-4](\d{15}$)) |
				(^(67)[^(59)](\d{9,16}$)) |
				(^(6759)](\d{9,11}$)) |
				(^(6759)](\d{13}$)) |
				(^(6759)](\d{16}$)) |
				(^(67)[^(67)](\d{9,16}$)) |
				(^(6767)](\d{9,11}$)) |
				(^(6767)](\d{13}$)) |
				(^(6767)](\d{16}$))
			/'
		];*/
	
	/*public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();

		if (empty($options['type'])) {
			throw new \InvalidArgumentException('Type property is empty.');
		} else if (!is_array($options['type'])) {
			throw new \InvalidArgumentException('Type property is not array.');
		} else if (array_diff($options['type'], self::$default_options['type'])) {
			throw new \InvalidArgumentException('Type property includes an unsupported card type.');
		}
	}*/

	protected function validate (\gajus\vlad\Subject $subject) {
		$value = $subject->getValue();
		$options = $this->getOptions();

		if (preg_match('/[^0-9]/', $value)) {
			return 'not_decimal';
		}

		if (!$this->isValidChecksum($value)) {
			return 'invalid_checksum';
		}

		/*$card_type = null;

		foreach (static::$card_pattern as $type => $pattern) {
			if (preg_match($pattern, $value)) {
				$card_type = $type;

				break;
			}
		}

		if (!$card_type || !in_array($card_type, $options['type'])) {
			return 'unsupported_card';
		}*/
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