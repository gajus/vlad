<?php
set_include_path( __DIR__ . '/../../../' );

spl_autoload_register();
spl_autoload_extensions('.class.php');

$input = [
	'user' => [
		'name' => [
			'first_name' => 'Gajus',
			'last_name' => 'Kuizinas'
		],
		'email' => 'gajus@kuizinas.ltd',
		'alt1_email' => '', // This will trigger 'required' rule.
		'alt2_email' => 'invalid_email', // This will trigger 'email' rule.
		'birthdate' => '1989-01-10'
	]
];

$vlad = new \ay\vlad\Vlad($input);

$test = $vlad->test('
	required
	string
		user[name][first_name]
		user[email]
		user[alt1_email]
		user[alt2_email]
	length min=5
		user[name][first_name]
	length max=10
		user[name][last_name]
	email
		user[email]
		user[alt1_email]
		user[alt2_email]
');

ay( $test );

/**
 * Used for testing only.
 */
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