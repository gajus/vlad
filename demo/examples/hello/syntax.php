<?php

$test_input = ['input_name1' => 'foo', 'input_name2' => 'bar'];

//Vlad
//	Test
//		Task
//			Result

$translator = new \ay\vlad\Translator();

$vlad = new \ay\vlad\Vlad($translator);

$test = $vlad->test([
	[
		['input_name1', 'input_name2', 'input_name3'],
		['email']
	]
]);

ay($test);

$result = $test->input($test_input);

$result->getFailed();



/*
// Sample input
$input = [
	'first_name' => 'Gajus',
	'email' => 'foo@bar.tld'
];

// Vlad is not a sanitization tool. There is rarely a case when you should sanitize user input during validation (see http://anuary.com/55/why-input-sanitization-is-evil and http://phpsecurity.readthedocs.org/en/latest/Input-Validation.html#never-attempt-to-fix-input).

$vlad = new \ay\vlad\Vlad($input);
$test = $vlad->test(['input_name1'], ['not_empty', 'is_string']); // soft, hard, break


Contrary to most input validation implementations, Vlad is assigning input to rule chain, rather than rule chain to input, e.g.

Instead of:

input_name => [rule1, rule2, rule3]

You have a version of:

[rule1, rule2, rule3] => [input_name1, input_name2]
?>
<pre class="var-dump">
<?php var_dump($test);?>
</pre>
*/