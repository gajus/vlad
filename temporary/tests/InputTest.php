<?php
class InputTest extends PHPUnit_Framework_TestCase {
	public function testGetGetCachedSubject () {
		$input = new \Gajus\Vlad\Input([]);
		$subject1 = $input->getSubject('foo[bar]');
		$subject2 = $input->getSubject('foo[bar]');

		$this->assertSame($subject1, $subject2);
	}
}