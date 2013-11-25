<?php
namespace ay\vlad\rule;

class Length extends \ay\vlad\Rule {
	protected
		$options = [
			'min' => null,
			'max' => null
		],
		$messages = [
			'min' => '{vlad.input.options.name} must be at least {vlad.option.min} characters long.',
			'max' => '{vlad.input.options.name} must be at most {vlad.option.min} characters long.',
			'between' => '{vlad.input.options.name} must be between {vlad.option.min} and {vlad.option.max} characters long.',
		];

	protected function validate () {
		if (!is_string($this->value)) {
			throw new \InvalidArgumentException('Value is expected to be string. "' . gettype($this->value) . '" given instead.');
		}
		
		if (!isset($this->options['min']) && !isset($this->options['max'])) {
			throw new \BadMethodCallException('"min" and/or "max" option is required.');
		}
		
		if (isset($this->options['min']) && !is_numeric($this->options['min'])) {
			throw new \InvalidArgumentException('"min" option must be numeric.');
		}
		
		if (isset($this->options['max']) && !is_numeric($this->options['max'])) {
			throw new \InvalidArgumentException('"max" option must be numeric.');
		}
		
		if (isset($this->options['min'], $this->options['max']) && $this->options['min'] > $this->options['max']) {
			throw new \InvalidArgumentException('"min" option cannot be greater than "max".');
		}
		
		if (isset($this->options['min'], $this->options['max']) && ($this->value < $this->options['min'] || $this->value > $this->options['max'])) {
			$this->error_name = 'between';
		} else if (isset($this->options['min']) && $this->value < $this->options['min']) {
			$this->error_name = 'min';
		} else if (isset($this->options['max']) && $this->value > $this->options['max']) {
			$this->error_name = 'max';
		}
	}
}

