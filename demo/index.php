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
		'email' => 'foo@bar',
		'birthdate' => '1991-01-23'
	]
];

header('Content-Type: text/plain');

$vlad = new \ay\vlad\Vlad($input);

$outcome = $vlad->test('
	not_empty
	string
		user[name][first_name]
		user[name][last_name]
	email
		user[email]
	not_empty +suppress
	email
		user[alt_email]
');

die(var_dump( $outcome ));

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