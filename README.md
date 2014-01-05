# Vlad

Input validation library:

* succinct
* extendable
* multilingual

Vlad is not a sanitization tool. There is rarely a case when you should sanitize user input (see http://anuary.com/55/why-input-sanitization-is-evil and http://phpsecurity.readthedocs.org/en/latest/Input-Validation.html#never-attempt-to-fix-input).

Documentation and usage examples are available at: http://anuary.com/vlad/.

## Syntax

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
