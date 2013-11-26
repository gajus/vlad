<?php
namespace ay\vlad\demo\examples;

class My_Custom_Rule extends \ay\vlad\Rule {
	protected
		$messages = [
			'custom_error_name' => 'Custom error message {vlad.input.options.name}.'
		];
	
	protected function validate () {
		if ($this->value != 1) {
			$this->error_name = 'custom_error_name';
			
		}
	}
}

$input = [
	'foo' => 1,
	'bar' => 0,
	'baz' => 1
];

$vlad = new \ay\vlad\Vlad($input);

$test = $vlad->test('
	ay\vlad\demo\examples\My_Custom_Rule
		foo
		bar
		baz
');

/*

Custom rule must have a namespace, validate method and $messages.

*/
?>
<ul>
<pre class="var-dump">
<?php var_dump($test);?>
</pre>