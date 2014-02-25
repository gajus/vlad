<?php
namespace Gajus\Vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Assessment {
    private
        $errors = [],
        $data = [];

    public function __construct (Input $input, array $assertions) {
        foreach ($assertions as $assertion) {
            $error = $assertion->assess($input);
        }

        $input->getSubject($this->selector)
    }

    public function assess () {

    }

    /**
     * Return data that passed the validation.
     * Data is populad only when all assertions pass.
     *
     * @return array
     */
    public function getData () {

    }

    /**
     * Return error messages for assertions that did not pass.
     *
     * @return array
     */
    public function getMessages () {
        $messages = [];
    }
}