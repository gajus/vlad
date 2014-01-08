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
				<pre><code class="language-php"><?=str_replace("\t", '    ', htmlspecialchars(file_get_contents(__DIR__ . '/examples/' . $name . '.php')))?></code></pre>
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
	<script src="static/js/highlight/highlight.pack.js"></script>
	
	<script>
	hljs.initHighlightingOnLoad();
	</script>

	<link href="static/css/frontend.css" rel="stylesheet">
	<link href="static/js/highlight/styles/default.css" rel="stylesheet">

	<title>Vlad – Input validation</title>
</head>
<body>
	<div id="sidebar">
		<h1>Vlad</h1>
		<h2>Input validation – <br><a href="https://github.com/gajus/vlad" target="_blank">https://github.com/gajus/vlad</a></h2>

		<iframe src="http://ghbtns.com/github-btn.html?user=gajus&repo=vlad&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>

		<ol class="nav">
			<li>Syntax</li>
			<li>Syntax #2</li>
			<li>Selector</li>
			<li>Multilingual</li>
			<li>Custom Validator</li>
		</ol>
	</div>

	<div id="header">
		<div class="aux">
			<div class="text">
				<p>Vlad is input validation library designed to use succinct syntax with extendable validation validators and multilingual support.</p>
				<p>Vlad is not input sanitization library.</p>
			</div>
		</div>
	</div>

	<div id="examples">
		<?=$example('syntax', 'Syntax')?>
		<?=$example('syntax_2', 'Syntax #2')?>
		<?=$example('selector', 'Selector')?>
		<?=$example('multilingual', 'Multilingual')?>
		<?php /*<?=$example('validators', 'Custom Validator')?>*/?>
		<?=$example('custom_validator', 'Custom Validator')?>
	</div>
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