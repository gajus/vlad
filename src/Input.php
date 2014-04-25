<?php
namespace Gajus\Vlad;

/**
 * Input is the subject of the test. 
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Input {
    private
        $input;

    /**
     * @param array $input
     */
    public function __construct (array $input) {
        $this->input = $input;
    }

    /**
     * @param Gajus\Vlad\Selector $selector
     * @return mixed
     */
    public function getValue (\Gajus\Vlad\Selector $selector) {
        $value = $this->input;

        foreach ($selector->getPath() as $crumb) {
            if (array_key_exists($crumb, $value)) {
                $value = $value[$crumb];
            } else {
                $value = null;

                break;
            }
        }

        return $value;
    }
}