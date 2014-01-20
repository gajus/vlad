# Vlad

[![Build Status](https://travis-ci.org/gajus/vlad.png?branch=master)](https://travis-ci.org/gajus/vlad)
[![Coverage Status](https://coveralls.io/repos/gajus/vlad/badge.png)](https://coveralls.io/r/gajus/vlad)

Vlad is input validation library.

Vlad has [in-built validators](http://anuary.com/vlad/#example-validators). You may write [custom validators](http://anuary.com/vlad/#example-custom_validator) and [request new validators](https://github.com/gajus/vlad/issues) to be added to the core package. The custom validator classes will benefit from the [translator interface](http://anuary.com/vlad/#example-multilingual). However, Vlad does not promote inline boolean validation rules.

Vlad is all about succint test declaration, extendable validation rules and multilingual support. The implementation, syntax, and collection of the validators is a result of an extensive research of other input validation libraries:

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

Vlad uses a custom *many, many-to-many* [array syntax](http://anuary.com/vlad/#example-syntax) to define selectors and validation rules. The test script is defined using a single array; this allows interoperability with the client-side script.

Vlad validators are validation domains (similar to Zend) instead of single-validation classes. Validator options allow to customise validator behaviour (e.g. whether Email address MX records are checked).

Produced errors always inlclude two sets of messages: public and anonymous. The former is used to display error messages in error summary, while the latter – inline (e.g. "Name is left empty.", "Input is left empty.").

Translator allows to overwrite default error messages, input specific error messages and give input names.

## Documentation

[Documentation](http://anuary.com/vlad/) and [Usage Examples](http://anuary.com/vlad/) are written using code examples with inline documentation.

## Todo

* Credit card validator.
* Get the input back from Test/Result that matches at least one rule (and passes that rule?).
* Add Allow adding custom error message to the Result for input or non-input (e.g. duplicate value). This error would then be passed to the hasErrors array.
* Add URL validator. This should consider that URL does not necessarily include protocol and that those that do include, e.g. ftp:// might not necessarily be expected URLs.
* Make it more easy to test $regex = new \ay\vlad\validator\Regex(['pattern' => '/test/']); The problem is that Validator requires Subject instance, which creates a chain of dependencies. Simple input should be preferred. However, this introduces “challenge” (OCD) of controlling the is_found/not_found value. Alternatively, a second validation interface could be introduced that disregards the isFound method altogether. However, then Validator should have an option whether value is required or not.
* Validate the translations file. Now that a translation array is loaded, only the syntax is validated, but not whether the translation file resolves to the known error_names from the validator.
* Improve email validator. Zend validator includes useful additions (MX check, host name validator, etc) https://github.com/zendframework/zf2/blob/master/library/Zend/Validator/EmailAddress.php.
* Validator should return Error object. This will allow validator to use another validator internally to validate the input, e.g. email validator could first use host validator.
* http://www.php-fig.org/