<?php
namespace Gajus\Vlad\Validator;

/**
 * Validate that input value is not empty.
 * 
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class NotEmpty extends \Gajus\Vlad\Validator {
	static protected
        $default_options = [
            // Trim string values
            'trim' => true,
        ],
		$message = '{input.name} is empty.';

    public function __construct (array $options = []) {
        parent::__construct($options);

        $options = $this->getOptions();

        if (!is_bool($options['trim'])) {
            throw new \Gajus\Vlad\Exception\InvalidArgumentException('Boolean property assigned non-boolean value.');
        }
    }

	public function assess ($value) {
		$options = $this->getOptions();

        if ($value === '0') {
            return true;
        }

        return !(empty($value) || $options['trim'] && is_string($value) && !strlen(trim($value)));
	}
}