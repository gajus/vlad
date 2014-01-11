<?php
namespace ay\vlad\demo\examples;

// Vlad comes with a number of pre-built validators:
//
// * email – ensure that input is syntactically valid email address.
// * equal – ensure that input value matches a provided value.
// * in – ensure that value is in a provided array.
// * length – ensure that value is a string and at least or/and at most certain length.
// * match – ensure that input matches another input.
// * not_empty – ensure that input is not empty.
// * range – ensure that value is less, greater or in a defined range.
// * regex – ensure that value matches the supplied pattern.
// * required – ensure that input is present.
// * string – ensure that input is present.
// 
// Request other validators by raising an issue https://github.com/gajus/vlad/issues.

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
	'grault1' => 'a very long value',

	'garply0' => 10,
	'garply1' => 100,

	'waldo0' => '123',
	'waldo1' => '123a'
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
			'string'
		]
	],
	[
		['qux0', 'qux1'],
		[
			'required'
		]
	],
	[
		['quux0', 'quux1'],
		[
			'not_empty'
		]
	],
	[
		['corge0', 'corge1'],
		[
			'email'
		]
	],
	[
		['grault0', 'grault1'],
		[
			['length', 'max' => 15]
		]
	],
	[
		['garply0', 'garply1'],
		[
			['range', 'max_inclusive' => 15]
		]
	],
	[
		['waldo0', 'waldo1'],
		[
			['regex', 'pattern' => '/^[0-9]*$/']
		]
	]
]);

$result = $test->assess($input);
?>
<pre><code><?php var_dump($result->getFailed())?></code></pre>