<?php

$test_input = ['input_name1' => 'foo', 'input_name2' => 'bar'];

//Vlad is a convenience wrapper for Test, used to build a Test from an array. Vlad carries a Translator instance that will be used for the derived tests.
//	Test is a collection of input selectors and Rules.
//		(?) Input carries input name/value/label
//		Rule is used to validate the input.
//			Result is produced by a Test for a given $input.
// Translator carries translations for Rules, Input labels, and specific Input Rules.

$vlad = new \ay\vlad\Vlad();

$test = $vlad->test([
	[
		['input_name1', 'input_name2', 'input_name3'],
		['soft:', 'email']
	]
]);

$result = $test->input($test_input);

ay( $result->getFailed() );



/*
// Vlad is not a sanitization tool. There is rarely a case when you should sanitize user input (see http://anuary.com/55/why-input-sanitization-is-evil and http://phpsecurity.readthedocs.org/en/latest/Input-Validation.html#never-attempt-to-fix-input).

$vlad = new \ay\vlad\Vlad($input);
$test = $vlad->test(['input_name1'], ['not_empty', 'is_string']);

?>
<pre class="var-dump">
<?php var_dump($test);?>
</pre>
*/