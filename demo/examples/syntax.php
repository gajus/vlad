<?php
$input = [
	'foo' => 'me@foo.tld',
	'bar' => 'invalidemail',
	'baz' => '',
	'location' => [
		'coordinates' => [
			'lat' => '54.687156',
			'lng' => '25.279651'
		]
	]
];

$vlad = new \gajus\vlad\Vlad();

$test = $vlad->test([
	[
		['foo', 'bar', 'baz'], // Selectors
		['not_empty', 'email'] // Validators
	],
	[
		['qux'],
		['required']
	],
	[
		['location[coordinates][lat]', 'location[coordinates][lng]'], // Selector can refer to multidimensional values.
		['not_empty']
	]
]);

// The above method creates an instance of a Test.
// Each selector (e.g. foo, bar, baz) is assigned all of the validators
// from the same group, e.g. selector 'foo' is assigned validators 'not_empty' and 'email'.

$result = $test->assess($input);
?>
<pre><code><?php var_dump($result->getFailed());?></code></pre>
?>
<?php
// Test instance can be reused with new input.
$result = $test->assess(['foo' => 'Oops.']);
?>
<pre><code><?php var_dump($result->getFailed());?></code></pre>