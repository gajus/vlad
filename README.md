Vlad
====

Vlad is input validation library. 

Vlad has [in-built validators](http://anuary.com/vlad/#example-validators). You may write [custom validators](http://anuary.com/vlad/#example-custom_validator) and [request new validators](https://github.com/gajus/vlad/issues) to be added to the core package. The custom validator classes will benefit from the [translator interface](http://anuary.com/vlad/#example-multilingual). However, Vlad does not promote inline boolean validation rules.

Library is designed to use DRY/succinct syntax with extendable validation rules and multilingual support. The implementation, syntax, and collection of the validators is a result of an extensive research of other input validation libraries:

* https://github.com/zendframework/zf2/tree/master/library/Zend/Validator
* https://github.com/Respect/Validation
* https://github.com/Wixel/GUMP
* https://github.com/vlucas/valitron
* https://github.com/Dachande663/PHP-Validation
* https://github.com/ASoares/PHP-Form-Validation
* https://github.com/fuelphp/validation
* https://github.com/smgt/inspector

If I have left out a worth mentioning library, please [raise an issue](https://github.com/gajus/vlad/issues) with the name & I will include it in the above list.

However, while all of the above libraries share similar syntax and implementation, Vlad is an exception.

Vlad uses a custom *many, many-to-many* [array syntax](http://anuary.com/vlad/#example-syntax) to define selectors and validation rules. This syntax allows setting [chain options and validator parameters](http://anuary.com/vlad/#example-options). Since all of the input test script is defined in a single array, this allows to export a JSON object for inteoperability with client-side script.

Vlad validators are validation domains (similar to Zend) instead of single-validation classes. Validator options allow to customise validator behaviour (e.g. whether Email address MX records are checked).

Produced errors always inlclude two sets of messages: public and anonymous. The former is used to display error messages in error summary, while the latter – next to the input (e.g. "Name is left empty.", "Input is left empty.").

Translator allows to overwrite default error messages, input specific error messages and give input names.

**This library is in active development. Code critique, suggestions and flagging issues is much appreciated. However, I do not advise to use it. Instead, please watch/star the library and I will update you when first stable release is ready.**

[Documentation](http://anuary.com/vlad/) and [Usage Examples](http://anuary.com/vlad/) are written using code examples with inline documentation.

## Introductory Syntax

```php
<?php
$dummy_input = [
  'foo' => 'me@foo.tld',
  'bar' => 'invalidemail',
  'baz' => '',
];

$vlad = new \ay\vlad\Vlad();

$test = $vlad->test([
  [
    ['foo', 'bar', 'baz'], // Selectors
    ['not_empty', 'email'] // Rules
  ],
  [
    ['qux'],
    ['required']
  ]
]);

// The above method creates an instance of a Test.
// Each selector (e.g. foo, bar, baz) is assigned all of the rules
// from the same group, e.g. selector 'foo' is assigned rules 'not_empty' and 'email'.

$result = $test->assess($dummy_input);

var_dump($result->getFailed());
```

The above `var_dump` call will generate the following output:

```
array(3) {
  [3]=>
  array(2) {
    ["selector"]=>
    string(3) "bar"
    ["message"]=>
    string(34) "Bar must be a valid email address."
  }
  [4]=>
  array(2) {
    ["selector"]=>
    string(3) "baz"
    ["message"]=>
    string(23) "Baz is cannot be empty."
  }
  [5]=>
  array(2) {
    ["selector"]=>
    string(3) "qux"
    ["message"]=>
    string(16) "Qux is required."
  }
}
```
