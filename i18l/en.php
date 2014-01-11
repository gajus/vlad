<?php
/**
 * This file is used primarily to set an example for other translations.
 * This file will be kept up to date with all of the in-built Vlad validators.
 */
return [
	'validator_error' => [
		'ay\vlad\validator\email' => [
			'invalid_syntax' => [
				'{vlad.subject.name} is not a valid email address.',
				'The input is not a valid email address.'
			]
		],
		'ay\vlad\validator\equal' => [
			'not_equal' => [
				'{vlad.subject.name} is not a equal to "{vlad.validator.options.to}".',
				'The input is not a equal to "{vlad.validator.options.to}".'
			]
		],
		'ay\vlad\validator\in' => [
			'not_in' => [
				'{vlad.subject.name} is not found in the haystack.',
				'The input is not found in the haystack.'
			]
		],
		'ay\vlad\validator\length' => [
			'min' => [
				'{vlad.subject.name} must be at least {vlad.validator.options.min} characters long.',
				'The input must be at least {vlad.validator.options.min} characters long.'
			],
			'max' => [
				'{vlad.subject.name} must be at most {vlad.validator.options.max} characters long.',
				'The input must be at most {vlad.validator.options.max} characters long.'
			],
			'between' => [
				'{vlad.subject.name} must be between {vlad.validator.options.min} and {vlad.validator.options.max} characters long.',
				'The input must be between {vlad.validator.options.min} and {vlad.validator.options.max} characters long.'
			]
		],
		'ay\vlad\validator\match' => [
			'not_match' => [
				'{vlad.subject.name} does not match {vlad.validator.options.selector}.',
				'Does not match "{vlad.validator.options.selector}".'
			]
		],
		'ay\vlad\validator\not_empty' => [
			'is_empty' => [
				'{vlad.subject.name} is empty.',
				'The input is empty.'
			]
		],
		'ay\vlad\validator\range' => [
			'min_exclusive' => [
				'{vlad.subject.name} is not more than {vlad.validator.options.min_exclusive}.',
				'The input is not more than {vlad.validator.options.min_exclusive}.'
			],
			'min_inclusive' => [
				'{vlad.subject.name} is not equal or more than {vlad.validator.options.min_inclusive}.',
				'The input is not equal or more than {vlad.validator.options.min_inclusive}'
			],
			'max_exclusive' => [
				'{vlad.subject.name} is not less than {vlad.validator.options.max_exclusive}.',
				'The input is not less than {vlad.validator.options.max_exclusive}.'
			],
			'max_inclusive' => [
				'{vlad.subject.name} is not equal or less than {vlad.validator.options.max_inclusive}.',
				'The input is not equal or less than {vlad.validator.options.max_inclusive}'
			]
		],
		'ay\vlad\validator\regex' => [
			'no_match' => [
				'{vlad.subject.name} does not match against pattern "{vlad.validator.options.pattern}".',
				'The input does not match against pattern "{vlad.validator.options.pattern}".'
			]
		]
		'ay\vlad\validator\required' => [
			'not_present' => [
				'{vlad.subject.name} is not present.',
				'The input is not present.'
			]
		],
		'ay\vlad\validator\string' => [
			'not_string' => [
				'{vlad.subject.name} is not a string.',
				'The input is not a string.'
			]
		]
	]
];