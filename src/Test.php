<?php
namespace Gajus\Vlad;

/**
 *
 * @link https://github.com/gajus/vlad for the canonical source repository
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
					'name' => get_class($validator),
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
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Validator name must be a string.');
		}

		if (strpos($validator_name, '\\') === false || strpos($validator_name, 'File\\') === 0 || strpos($validator_name, 'CreditCard\\') === 0) {
			$validator_name = 'Gajus\Vlad\Validator\\' . $validator_name;
		}
		
		if (!class_exists($validator_name)) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Validator not found "' . $validator_name . '".');
		} else if (!is_subclass_of($validator_name, 'Gajus\Vlad\Validator')) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Validator must extend Gajus\Vlad\Validator.');
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
					$error->translate($this->translator);

					$result[] = $error;

					break;
				}
			}
		}

		return $result;
	}
}