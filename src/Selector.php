<?php
namespace Gajus\Vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
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