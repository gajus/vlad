<?php
namespace ay\vlad;

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