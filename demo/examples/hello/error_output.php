<?php
$input = [
	'email' => '#'
];

$vlad = new \ay\vlad\Vlad($input);

$test = $vlad->test('
	required
	string
	length min=2 max=5
		email
');
/*

	required
	string
	length min=2 max=5 <== options are passed using HTML-like syntax
	email <== This rule will not be reached, because the above has broken the chain. This rule would fail as well.
		email

The above test says:
	* 'email' is required, it must be a string, and must be between 2 and 5 characters long.

Length rule did not pass. test output contains at most one error per input (the first rule to break):

*/
?>
<pre class="var-dump">
<?php var_dump($test);?>
</pre>