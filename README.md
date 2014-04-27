# Vlad

[![Build Status](https://travis-ci.org/gajus/vlad.png?branch=master)](https://travis-ci.org/gajus/vlad)
[![Coverage Status](https://coveralls.io/repos/gajus/vlad/badge.png?branch=master)](https://coveralls.io/r/gajus/vlad?branch=master)
[![Latest Stable Version](https://poser.pugx.org/gajus/vlad/version.png)](https://packagist.org/packages/gajus/vlad)
[![License](https://poser.pugx.org/gajus/vlad/license.png)](https://packagist.org/packages/gajus/vlad)

Input validation library, that has inbuilt error messages that are translatable, validators that are easy to extend, and that has easy to understand test declaration syntax.

## Succinct Test Declaration

Test is composed of assertions about the input.

```php
/**
 * @param Gajus\Vlad\Translator $translator
 */
$test = new \Gajus\Vlad\Test();

/**
 * Add an assertion to the test.
 *
 * @param string $selector_name
 * @return Gajus\Vlad\Assertion
 */
$assertion = $test->assert('user[first_name]');

/**
 * @param string $validator_name
 * @param array $validator_options
 * @param array $condition_options
 * @return Gajus\Vlad\Assertion
 */
$assertion->is('NotEmpty');
$assertion->is('String');
$assertion->is('LengthMin', ['length' => 5]);
$assertion->is('LengthMax', ['length' => 20]);

// In practise, assertion is declared using chaining:
$test
    ->assert('user[last_name]')
    ->is('NotEmpty')
    ->is('String')
    ->is('LengthMin', ['length' => 5])
    ->is('LengthMax', ['length' => 20]);

/**
 * @param array $source
 * @param string $selector_name
 * @return array Errors.
 */
$assessment = $test->assess($_POST);

if ($assessment) {
    // Iterate through error messages.
    foreach ($assessment as $error) {
        // [..]
    }
}
```

### Limit the Assessment Scope

Note that assertions are done against selector name, not the actual value. You can limit test to specific assertions at the time of the assessment:

```php
/**
 * @param string $selector_name
 * @param mixed $value
 * @return string Error.
 */
$error = $test->assertion('user[first_name]', $_POST);
```

## Extendable Validation Rules

Vlad has [inbuilt validators](https://github.com/gajus/vlad#inbuilt-validation-rules). It is easy to write [custom validators](https://github.com/gajus/vlad#writing-a-custom-validator). You can [request new validators](https://github.com/gajus/vlad/issues) to be added to the core package. Validators benefit from the translator interface.

Vlad does not encourage inline boolean validation expressions.

### Inbuilt Validation Rules

| Validator | Description |
| --- | --- |
| [String](src/Validator/String.php) | Validate that input is a string. |
| [Regex](src/Validator/Regex.php) | Validate that input is matched using a regular expression. |
| [RangeMinInclusive](src/Validator/RangeMinInclusive.php)| Validate that a numeric input is at least of the given size (inclusive). |
| [RangeMinExclusive](src/Validator/RangeMinExclusive.php)| Validate that a numeric input is at least of the given size (exclusive). |
| [RangeMaxInclusive](src/Validator/RangeMaxInclusive.php)| Validate that a numeric input is at most of the given size (inclusive). |
| [RangeMaxExclusive](src/Validator/RangeMaxExclusive.php)| Validate that a numeric input is at most of the given size (exclusive). |
| [NotEmpty](src/Validator/NotEmpty.php) | Validate that input value is not empty. |
| [Length](src/Validator/Length.php) | Validate that input string representation is of a specific length. |
| [Integer](src/Validator/Integer.php) | Validate that input is an integer. |
| [LengthMin](src/Validator/LengthMin.php) | Validate that input string representation is not shorter than the specified length. |
| [LengthMax](src/Validator/LengthMax.php) | Validate that input string representation is not longer than the specified length. |
| [In](src/Validator/In.php) | Validate that input value is in the haystack. |
| [Email](src/Validator/Email.php) | Validate that input value is syntactically valid email address. |

### Writing a Custom Validator

Each validator is a class that extends `Gajus\Vlad\Validator`. Validators that are not part of the Vlad package must be under a namespace.

```php
<?php
namespace Foo\Bar;

class HexColor extends \Gajus\Vlad\Validator {
    static protected
        // Each option must be predefined with default value.
        $default_options = [
            'trim' => false
        ],
        $message = '{input.name} is not a hexadecimal number.';
    
    public function assess ($value) {
        $options = $this->getOptions();

        if ($options['trim']) {
            $value = ltrim($value, '#');
        }

        return ctype_xdigit($value) && (strlen($value) == 6 || strlen($value) == 3);
    }
}
```

In the test declaration, custom validator is referred to using the full (namespaced) class name.

```php
$test = new \Gajus\Vlad\Test();
$test
    ->assert('foo_bar')
    ->is('Foo\Bar\HexColor');

$assessment = $test->assess(['foo_bar' => 'fff']);
```

## Multilingual

Translator allows to overwrite default error messages and give input names.

In addition to the provided (below) use cases of the translator, you can extend `Gajus\Vlad\Translator` with your own functionality (e.g. importing translations from a file or database).

### Input name

In most cases, you do not need to provide input name at all. Vlad will derive English name from the selector, e.g. `foo[bar_tar_id]` will come out as "Foo Bar Tar".

You can translate input names.

```php
$translator = new \Gajus\Vlad\Translator();
$translator->setInputName('foo[bar_tar_id]', 'Bar Tar');

$test = new \Gajus\Vlad\Test();
$test
    ->assert('foo_bar')
    ->is('NotEmpty');

$assessment = $test->assess([]);
```

The above will produce the following error message:

> Bar Tar is empty.

### Validator Message

Validators have inbuilt English error messages. You can overwrite them like this:

```php
$translator = new \Gajus\Vlad\Translator();
$translator->setValidatorMessage('NotEmpty', '{input.name} cannot be left empty.');

$test = new \Gajus\Vlad\Test($translator);
$test
    ->assert('foo_bar')
    ->is('NotEmpty');

$assessment = $test->assess([]);
```

> Foo Bar cannot be left empty.

### Assertion Error Message

Individual assertions can overwrite the error messages.

```php
$test = new \Gajus\Vlad\Test();
$test
    ->assert('foo_bar')
    ->is('NotEmpty', null, ['message' => 'You must provide Foo Bar value.']);
```

## Installation

Vlad uses [Composer](https://getcomposer.org/) to install and update:

```
curl -s http://getcomposer.org/installer | php
php composer.phar require gajus/vlad
```

## Todo

* Documentation.
* Add URL validator. This should consider that URL does not necessarily include protocol and that those that do include, e.g. ftp:// might not necessarily be expected URLs.
* Improve email validator. Zend validator includes useful additions (MX check, host name validator, etc) https://github.com/zendframework/zf2/blob/master/library/Zend/Validator/EmailAddress.php.

## Alternatives

* https://github.com/project-melody/validator
* https://github.com/zendframework/zf2/tree/master/library/Zend/Validator
* https://github.com/Respect/Validation
* https://github.com/Wixel/GUMP
* https://github.com/vlucas/valitron
* https://github.com/Dachande663/PHP-Validation
* https://github.com/fuelphp/validation
* https://github.com/smgt/inspector
