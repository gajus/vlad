<?php
namespace ay\vlad\demo\examples;

// Defining custom validators requires to extend \ay\vlad\Validator. The custom Validator must be namespaced.

class My_Custom_Validator extends \ay\vlad\Validator {
	protected
		// If the Validator accepts any options, the placeholder for each option must be predefined.
		$options = [
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
	
	public function validate ($input) {
		if ($this->options['alt'] && $this->options['alt'] == $input) {
			return;
		}

		if ($input != 1) {
			// Failing a validator must return name of the error. This error name must exist in the $messages array.
			if ($this->options['alt']) {
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

$vlad = new \ay\vlad\Vlad();

$test = $vlad->test([
	[
		['foo', 'bar'],
		['ay\vlad\demo\examples\My_Custom_Validator']
	],
	[
		['baz'],
		[
			['ay\vlad\demo\examples\My_Custom_Validator', 'alt' => '2']
		]
	]
]);

$result = $test->assess(); // If no $input parameter provided, assess will use $_POST.
?>
<pre><code><?php var_dump($result->getFailed())?></code></pre>