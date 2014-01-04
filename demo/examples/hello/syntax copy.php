<?php

die(var_dump( (int) 'BCD' ));
/*
$rules = [
	[
		['input_name1', 'input_name2', 'input_name3'],
		['not_empty', 'string']
	]
];

$test = $vlad->test([
	[
		[
			'input_name1',
			'input_name2'
		],
		[
			'not_empty',
			'string'
		]
	]
]);

// [input_name1, input_name2, input_name3, input_name4] => [rule1[, opional_rule1, opional_rule2 param1=val1]].
?>

<?php
// Sample input
$input = [
	'first_name' => 'Gajus',
	'email' => 'foo@bar.tld'
];

// Vlad is not a sanitization tool. There is rarely a case when you should sanitize user input during validation (see http://anuary.com/55/why-input-sanitization-is-evil and http://phpsecurity.readthedocs.org/en/latest/Input-Validation.html#never-attempt-to-fix-input).

$vlad = new \ay\vlad\Vlad($input);
$test = $vlad->test(['input_name1'], ['not_empty', 'is_string']); // soft, hard, break


if ($test) {
	$
}*/

// Empty input is considered null, '', "/^\s+$/" // exclude (see http://www.regular-expressions.info/shorthand.html)
// Not empty 0, 0.00, false, [], (object) []

/*

Contrary to most input validation implementations, Vlad is assigning input to rule chain, rather than rule chain to input, e.g.

Instead of:

input_name => [rule1, rule2, rule3]

You have a version of:

[rule1, rule2, rule3] => [input_name1, input_name2]

This might seem odd at first, but it does make a lot more sense in practise. Consider the two, eqv. examples:

input_name1 => [string, required, length]
input_name2 => [string, required, length]
input_name3 => [string, required, length]
input_name4 => [string, required, length]

Becomes

[input_name1, input_name2, input_name3, input_name4] => [rule1[, opional_rule1, opional_rule2 param1=val1]]. Optional rules are executed only if previous rules pass. Only the last subset of the rules can trigger an error.

The syntax itself, though, 

*/

$vlad = new \ay\vlad\Vlad();

$test = $vlad->test('
	required
	string
		first_name
		email
	email
		email
');

/*
	required <== rule #1
	string <== rule #2
		first_name <== input name
		email <== input name
	email <== rule #3
		email <== input name
		
The above test says:
	* 'first_name' and 'email' are required and must be a string.
	* If 'email' is not empty and it is a string, then check if it is a syntactically valid email address.

Test passed, therefore $test is empty array:

*/
?>
<pre class="var-dump">
<?php var_dump($test);?>
</pre>