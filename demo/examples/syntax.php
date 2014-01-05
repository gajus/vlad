<?php
$input = [
	'foo' => 'me@foo.tld',
	'bar' => 'invalidemail',
	'baz' => '',
];

$vlad = new \ay\vlad\Vlad();

$test = $vlad->test([
	[
		['foo', 'bar', 'baz'], // Selectors
		['not_empty', 'email'] // Rules
	],
	[
		['qux'],
		['required']
	]
]);

// The above method creates an instance of a Test.
// Each selector (e.g. foo, bar, baz) is assigned all of the rules
// from the same group, e.g. selector 'foo' is assigned rules 'not_empty' and 'email'.

$result = $test->assess($input);
?>
<pre><code><?php var_dump($result->getFailed());?></code></pre>