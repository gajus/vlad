<?php
class TranslatorTest extends PHPUnit_Framework_TestCase {
	/**
	 * @dataProvider populateDictionaryWithValidDictionaryProvider
	 */
	public function testPopulateDictionaryWithValidDictionary ($input_dictionary) {
		$translator = new \gajus\vlad\Translator($input_dictionary);

		$dictionary = $translator->getDictionary();

		$this->assertSame($input_dictionary, $dictionary);
	}

	public function populateDictionaryWithValidDictionaryProvider () {
		return [
			[
				[
					'selector' => [
						'foo' => 'Foo!'
					]
				]
			],
			[
				[
					'validator_error' => [
						'gajus\vlad\validator\email' => [
							'invalid_syntax' => [
								'{vlad.subject.name} must be a valid email address.',
								'The input must be a valid email address.'
							]
						]
					]
				]
			],
			[
				[
					'validator_error_selector' => [
						'gajus\vlad\validator\email invalid_syntax vladfoo' => 'Oops. Email address does not seem to be valid.'
					]
				]
			],
			[
				[
					'selector' => [
						'foo' => 'Foo!'
					],
					'validator_error' => [
						'gajus\vlad\validator\email' => [
							'invalid_syntax' => [
								'{vlad.subject.name} must be a valid email address.',
								'The input must be a valid email address.'
							]
						]
					],
					'validator_error_selector' => [
						'gajus\vlad\validator\email invalid_syntax vladfoo' => 'Oops. Email address does not seem to be valid.'
					]
				]
			],
		];
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage "selector" translation must be a string.
	 */
	public function testSelectorNotStringMessage () {
		new \gajus\vlad\Translator(['selector' => ['foo' => ['bar']]]);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage "validator_error_selector" translation query must break into exactly 3 parts (validator, error, selector).
	 */
	public function testValidatorSelectorErrorInvalidQuery () {
		new \gajus\vlad\Translator(['validator_error_selector' => ['gajus\vlad\validator\not_empty missing_selector_name' => 'bar']]);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Validator in the "validator_error_selector" dictionary does not exist.
	 */
	public function testValidatorSelectorErrorNotExistingValidatorInQuery () {
		new \gajus\vlad\Translator(['validator_error_selector' => ['gajus\vlad\validator\not_existing_validator invalid_syntax test' => 'bar']]);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Error in the "validator_error_selector" translation does not refer to a known error.
	 */
	public function testValidatorSelectorErrorNotExistingErrorInQuery () {
		new \gajus\vlad\Translator(['validator_error_selector' => ['gajus\vlad\validator\not_empty not_existing_error_name test' => 'bar']]);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage "validator_error_selector" error translation must be a string.
	 */
	public function testValidatorSelectorErrorNotStringTranslation () {
		new \gajus\vlad\Translator(['validator_error_selector' => ['gajus\vlad\validator\not_empty empty test' => ['bar']]]);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Validator in the "validator_error" dictionary does not exist.
	 */
	public function testValidatorErrorValidatorNotFound () {
		new \gajus\vlad\Translator([
				'validator_error' => [
					'gajus\vlad\validator\not_existing_validator' => [
						'empty' => ['a', 'b']
					]
				]
			]
		);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage "validator_error" entry must include an array of validators, containing an array of errors, containing an array of messages.
	 */
	public function testValidatorErrorStringError () {
		new \gajus\vlad\Translator(['validator_error' => ['gajus\vlad\validator\not_empty' => '???']]);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Error in the "validator_error" translation does not refer to a known error.
	 */
	public function testValidatorErrorErrorNotFound () {
		new \gajus\vlad\Translator([
				'validator_error' => [
					'gajus\vlad\validator\not_empty' => [
						'not_existing_validator' => ['a', 'b']
					]
				]
			]
		);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage "validator_error" message must be an array containing two messages.
	 */
	public function testValidatorErrorNotArrayTranslation () {
		new \gajus\vlad\Translator([
				'validator_error' => [
					'gajus\vlad\validator\not_empty' => [
						'empty' => 'ab'
					]
				]
			]
		);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage "validator_error" message array must contain two messages.
	 */
	public function testValidatorErrorSuperfluousArrayTranslation () {
		new \gajus\vlad\Translator([
				'validator_error' => [
					'gajus\vlad\validator\not_empty' => [
						'empty' => ['a', 'b', 'c']
					]
				]
			]
		);
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Individual "validator_error" messages must be a string.
	 */
	public function testStringValidatorErrorTranslation () {
		new \gajus\vlad\Translator([
				'validator_error' => [
					'gajus\vlad\validator\not_empty' => [
						'empty' => [null, null]
					]
				]
			]
		);
	}	
}