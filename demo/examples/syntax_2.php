<?php
$dummy_input = [
	'foo' => 'me@foo.tld',
	'bar' => 'invalidemail',
	'baz' => 'fictional.too.long@email.address.tld',
];

$vlad = new \ay\vlad\Vlad();

$test = $vlad->test([
	[
		['foo', 'bar', 'baz'],
		[
			'break:',
			// Apart from Rules, this array is used to define Rule processing options. These are:
			// * 'soft' will record an error and progress to the next Rule.
			// * 'hard' (default) will record an error and exclude the selector from the rest of the Test.
			// * 'break' will record an error and interrupt the Test.
			'required',
			'not_empty',
			'hard:', // Reset to default Rule processing type.
			'email',
			'length' => ['max' => 10] // Pass options to the Rule constructor. Individual Rule options can be read from the respective Rule classes.
		]
	]
]);

$result = $test->assess($dummy_input);
?>
<pre><code><?php var_dump($result->getFailed());?></code></pre>