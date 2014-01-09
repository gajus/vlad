<?php
namespace ay\vlad\demo\examples;

// Vlad comes with a number of pre-built validators (and you can request new ones https://github.com/gajus/vlad/issues)

$input = [
	'foo0' => 'Predefined value',
	'foo1' => '',

	'bar0' => 'twin value',
	'bar1' => 'random value',
	'bar2' => 'twin value',

	'baz0' => 'fictional@email.address.tld',
	'baz1' => [],

	'qux0' => null,
	//'qux1' => null,

	'quux0' => 'non empty value',
	'quux1' => '',

	'corge0' => 'valid@email',
	'corge1' => 'invalidemail',

	'grault0' => 'short value',
	'grault1' => 'a very long value'
];

$vlad = new \ay\vlad\Vlad();

$test = $vlad->test([
	[
		// In all of the examples, the first selector is passing thi validation, and the second is failing.
		['foo0', 'foo1'],
		[
			// Value must be present and must be equal to the supplied value.
			['equal', 'to' => 'Predefined value']
		]
	],
	[
		['bar0', 'bar1'],
		[
			// Value must be present and must be equal to the value resolved using another selector.
			['match', 'selector' => 'bar2']
		]
	],
	[
		['baz0', 'baz1'],
		[
			// Value must be a string.
			'string'
		]
	],
	[
		['qux0', 'qux1'],
		[
			// Value must be present.
			'required'
		]
	],
	[
		['quux0', 'quux1'],
		[
			// Value cannot be empty.
			'not_empty'
		]
	],
	[
		['corge0', 'corge1'],
		[
			// Value must by syntactically valid email address.
			'email'
		]
	],
	[
		['grault0', 'grault1'],
		[
			// Value must be a string no longer than 15 characters.
			// Supported options: min, max.
			['length', 'max' => 15]
		]
	]
]);

$result = $test->assess($input);
?>
<pre><code><?php var_dump($result->getFailed())?></code></pre>