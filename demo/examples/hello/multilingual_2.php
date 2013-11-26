<?php
namespace ay\vlad\demo\examples;

class Translator extends \ay\vlad\Translator {
	public function __construct () {
		$this->dictionary = [
			'translated' => [
				'required.is_null' => '{vlad.input.options.name} value cannot be left empty.'
			],
			'name' => [
				'baz' => 'Baz (previously known as Qux)'
			],
			'custom' => [
				'required.is_null bar' => 'Woah! You didn\'t think of leaving Bar value empty?'
			]
		];
	}
}

$translator = new \ay\vlad\demo\examples\Translator();

$vlad = new \ay\vlad\Vlad(null, $translator);

/**

When Translator instance is passed to the Vlad constructor, then all of the following tests will be affected.

*/

$test = $vlad->test('
	required
		foo
		bar
		baz
');
?>
<ul>
<?php foreach ($test as $t):?>
<li><?=$t['message']['message']?></li>
<?php endforeach;?>
</ul>