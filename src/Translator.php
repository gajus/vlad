<?php
namespace Gajus\Vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Translator {
    private
        $validator_messages = [],
        $input_names = [];

    public function translateMessage (\Gajus\Vlad\Validator $validator, \Gajus\Vlad\Selector $selector) {
        $message = $this->getValidatorMessage(get_class($validator));

        $message = preg_replace_callback('/\{([a-z_\.]+)}/i', function ($e) use ($validator, $selector) {
            $path = explode('.', $e[1]);

            if ($path[0] === 'input' && $path[1] === 'name') {
                return $this->getInputName($selector);
            } else if ($path[0] === 'validator' && $path[1] === 'options') {
                $options = $validator->getOptions();

                if (isset($path[2]) && isset($options[$path[2]]) && is_scalar($options[$path[2]])) {
                    return $options[$path[2]];
                }
            }
            
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Unknown variable in error message.');
        }, $message);

        return $message;
    }

    public function setValidatorMessage ($validator_name, $message) {
        if (!is_string($validator_name)) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Validator name must be a string.');
        }

        if (strpos($validator_name, '\\') === false) {
            $validator_name = 'Gajus\Vlad\Validator\\' . $validator_name;
        }
        
        if (!class_exists($validator_name)) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Validator not found.');
        } else if (!is_subclass_of($validator_name, 'Gajus\Vlad\Validator')) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Validator must extend Gajus\Vlad\Validator.');
        }

        $this->validator_messages[$validator_name] = $message;
    }

    public function getValidatorMessage ($validator_name) {
        if (isset($this->validator_messages[$validator_name])) {
            return $this->validator_messages[$validator_name];
        }

        return $validator_name::getMessage();
    }

    /**
     * @param string $selector
     * @param string $name
     */
    public function setInputName ($selector, $name) {
        $this->input_names[$selector] = $name;
    }

    public function getInputName (\Gajus\Vlad\Selector $selector) {
        $input_name = $selector->getName();

        if (isset($this->input_names[$input_name])) {
            return $this->input_names[$input_name];
        }

        return $this->deriveSelectorName($selector);
    }

    /**
     * Convert array selector representation (['baz', 'foo_bar']) to
     * English friendly representation (Bar Foo Bar).
     *
     * If selector name is ends with "_id", then Id is dropped off the name.
     * 
     * @param Gajus\Vlad\Selector $selector
     * @return string
     */
    static public function deriveSelectorName (\Gajus\Vlad\Selector $selector) {
        $path = explode('_', implode('_', array_filter($selector->getpath())));

        if (count($path) > 1 && $path[count($path) -1] == 'id') {
            array_pop($path);
        }

        return ucwords(implode(' ', $path));
    }
}