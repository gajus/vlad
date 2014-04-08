# Vlad

[![Build Status](https://travis-ci.org/gajus/vlad.png?branch=master)](https://travis-ci.org/gajus/vlad)
[![Coverage Status](https://coveralls.io/repos/gajus/vlad/badge.png)](https://coveralls.io/r/gajus/vlad)

Input validation library.

## Succint Test Declaration

Test is composed of assertions about input.

```php
$test = new \Gajus\Vlad\Test();

$test
    ->assert('user[first_name]')
    ->is('NotEmpty')
    ->is('String');

if ($assessment = $test->assess($_POST)) {
    foreach ($assessment as $error) {
        // 
    }
}
```

## Extendable Validation Rules

Vlad has in-built validators. It is easy to write custom validators. You can [request new validators](https://github.com/gajus/vlad/issues) to be added to the core package. Validators benefit from the translator interface. Vlad does not encourage inline boolean validation expressions.

### Inbuilt Validation Rules

* [String](src/Validator/String.php)
* [Regex](src/Validator/Regex.php)
* [RangeMinInclusive](src/Validator/RangeMinInclusive.php)
* [RangeMinExclusive](src/Validator/RangeMinExclusive.php)
* [RangeMaxInclusive](src/Validator/RangeMaxInclusive.php)
* [RangeMaxExclusive](src/Validator/RangeMaxExclusive.php)
* [NotEmpty](src/Validator/NotEmpty.php)
* [LengthMin](src/Validator/LengthMin.php)
* [LengthMax](src/Validator/LengthMax.php)
* [In](src/Validator/In.php)
* [Email](src/Validator/Email.php)

## Multilingual

Translator allows to overwrite default error messages, input specific error messages and give input names.

## Documentation



## Todo

* HEX colour validator.
* Add URL validator. This should consider that URL does not necessarily include protocol and that those that do include, e.g. ftp:// might not necessarily be expected URLs.
* Improve email validator. Zend validator includes useful additions (MX check, host name validator, etc) https://github.com/zendframework/zf2/blob/master/library/Zend/Validator/EmailAddress.php.

## Alternatives

* https://github.com/zendframework/zf2/tree/master/library/Zend/Validator
* https://github.com/Respect/Validation
* https://github.com/Wixel/GUMP
* https://github.com/vlucas/valitron
* https://github.com/Dachande663/PHP-Validation
* https://github.com/ASoares/PHP-Form-Validation
* https://github.com/fuelphp/validation
* https://github.com/smgt/inspector