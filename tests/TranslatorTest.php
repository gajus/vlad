<?php
class TranslatorTest extends PHPUnit_Framework_TestCase {
	/**
	 * @dataProvider populateDictionaryWithValidDictionaryProvider
	 */
	public function testPopulateDictionaryWithValidDictionary ($input_dictionary) {
		$translator = new \Gajus\Vlad\Translator($input_dictionary);

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
						'Gajus\Vlad\Validator\Email' => [
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
						'Gajus\Vlad\Validator\Email invalid_syntax vladfoo' => 'Oops. Email address does not seem to be valid.'
					]
				]
			],
			[
				[
					'selector' => [
						'foo' => 'Foo!'
					],
					'validator_error' => [
						'Gajus\Vlad\Validator\Email' => [
							'invalid_syntax' => [
								'{vlad.subject.name} must be a valid email address.',
								'The input must be a valid email address.'
							]
						]
					],
					'validator_error_selector' => [
						'Gajus\Vlad\Validator\Email invalid_syntax vladfoo' => 'Oops. Email address does not seem to be valid.'
					]
				]
			],
		];
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "selector" translation must be a string.
	 */
	public function testSelectorNotStringMessage () {
		new \Gajus\Vlad\Translator(['selector' => ['foo' => ['bar']]]);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "validator_error_selector" translation query must break into exactly 3 parts (validator, error, selector).
	 */
	public function testValidatorSelectorErrorInvalidQuery () {
		new \Gajus\Vlad\Translator(['validator_error_selector' => ['Gajus\Vlad\Validator\NotEmpty missing_selector_name' => 'bar']]);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Validator in the "validator_error_selector" dictionary does not exist.
	 */
	public function testValidatorSelectorErrorNotExistingValidatorInQuery () {
		new \Gajus\Vlad\Translator(['validator_error_selector' => ['Gajus\Vlad\Validator\NotExistingValidator invalid_syntax test' => 'bar']]);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Error in the "validator_error_selector" translation does not refer to a known error.
	 */
	public function testValidatorSelectorErrorNotExistingErrorInQuery () {
		new \Gajus\Vlad\Translator(['validator_error_selector' => ['Gajus\Vlad\Validator\NotEmpty not_existing_error_name test' => 'bar']]);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "validator_error_selector" error translation must be a string.
	 */
	public function testValidatorSelectorErrorNotStringTranslation () {
		new \Gajus\Vlad\Translator(['validator_error_selector' => ['Gajus\Vlad\Validator\NotEmpty empty test' => ['bar']]]);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Validator in the "validator_error" dictionary does not exist.
	 */
	public function testValidatorErrorValidatorNotFound () {
		new \Gajus\Vlad\Translator([
				'validator_error' => [
					'Gajus\Vlad\Validator\NotExistingValidator' => [
						'empty' => ['a', 'b']
					]
				]
			]
		);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "validator_error" entry must include an array of validators, containing an array of errors, containing an array of messages.
	 */
	public function testValidatorErrorStringError () {
		new \Gajus\Vlad\Translator(['validator_error' => ['Gajus\Vlad\Validator\NotEmpty' => '???']]);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Error in the "validator_error" translation does not refer to a known error.
	 */
	public function testValidatorErrorErrorNotFound () {
		new \Gajus\Vlad\Translator([
				'validator_error' => [
					'Gajus\Vlad\Validator\NotEmpty' => [
						'not_existing_validator' => ['a', 'b']
					]
				]
			]
		);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "validator_error" message must be an array containing two messages.
	 */
	public function testValidatorErrorNotArrayTranslation () {
		new \Gajus\Vlad\Translator([
				'validator_error' => [
					'Gajus\Vlad\Validator\NotEmpty' => [
						'empty' => 'ab'
					]
				]
			]
		);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage "validator_error" message array must contain two messages.
	 */
	public function testValidatorErrorSuperfluousArrayTranslation () {
		new \Gajus\Vlad\Translator([
				'validator_error' => [
					'Gajus\Vlad\Validator\NotEmpty' => [
						'empty' => ['a', 'b', 'c']
					]
				]
			]
		);
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Individual "validator_error" messages must be a string.
	 */
	public function testStringValidatorErrorTranslation () {
		new \Gajus\Vlad\Translator([
				'validator_error' => [
					'Gajus\Vlad\Validator\NotEmpty' => [
						'empty' => [null, null]
					]
				]
			]
		);
	}

	public function testGetSelectorTranslation () {
		$translator = new \Gajus\Vlad\Translator(['selector' => ['foo' => 'Foo!']]);
		$selector = new \Gajus\Vlad\Selector('foo');
		
		$this->assertSame('Foo!', $translator->getSelectorName($selector));
	}

	public function testGetErrorMessageWithSelector () {
		$translator = new \Gajus\Vlad\Translator([
			'validator_error' => [
				'Gajus\Vlad\Validator\Email' => [
					'invalid_syntax' => [
						'{vlad.subject.name} must be a valid email address.',
						'The input must be a valid email address.'
					]
				]
			]
		]);

		$test = new \Gajus\Vlad\Test($translator);
		$test->assert('foo', 'Email');

		$assessment = $test->assess(['foo' => 'invalid_email']);

		#var_dump($assessment[0]->getValidator()); exit;

		$this->assertSame(['Foo must be a valid email address.', 'The input must be a valid email address.'], $assessment[0]->getMessage());
	}

	/**
	 * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
	 * @expectedExceptionMessage Unknown variable in error message.
	 */
	public function testUnknownVariableInErrorMessage () {
		$translator = new \Gajus\Vlad\Translator([
			'validator_error' => [
				'Gajus\Vlad\Validator\Email' => [
					'invalid_syntax' => [
						'{vlad.subject.unknown_variable} must be a valid email address.',
						'The input must be a valid email address.'
					]
				]
			]
		]);

		$test = new \Gajus\Vlad\Test($translator);
		$test->assert('foo', 'Email');

		$assessment = $test->assess(['foo' => 'invalid_email']);


	}
}