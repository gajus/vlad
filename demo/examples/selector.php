<?php
$input = [
	'device' => [
		'location' => [
			'coordinates' => [
				'lat' => '54.687156',
				'lng' => '25.279651'
			]
		]
	]
];

$vlad = new \ay\vlad\Vlad();

$test = $vlad->test([
	[
		['device[location][coordinates][lat]', 'device[location][coordinates][lng]'], // Selector can refer to multidimensional values.
		['not_empty']
	]
]);

$result = $test->assess($input);
?>
<pre><code><?php var_dump($result->getFailed());?></code></pre>