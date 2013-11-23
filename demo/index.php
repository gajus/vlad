<?php
set_include_path( __DIR__ . '/../../../' );

spl_autoload_register();
spl_autoload_extensions('.class.php');

$input = [
	'user' => [
		'name' => [
			'first_name' => 'a',
			'last_name' => 'b'
		],
		'birthdate' => '1991-01-23'
	]
];

header('Content-Type: text/plain');

$vlad = new \ay\vlad\Vlad($input);

$outcome = $vlad->test('
not_empty
	user[name][first_name]
	user[name][last_name]
');

// @todo Pass parameters to rule
// @todo Pass options to input