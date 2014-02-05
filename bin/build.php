<?php
/**
 * Build the default translation file (./i18l/en.php) to reflect all of the existing errors.
 */

require __DIR__ . '/../tests/bootstrap.php';

$validator_classes = array_filter(get_declared_classes(), function ($e) {
    return strpos($e, 'gajus\vlad\validator\\') === 0;
});

sort($validator_classes);

$translation = [
    'validator_error' => []
];

foreach ($validator_classes as $vc) {
    $translation['validator_error'][strtolower($vc)] = $vc::getMessages();
}

$translation = var_export($translation, true);

$translation = str_replace([
    #'    array (',
    #'    ),',
    'array (',
    '),',
    '     0 =>',
    '     1 =>'
],
[
    #'    [',
    #'    ],',
    '[',
    '],',
    '      ',
    '      '], $translation);

$translation = "<?php
/**
 * This file is generated using ./bin/build.php.
 */

return " . mb_substr($translation, 0, -1) . '];';

file_put_contents(__DIR__ . '/../i18l/en.php', $translation);