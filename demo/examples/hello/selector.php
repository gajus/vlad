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

$vlad = new \ay\vlad\Vlad($input);

$test = $vlad->test('
	required
		device[location][coordinates][lat]
		device[location][coordinates][lng]
');

/*

Input selector can refer to variable array depth.

No error since both coordinates are present.

*/

?>
<pre class="var-dump">
<?php var_dump($test);?>
</pre>