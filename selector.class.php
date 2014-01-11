<?php
namespace ay\vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Selector {
	private
		$selector;

	public function __construct ($selector) {
		$this->selector = $selector;
	}

	public function getSelector () {
		return $this->selector;
	}

	public function getPath () {
		return explode('[', str_replace(']', '', $this->selector));
	}
}