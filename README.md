# Vlad

Input validation library:

* succinct
* extendable
* multilingual

[Documentation and usage examples](https://dev.anuary.com/740cfb7d-6ed3-5904-aa5c-7a7f80ed2faf/vendor/ay/vlad/demo/).

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
