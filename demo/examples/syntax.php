<?php
$options = [
	'birth' => [
		'year' => range(date('Y') - 100, date('Y')),
		'month' => range(1, 12),
		'day' => range(1, 31)
	],
	'sex' => ['male', 'female']
];

$input = [
	'first_name' => 'Vlad',
	'last_name' => 'Github',
	'email' => 'vlad@github.com',
	'email_again' => 'vlad@github.com',
	'birth' => [
		'year' => 1989,
		'month' => 1,
		'day' => 20
	],
	'sex' => 'male'
];

$doctor = new \gajus\vlad\Doctor();

$test = $doctor->test([
	[
		['first_name', 'last_name', 'password'],
		[
			'not_empty',
			'length' => ['max' => 10]
		]
	],
	[
		['email'],
		[
			'not_empty',
			'email',
			'length' => ['max' => 10]
		]	
	],
	[
		['email_again'],
		[
			'not_empty',
			'match' => ['to' => 'email']
		]
	],
	[
		['birth[year]', 'birth[month]', 'birth[day]', 'sex'],
		[
			'not_empty',
			'in' => ['haystack' => $options]
		]
	]
]);

$assessment = $test->assess($input);
?>
<pre><code><?php var_dump($assessment);?></code></pre>