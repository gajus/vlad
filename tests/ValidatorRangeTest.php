<?php
class ValidatorRangeTest extends PHPUnit_Framework_TestCase {
	/**
	 * @expectedException BadMethodCallException
	 */
	public function testMissingRequiredParameter () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'range');
	}
}