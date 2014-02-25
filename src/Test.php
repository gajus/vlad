<?php
namespace Gajus\Vlad;

/**
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
		 * @var array
		 */
		$assertions = [];

	/**
	 * @param Translator $translator
	 */
	final public function __construct (Translator $translator = null) {
		$this->translator = $translator === null ? new Translator(): $translator;
	}

	/**
	 * @param string $selector
     * @param string $validator
     * @return $this
	 */
	public function assert ($selector, $validator, array $options = []) {
		$validator = 'Gajus\Vlad\Validator\\' . $validator;

		$this->assertions[] = new Assertion ($selector, new $validator ($options));

		return $this;
	}

	/**
	 * @return Gajus\Vlad\Assessment
	 */
	public function assess (array $input = null) {
		if ($input === null) {
            $input = $_POST;
        }

        $input = new Input($input, $this->translator);

        return new Assessment($input, $this->assertions);
	}
}