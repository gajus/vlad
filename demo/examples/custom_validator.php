<?php
namespace gajus\vlad\demo\examples;

// Defining custom validators requires to extend \gajus\vlad\Validator. The custom Validator must be namespaced.

class My_Custom_Validator extends \gajus\vlad\Validator {
	static protected
		// If the Validator accepts any options, the placeholder for each option must be predefined.
		$default_options = [
			'alt' => null
		],
		$messages = [
			'custom_error_name' => [
				'Input {vlad.subject.name} must be eq. to 1.',
				'The input must be eq. to 1.'
			],
			'custom_error_name_alt' => [
				'Input {vlad.subject.name} must be eq. to 1 or {vlad.validator.options.alt}.',
				'The input must be eq. to 1 or {vlad.validator.options.alt}.'
			]
		];
	
	public function validate (\gajus\vlad\Subject $subject) {
		$value = $subject->getValue();

		$options = $this->getOptions();

		if ($options['alt'] && $options['alt'] == $value) {
			return;
		}

		if ($value != 1) {
			// Failing a validator must return name of the error. This error name must exist in the $messages array.
			if ($options['alt']) {
				return 'custom_error_name_alt';
			}

			return 'custom_error_name';	
		}
	}
}

$input = [
	'foo' => 1,
	'bar' => 0,
	'baz' => 2
];

$vlad = new \gajus\vlad\Doctor();

$test = $vlad->test([
	[
		['foo', 'bar'],
		['gajus\vlad\demo\examples\My_Custom_Validator']
	],
	[
		['baz'],
		[
			'gajus\vlad\demo\examples\My_Custom_Validator' => ['alt' => '2']
		]
	]
]);

$assessment = $test->assess($input);
?>
<pre><code><?php var_dump($assessment)?></code></pre>