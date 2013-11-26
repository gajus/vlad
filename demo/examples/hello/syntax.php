<?php
// Sample input
$input = [
	'first_name' => 'Gajus',
	'email' => 'foo@bar.tld'
];

$vlad = new \ay\vlad\Vlad($input);

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