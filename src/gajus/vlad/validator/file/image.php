<?php
namespace gajus\vlad\validator\file;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Image extends \gajus\vlad\Validator {
	static protected
		$requires_value = false,
		$default_options = [
			'min_width' => null,
			'max_width' => null,
			'min_height' => null,
			'max_height' => null,
			'mime_type' => ['gif', 'jpeg', 'png']
		],
		$messages = [
			'unsupported_type' => [
				'{vlad.subject.name} is not a supported image format.',
				'The input file is not a supported image format.'
			],
			'min_width' => [
				'{vlad.subject.name} must be at least {vlad.validator.options.min_width}px wide.',
				'The image must be at least {vlad.validator.options.min_width}px wide.'
			],
			'max_width' => [
				'{vlad.subject.name} must be at most {vlad.validator.options.max_width}px wide.',
				'The image must be at most {vlad.validator.options.max_width}px wide.'
			],
			'min_height' => [
				'{vlad.subject.name} must be at least {vlad.validator.options.min_width}px high.',
				'The image must be at least {vlad.validator.options.min_width}px high.'
			],
			'min_height' => [
				'{vlad.subject.name} must be at least {vlad.validator.options.min_width}px high.',
				'The image must be at least {vlad.validator.options.min_width}px high.'
			]
		];

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();

		if (isset($options['min_width']) && !ctype_digit((string) $options['min_width'])) {
			throw new \InvalidArgumentException('"min_width" option must be a whole number.');
		}

		if (isset($options['max_width']) && !ctype_digit((string) $options['max_width'])) {
			throw new \InvalidArgumentException('"max_width" option must be a whole number.');
		}

		if (isset($options['min_height']) && !ctype_digit((string) $options['min_height'])) {
			throw new \InvalidArgumentException('"min_height" option must be a whole number.');
		}

		if (isset($options['max_height']) && !ctype_digit((string) $options['max_height'])) {
			throw new \InvalidArgumentException('"max_height" option must be a whole number.');
		}

		if (isset($options['min_width'], $options['max_width']) && $options['min_width'] > $options['max_width']) {
			throw new \InvalidArgumentException('"min_width" option cannot be greater than "max_width".');
		}

		if (isset($options['min_height'], $options['max_height']) && $options['min_height'] > $options['max_height']) {
			throw new \InvalidArgumentException('"min_height" option cannot be greater than "max_height".');
		}
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
			throw new \RuntimeException('Validator selector does not reference file input.');
		}

		// Temporary
		if ($tmp_name === '') {
			return;
		}

		$finfo = new \finfo(\FILEINFO_MIME_TYPE);

		$mime_type = $finfo->file($tmp_name);

		if (!$mime_type) {
			throw new \RuntimeException('File mime type cannot be determined.');
		}

		$options = $this->getOptions();

		if (is_array(explode('/', $mime_type)[1], $options['mime_type'])) {
			return 'unsupported_type';
		}

		$image_size = @getimagesize($tmp_name);

		if ($image_size === false) {
			throw new \RuntimeException('File image size cannot be determined.');
		}

		if (isset($options['min_width']) && $options['min_width'] > $image_size[0]) {
			return 'min_width';
		}

		if (isset($options['max_width']) && $options['max_width'] < $image_size[0]) {
			return 'max_width';
		}

		if (isset($options['min_height']) && $options['min_height'] > $image_size[1]) {
			return 'min_height';
		}

		if (isset($options['max_height']) && $options['max_height'] < $image_size[1]) {
			return 'max_height';
		}
	}
}

