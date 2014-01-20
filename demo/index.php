<?php
set_include_path( __DIR__ . '/../src/' );

spl_autoload_register();

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
			<li>Options & Parameters</li>
			<li>Validators</li>
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
		<?=$example('syntax2', 'Syntax 2')?>
		<?php /*<?=$example('syntax', 'Syntax')?>
		<?=$example('options', 'Options & Parameters')?>
		<?=$example('validators', 'Validators')?>
		<?=$example('multilingual', 'Multilingual')?>
		<?=$example('custom_validator', 'Custom Validator')?>*/ ?>
	</div>
</body>
</html>
<?php
echo ob_get_clean();