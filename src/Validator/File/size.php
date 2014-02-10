<?php
namespace Gajus\Vlad\Validator\File;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Size extends \Gajus\Vlad\Validator {
	static protected
		$default_options = [
			'min' => null, // kilobytes
			'max' => null,
			//'name' => 'auto'
		],
		$messages = [
			'min' => [
				'{vlad.subject.name} file size must be at least {vlad.validator.options.min}KB.',
				'The file size must be at least {vlad.validator.options.min}KB.'
			],
			'max' => [
				'{vlad.subject.name} file size must be at most {vlad.validator.options.max}KB.',
				'The file size must be at most {vlad.validator.options.max}KB.'
			]
		];

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();

		if (isset($options['min']) && !ctype_digit((string) $options['min'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"min" option must be a whole number.');
		}

		if (isset($options['max']) && !ctype_digit((string) $options['max'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"max" option must be a whole number.');
		}

		// @todo Not supported at the time of writting.
		#if (!in_array($options['name'], ['auto', 'kb', 'mb', 'gb', 'tb'])) {
		#	throw new \Gajus\Vlad\Exception\InvalidArgumentException('Unsupported "name" option value.');
		#}
	}

	public function validate (\gajus\vlad\Subject $subject) {
		$selector_path = $subject->getSelector()->getPath();

		array_splice($selector_path, 1, 0, 'tmp_name');

		$tmp_name = $_FILES;

		foreach ($selector_path as $breadcrumb) {
			if (isset($tmp_name[$breadcrumb])) {
				$tmp_name = $tmp_name[$breadcrumb];
			}
		}

		if (!is_string($tmp_name)) {
			throw new \Gajus\Vlad\Exception\RuntimeException('Validator selector does not reference file input.');
		}

		// Temporary
		if ($tmp_name === '') {
			return;
		}

		$file_size = filesize($tmp_name);

		if (isset($options['min']) && $options['min'] > $file_size ) {
			return 'min';
		}

		if (isset($options['max']) && $options['max'] < $file_size ) {
			return 'max';
		}
	}
}