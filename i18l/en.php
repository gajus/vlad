<?php
/**
 * This file is generated using ./bin/build.php.
 */

return [
  'validator_error' => 
  [
    'gajus\\vlad\\validator\\email' => 
    [
      'invalid_syntax' => 
      [
          '{vlad.subject.name} is not a valid email address.',
          'The input is not a valid email address.',
      ],
    ],
    'gajus\\vlad\\validator\\equal' => 
    [
      'not_equal' => 
      [
          '{vlad.subject.name} is not a equal to "{vlad.validator.options.to}".',
          'The input is not a equal to "{vlad.validator.options.to}".',
      ],
    ],
    'gajus\\vlad\\validator\\in' => 
    [
      'not_in' => 
      [
          '{vlad.subject.name} is not found in the haystack.',
          'The input is not found in the haystack.',
      ],
    ],
    'gajus\\vlad\\validator\\length' => 
    [
      'min' => 
      [
          '{vlad.subject.name} must be at least {vlad.validator.options.min} characters long.',
          'The input must be at least {vlad.validator.options.min} characters long.',
      ],
      'max' => 
      [
          '{vlad.subject.name} must be at most {vlad.validator.options.max} characters long.',
          'The input must be at most {vlad.validator.options.max} characters long.',
      ],
      'between' => 
      [
          '{vlad.subject.name} must be between {vlad.validator.options.min} and {vlad.validator.options.max} characters long.',
          'The input must be between {vlad.validator.options.min} and {vlad.validator.options.max} characters long.',
      ],
    ],
    'gajus\\vlad\\validator\\match' => 
    [
      'not_match' => 
      [
          '{vlad.subject.name} does not match {vlad.validator.options.selector}.',
          'Does not match "{vlad.validator.options.selector}".',
      ],
    ],
    'gajus\\vlad\\validator\\not_empty' => 
    [
      'empty' => 
      [
          '{vlad.subject.name} is empty.',
          'The input is empty.',
      ],
    ],
    'gajus\\vlad\\validator\\range' => 
    [
      'min_exclusive' => 
      [
          '{vlad.subject.name} is not more than {vlad.validator.options.min_exclusive}.',
          'The input is not more than {vlad.validator.options.min_exclusive}.',
      ],
      'min_inclusive' => 
      [
          '{vlad.subject.name} is not equal or more than {vlad.validator.options.min_inclusive}.',
          'The input is not equal or more than {vlad.validator.options.min_inclusive}',
      ],
      'max_exclusive' => 
      [
          '{vlad.subject.name} is not less than {vlad.validator.options.max_exclusive}.',
          'The input is not less than {vlad.validator.options.max_exclusive}.',
      ],
      'max_inclusive' => 
      [
          '{vlad.subject.name} is not equal or less than {vlad.validator.options.max_inclusive}.',
          'The input is not equal or less than {vlad.validator.options.max_inclusive}',
      ],
    ],
    'gajus\\vlad\\validator\\regex' => 
    [
      'no_match' => 
      [
          '{vlad.subject.name} does not match against pattern "{vlad.validator.options.pattern}".',
          'The input does not match against pattern "{vlad.validator.options.pattern}".',
      ],
    ],
    'gajus\\vlad\\validator\\string' => 
    [
      'not_string' => 
      [
          '{vlad.subject.name} is not a string.',
          'The input is not a string.',
      ],
    ],
    'gajus\\vlad\\validator\\credit_card\\pan' => 
    [
      'not_decimal' => 
      [
          '{vlad.subject.name} must constain only digits.',
          'The input must constain only digits.',
      ],
      'invalid_checksum' => 
      [
          '{vlad.subject.name} is not a valid credit card number.',
          'The input is not a valid credit card number.',
      ],
    ],
  ],
];