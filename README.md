# Vlad

[![Build Status](https://travis-ci.org/gajus/vlad.png?branch=master)](https://travis-ci.org/gajus/vlad)
[![Coverage Status](https://coveralls.io/repos/gajus/vlad/badge.png)](https://coveralls.io/r/gajus/vlad)

Input validation library.

## Succint test declaration

```php
$input = new \Gajus\Vlad\Input($_POST);
$test = new \Gajus\Vlad\Test();

$test
    ->assert('user[first_name]')
    ->is('NotEmpty')
    ->is('String');

if ($assessment = $test->assess($input)) {
    foreach ($assessment as $error) {
        // 
    }
}
```

Individual validator options allow to customise the test-case behaviour (e.g. whether Email address MX records are checked).

## Extendable validation rules

Vlad has [in-built validators](http://anuary.com/vlad/#example-validators). It is easy to write [custom validators](http://anuary.com/vlad/#example-custom_validator). You can [request new validators](https://github.com/gajus/vlad/issues) to be added to the core package. Validators benefit from the [translator interface](http://anuary.com/vlad/#example-multilingual). Vlad does not promote inline boolean validation cases.

## Multilingual

Produced errors always include two sets of messages: public and anonymous. The former is used to display error messages in error summary, while the latter – inline (e.g. "Name is left empty.", "Input is left empty.").

Translator allows to overwrite default error messages, input specific error messages and give input names.

## Documentation

[Documentation](http://anuary.com/vlad/) and [Usage Examples](http://anuary.com/vlad/) are written using code examples with inline documentation.

## Todo

* HEX colour validator.
* Allow adding custom error message to the Result for input or non-input (e.g. duplicate value). This error would then be passed to the hasErrors array.
* Add URL validator. This should consider that URL does not necessarily include protocol and that those that do include, e.g. ftp:// might not necessarily be expected URLs.
* Improve email validator. Zend validator includes useful additions (MX check, host name validator, etc) https://github.com/zendframework/zf2/blob/master/library/Zend/Validator/EmailAddress.php.
* http://www.php-fig.org/

## Alternatives

* https://github.com/zendframework/zf2/tree/master/library/Zend/Validator
* https://github.com/Respect/Validation
* https://github.com/Wixel/GUMP
* https://github.com/vlucas/valitron
* https://github.com/Dachande663/PHP-Validation
* https://github.com/ASoares/PHP-Form-Validation
* https://github.com/fuelphp/validation
* https://github.com/smgt/inspector