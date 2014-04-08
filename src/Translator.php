<?php
namespace Gajus\Vlad;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Translator {
	public function translateMessage ($message) {
		$message = preg_replace_callback('/\{vlad\.([a-z_\.]+)}/i', function ($e) {
			$path = explode('.', $e[1]);

			if ($path[0] === 'subject' && $path[1] === 'name') {
				return $subject->getName();
			} else if ($path[0] === 'validator' && $path[1] === 'options') {
				$options = $validator->getOptions();

				if (isset($path[2]) && isset($options[$path[2]]) && is_scalar($options[$path[2]])) {
					return $options[$path[2]];
				}
			}

			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Unknown variable in error message.');
		}, $message);

		die(var_dump( $message ));
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
	private function deriveSelectorName (\Gajus\Vlad\Selector $selector) {
		$path = explode('_', implode('_', $selector->getpath()));

		if (count($path) > 1 && $path[count($path) -1] == 'id') {
			array_pop($path);
		}

		return ucwords(implode(' ', $path));
	}
}