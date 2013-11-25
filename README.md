# Vlad

Input validation library:

* succinct
* extendable
* multilingual

Full documentation and usage examples are available at: https://dev.anuary.com/740cfb7d-6ed3-5904-aa5c-7a7f80ed2faf/vendor/ay/vlad/demo/.

## Syntax

Vlad is using custom syntax to define input rules, e.g.

```
rule1
	input[name]
rule2
rule3 parameter1=value1
	input[name]
rule3 parameter1=value1 parameter2=value2
	input[foo1]
	input[foo2]
```

In practise:

```php
// Dummy $input
$input = [
	'user' => [
		'name' => [
			'first_name' => 'Gajus',
			'last_name' => 'Kuizinas'
		],
		'email' => 'gajus@kuizinas.ltd',
		'alt1_email' => '', // This will trigger 'required' rule.
		'alt2_email' => 'invalid_email', // This will trigger 'email' rule.
		'birthdate' => '1989-01-10'
	]
];

$vlad = new \ay\vlad\Vlad($input);

$test = $vlad->test('
	required
	string
		user[name][first_name]
		user[email]
		user[alt1_email]
		user[alt2_email]
	length min=5
		user[name][first_name]
	length max=10
		user[name][last_name]
	email
		user[email]
		user[alt1_email]
		user[alt2_email]
');
```

The above `test` call will generate the following output:

```
array(2) {
  [0]=>
  array(3) {
    ["input"]=>
    array(3) {
      ["name"]=>
      string(16) "user[alt1_email]"
      ["value"]=>
      string(0) ""
      ["options"]=>
      array(1) {
        ["name"]=>
        string(15) "User Alt1 Email"
      }
    }
    ["rule"]=>
    array(2) {
      ["name"]=>
      string(8) "required"
      ["options"]=>
      array(0) {
      }
    }
    ["message"]=>
    array(2) {
      ["name"]=>
      string(8) "is_empty"
      ["message"]=>
      string(32) "User Alt1 Email cannot be empty."
    }
  }
  [1]=>
  array(3) {
    ["input"]=>
    array(3) {
      ["name"]=>
      string(16) "user[alt2_email]"
      ["value"]=>
      string(13) "invalid_email"
      ["options"]=>
      array(1) {
        ["name"]=>
        string(15) "User Alt2 Email"
      }
    }
    ["rule"]=>
    array(2) {
      ["name"]=>
      string(5) "email"
      ["options"]=>
      array(0) {
      }
    }
    ["message"]=>
    array(2) {
      ["name"]=>
      string(14) "invalid_format"
      ["message"]=>
      string(46) "User Alt2 Email must be a valid email address."
    }
  }
}
```
