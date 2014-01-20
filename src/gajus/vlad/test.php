<?php
namespace gajus\vlad;

/**
 *
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Test {
	private
		/**
		 * @var Translator
		 */
		$translator,
		/**
		 * @see Test::assert()
		 * @var array
		 */
		$script = [];

	/**
	 * @param Translator $translator
	 */
	final public function __construct (Translator $translator = null) {
		$this->translator = $translator === null ? new Translator(): $translator;
	}

	/**
	 * @return array
	 */
	public function getScript () {
		$script = [];

		foreach ($this->script as $selector => $validators) {
			foreach ($validators as $validator) {
				if (!isset($script[$selector])) {
					$script[$selector] = [];
				}

				$script[$selector][] = [
					'name' => strtolower(get_class($validator)),
					'options' => $validator->getOptions()
				];
			}
		}

		return $script;
	}

	/**
	 * 
	 * @param string $selector
	 * @param string $validator_name
	 * @param array $options
	 * @return Test
	 */
	public function assert ($selector, $validator_name, array $options = []) {
		if (!is_string($validator_name)) {
			throw new \InvalidArgumentException('Validator name must be a string.');
		}

		if (strpos($validator_name, '\\') === false) {
			$validator_name = 'gajus\vlad\validator\\' . $validator_name;
		}
		
		if (!class_exists($validator_name)) {
			throw new \InvalidArgumentException('Validator not found.');
		} else if (!is_subclass_of($validator_name, 'gajus\vlad\Validator')) {
			throw new \InvalidArgumentException('Validator must extend gajus\vlad\Validator.');
		}

		if (!isset($this->script[$selector])) {
			$this->script[$selector] = [];
		}

		$this->script[$selector][] = new $validator_name ($options);
		
		return $this;
	}

	/**
	 * Assess the test script against user input.
	 *
	 * @param array $input The input to run the test against. If null, defaults to $_POST.
	 * @return array Assessments that resulted in an error.
	 */
	public function assess (array $input = null) {
		if ($input === null) {
			$input = $_POST;
		}

		$input = new Input($input, $this->translator);
		
		$result = [];

		foreach ($this->script as $selector => $validators) {
			$subject = $input->getSubject($selector);

			foreach ($validators as $validator) {
				$error = $validator->assess($subject);

				if ($error) {
					$result[] = $error;

					break;
				}
			}
		}

		return $result;
	}
}