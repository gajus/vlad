<?php
namespace Gajus\Vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Assertion {
    private
        $selector,
        $validator;

	public function __construct ($selector, Validator $validator) {
        $this->selector = $selector;
        $this->validator = $validator;
    }

    public function assess (Input $input) {
        $subject = $input->getSubject($this->selector);

        return $this->validator->assess($subject);
    }

    public function getSelector () {
        return $this->selector;
    }

    public function getValidator () {
        return $this->validator;
    }
}