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
			'width' => null,
			'min_width' => null,
			'max_width' => null,
			'height' => null,
			'min_height' => null,
			'max_height' => null,
			'mime' => ['gif', 'jpeg', 'png']
		],
		$messages = [
			'unsupported_type' => [
				'{vlad.subject.name} is not a supported image format.',
				'The input file is not a supported image format.'
			],
			'width' => [
				'{vlad.subject.name} image width must be {vlad.validator.options.width}px.',
				'The image width must be {vlad.validator.options.width}px.'
			],
			'min_width' => [
				'{vlad.subject.name} image width must be at least {vlad.validator.options.min_width}px.',
				'The image width must be at least {vlad.validator.options.min_width}px.'
			],
			'max_width' => [
				'{vlad.subject.name} image width must be at most {vlad.validator.options.max_width}px.',
				'The image width must be at most {vlad.validator.options.max_width}px.'
			],
			'height' => [
				'{vlad.subject.name} image height must be {vlad.validator.options.height}px.',
				'The image height must be {vlad.validator.options.height}px.'
			],
			'min_height' => [
				'{vlad.subject.name} image height must be at least {vlad.validator.options.min_width}px.',
				'The image height must be at least {vlad.validator.options.min_width}px.'
			],
			'min_height' => [
				'{vlad.subject.name} image height must be at least {vlad.validator.options.min_width}px.',
				'The image must be at least {vlad.validator.options.min_width}px high.'
			]
		];

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();

		if (isset($options['width']) && (isset($options['min_width']) || isset($options['max_width']))) {
			throw new \gajus\vlad\exception\Invalid_Argument_Exception('"width" option cannot be present together with "min_width" or "max_width" option.');
		}

		if (isset($options['min_width']) && !ctype_digit((string) $options['min_width'])) {
			throw new \gajus\vlad\exception\Invalid_Argument_Exception('"min_width" option must be a whole number.');
		}

		if (isset($options['max_width']) && !ctype_digit((string) $options['max_width'])) {
			throw new \gajus\vlad\exception\Invalid_Argument_Exception('"max_width" option must be a whole number.');
		}

		if (isset($options['min_width'], $options['max_width']) && $options['min_width'] > $options['max_width']) {
			throw new \gajus\vlad\exception\Invalid_Argument_Exception('"min_width" option cannot be greater than "max_width".');
		}

		if (isset($options['height']) && (isset($options['min_height']) || isset($options['max_height']))) {
			throw new \gajus\vlad\exception\Invalid_Argument_Exception('"height" option cannot be present together with "min_height" or "max_height" option.');
		}

		if (isset($options['min_height']) && !ctype_digit((string) $options['min_height'])) {
			throw new \gajus\vlad\exception\Invalid_Argument_Exception('"min_height" option must be a whole number.');
		}

		if (isset($options['max_height']) && !ctype_digit((string) $options['max_height'])) {
			throw new \gajus\vlad\exception\Invalid_Argument_Exception('"max_height" option must be a whole number.');
		}

		if (isset($options['min_height'], $options['max_height']) && $options['min_height'] > $options['max_height']) {
			throw new \gajus\vlad\exception\Invalid_Argument_Exception('"min_height" option cannot be greater than "max_height".');
		}

		if (!is_array($options['mime'])) {
			throw new \gajus\vlad\exception\Invalid_Argument_Exception('"mime" must be an array of image/ mime type extensions.');
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
			throw new \gajus\vlad\exception\Runtime_Exception('Validator selector does not reference file input.');
		}

		// Temporary
		if ($tmp_name === '') {
			return;
		}

		$finfo = new \finfo(\FILEINFO_MIME_TYPE);

		$mime_type = $finfo->file($tmp_name);

		if (!$mime_type) {
			throw new \gajus\vlad\exception\Runtime_Exception('File mime type cannot be determined.');
		}

		$options = $this->getOptions();

		if (is_array(explode('/', $mime_type)[1], $options['mime'])) {
			return 'unsupported_type';
		}

		$image_size = @getimagesize($tmp_name);

		if ($image_size === false) {
			throw new \gajus\vlad\exception\Runtime_Exception('File image size cannot be determined.');
		}

		if (isset($options['width']) && $options['width'] != $image_size[0]) {
			return 'width';
		} else if (isset($options['min_width']) && $options['min_width'] > $image_size[0]) {
			return 'min_width';
		} else if (isset($options['max_width']) && $options['max_width'] < $image_size[0]) {
			return 'max_width';
		} else if (isset($options['height']) && $options['height'] != $image_size[1]) {
			return 'height';
		} else if (isset($options['min_height']) && $options['min_height'] > $image_size[1]) {
			return 'min_height';
		} else if (isset($options['max_height']) && $options['max_height'] < $image_size[1]) {
			return 'max_height';
		}
	}
}

