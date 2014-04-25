<?php
namespace Gajus\Vlad;

/**
 * Selector is the subject of the assertion, that is used to retrieve value from the Input.
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Selector {
    private
        $name;

    /**
     * @param string $name HTML input name, e.g. foo[bar].
     */
    public function __construct ($name) {
        $this->name = $name;
    }

    /**
     * @return string HTML input name.
     */
    public function getName () {
        return $this->name;
    }

    /**
     * @return array HTML input name represented in array, e.g. foo[bar][baz] becomes ['foo']['bar']['baz'].
     */
    public function getPath () {
        return explode('[', str_replace(']', '', $this->name));
    }
}