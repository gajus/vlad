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
		'email' => 'foo@bar.ltd',
		'alt1_email' => '',
		'alt2_email' => 'test',
		'birthdate' => '1991-01-23'
	]
];

header('Content-Type: text/plain');

$vlad = new \ay\vlad\Vlad($input);

$outcome = $vlad->test('
	not_empty
		user[alt1_email]
	length min=0
		user[name][first_name]
		user[name][last_name]
		user[email]
');

ay( $outcome );

/*
not_empty
	string
	length min=10
		user[name][first_name]
		user[name][last_name]
		user[email]
	email
		user[email]
	not_empty
	email
		user[alt1_email]
		user[alt2_email]

required
    username
    email
    password
unique table=user
    username
unique table=user
    email
length min=7
    password*/

/*not_empty
	string
		
	email
		user[email]*/


// @todo Pass parameters to rule
// @todo Pass options to input

function ay () {
	if (ob_get_level()) {
		ob_clean();
	}
	
	if (!headers_sent()) {
		header('Content-Type: text/plain; charset="UTF-8"', true);
	}
	
	// Unless something went really wrong, $trace[0] will always reference call to ay().
	$trace = debug_backtrace()[0];
	
	ob_start();
	echo 'ay\ay() called in ' . $trace['file'] . ' (' . $trace['line'] . ').' . PHP_EOL . PHP_EOL;
	
	call_user_func_array('var_dump', func_get_args());
	
	echo PHP_EOL . 'Backtrace:' . PHP_EOL . PHP_EOL;
	
	debug_print_backtrace();
	
	$response = preg_replace('/(?!\n)[\p{Cc}]/', '', ob_get_clean());
	
	$response = preg_replace_callback('/int\(([0-9]{10})\)/', function ($e) {
		return $e[0] . ' <== ' . date('Y-m-d H:i:s', $e[1]);
	}, $response);
	
	echo $response;
	
	exit;
}