<?php
set_include_path( __DIR__ . '/../../../' );

spl_autoload_register();
spl_autoload_extensions('.class.php');

session_start();


$example = function ($name, $label) {
	ob_start();
	require __DIR__ . '/examples/' . $name . '.php';
	$output = ob_get_clean();
	?>
	<div class="example" id="example-<?=str_replace('/', '__', $name)?>">
		<div class="tab code">
			<div class="description">
				<h3><a href="#example-<?=str_replace('/', '__', $name)?>"><?=$label?></a></h3>
			</div>
		
			<div class="body">
				<pre><code class="language-php"><?=htmlspecialchars(file_get_contents(__DIR__ . '/examples/' . $name . '.php'))?></code></pre>
			</div>
		</div>
		<?php if ($output):?>
		<div class="tab demo">
			<div class="description"></div>
		
			<div class="body">
				<?=$output?>
			</div>
		</div>
		<?php endif;?>
	</div>
	<?php
};

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<script src="static/js/jquery-1.10.2.min.js"></script>
	<script src="static/js/frontend.js"></script>
	
	<link href="static/js/prism/prism.css" rel="stylesheet">
	<link href="static/css/frontend.css" rel="stylesheet">
</head>
<body>
	<div id="examples">
		<?php /*<?=$example('hello/syntax', 'Syntax')?>
		<?=$example('hello/error_output', 'Error Output')?>
		<?=$example('hello/selector', 'Selector')?>
		<?=$example('hello/multilingual', 'Multilingual')?>
		<?=$example('hello/multilingual_2', 'Multilingual #2')?>*/?>
		<?=$example('hello/custom_rule', 'Custom Rule')?>
	</div>
	
	<script src="static/js/prism/prism.js"></script>
</body>
</html>
<?php
echo ob_get_clean();

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