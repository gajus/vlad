<?php
namespace ay\vlad;

class Error {
	private
		$name,
		$message;
		
	final public function __construct ($name, $message) {
		$this->name = $name;
		$this->message = $message;
	}

	public function getName () {
		return $this->name;
	}

	public function getMessage () {
		return $this->message;
	}
}