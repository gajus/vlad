<?php
// Leaving the first constructor parameter empty will assume $_POST input.
$vlad = new \ay\vlad\Vlad();

$test = $vlad->test('
	required
		foo
		bar
		baz
', [
	'translated' => [
		'required.is_null' => '{vlad.input.options.name} value cannot be left empty.'
	],
	'name' => [
		'baz' => 'Baz (previously known as Qux)'
	],
	'custom' => [
		'required.is_null bar' => 'Woah! You didn\'t think of leaving Bar value empty?'
	]
]);

/**

Use test() method second parameter to pass array of translations. Translation will apply only to this test.

	* translated – {rule_name}.{error_name} => Error message.
	* name – {input_name} => Overwrite derived input name.
	* custom – {rule_name}.{error_name} {input_name} => Custom error message for a specific rule, error and input combination.

*/
?>
<ul>
<?php foreach ($test as $t):?>
<li><?=$t['message']['message']?></li>
<?php endforeach;?>
</ul>