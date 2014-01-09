# Vlad

Vlad is input validation library designed to use succinct syntax with extendable validation rules and multilingual support.

**This library is in active development. Code critique, suggestions and flagging issues is much appreciated. However, I do not advise to use it yet. Instead, please watch/star the library and I will update you when first stable release is ready.**

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
