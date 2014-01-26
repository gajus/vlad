<?php
namespace gajus\vlad\validator\file;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Selected extends \gajus\vlad\Validator {
	static protected
		$requires_value = false,
		$messages = [
			'not_selected' => [
				'{vlad.subject.name} file is not selected.',
				'The input file is not selected.'
			]
		];
	
	protected function validate (\gajus\vlad\Subject $subject) {
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

		if ($tmp_name === '') {
			return 'not_selected';
		}
	}
}