<?php
[
	['first_name', 'last_name', 'email', 'password'],
	[
		'length' => ['max' => 100]
	]
],
[
	['email_again'],
	[
		'match' => ['to' => 'email']
	]
],
[
	['birth_year'],
	[
		'in' => ['haystack' => $options['year']]
	]
],
[
	['birth_month'],
	[
		'in' => ['haystack' => $options['month']]
	]
],
[
	['birth_day'],
	[
		'in' => ['haystack' => $options['day']]
	]
],
[
	['sex'],
	[
		'in' => [$options['sex']]
	]
]