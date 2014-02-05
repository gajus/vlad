<?php
class ValidatorEmailTest extends PHPUnit_Framework_TestCase {
	public function testValidSyntax () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'email');

		$assessment = $test->assess(['foo' => 'vlad@test.com']);

		$this->assertCount(0, $assessment);
	}

	/**
	 * Since the underlying implementation is using PHP filter_var, there
	 * is no reason to extensively test different (in)valid email addressses.
	 */
	public function testInvalidSyntax () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'email');

		$assessment = $test->assess(['foo' => 'vlad']);

		$this->assertCount(1, $assessment);
		$this->assertSame('invalid_syntax', $assessment[0]->getName());
	}

	/**
	 * @expectedException gajus\vlad\exception\Invalid_Argument_Exception
	 * @expectedExceptionMessage Input is not a scalar value.
	 */
	public function testNotScalarInput () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'email');

		$assessment = $test->assess(['foo' => null]);
	}
}