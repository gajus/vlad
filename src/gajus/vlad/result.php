<?php
namespace gajus\vlad;

/**
 * Assess the Test script against the input. The resulting object
 * instance is used to retrieve outcome of all Test cases.
 *
 *
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Result {
	private
		$result = [],
		$translator;
	
	final public function __construct (array $result, Translator $translator) {
		$this->result = $result;
		$this->translator = $translator;
	}

	public function hasFailed () {
		return count($this->result);
	}

	/**
	 * Return array of failed Assessments.
	 *
	 * @param string $format default|debug
	 * @return array
	 */
	public function getFailed ($format = 'default') {
		if ($format === 'default') {
			$result = array_map(function ($error) {
				return [
					'selector' => $error->getSubject()->getSelector(),
					'message' => $this->translator->getErrorMessage($error)
				];
			}, $this->result);
		} else if ($format !== 'debug') {
			throw new \InvalidArgumentException('Unknown format "' . $format . '".');
		}

		

		return $result;
	}
}