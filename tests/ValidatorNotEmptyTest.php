<?php
class ValidatorNotEmptyTest extends PHPUnit_Framework_TestCase {
	public function testDefaultOptions () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'NotEmpty');

		$this->assertSame(['trim' => true], $test->getScript()['foo'][0]['options']);
	}

	/**
	 * @dataProvider testTrimEmptyInputProvider
	 */
	public function testTrimEmptyInput ($input) {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'NotEmpty');

		$assessment = $test->assess($input);

		$this->assertCount(1, $assessment);
		$this->assertSame('empty', $assessment[0]->getName());
	}

	public function testTrimEmptyInputProvider () {
		return [
			[ [] ],
			[ ['foo' => ''] ],
			[ ['foo' => '   '] ],
			[ ['foo' => 0] ],
			[ ['foo' => null] ]
		];
	}

	/**
	 * @dataProvider testTrimNotEmptyInputProvider
	 */
	public function testTrimNotEmptyInput ($input) {
		$test = new \Gajus\Vlad\Test();
		$test->assert('bar', 'NotEmpty');

		$assessment = $test->assess($input);

		$this->assertCount(0, $assessment);
	}

	public function testTrimNotEmptyInputProvider () {
		return [
			[ ['bar' => 'bar'] ],
			[ ['bar' => ['test']] ],
			[ ['bar' => 1] ],
			[ ['bar' => '0'] ]
		];
	}

	/**
	 * @dataProvider testNotTrimEmptyInputProvider
	 */
	public function testNotTrimEmptyInput ($input) {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'NotEmpty');

		$assessment = $test->assess($input, ['trim' => false]);

		$this->assertCount(1, $assessment);
		$this->assertSame('empty', $assessment[0]->getName());
	}

	public function testNotTrimEmptyInputProvider () {
		return [
			[ [] ],
			[ ['foo' => ''] ],
			[ ['foo' => 0] ],
			[ ['foo' => null] ]
		];
	}

	/**
	 * @dataProvider testNotTrimNotEmptyInputProvider
	 */
	public function testNotTrimNotEmptyInput ($input) {
		$test = new \Gajus\Vlad\Test();
		$test->assert('bar', 'NotEmpty', ['trim' => false]);

		$assessment = $test->assess($input);

		$this->assertCount(0, $assessment);
	}

	public function testNotTrimNotEmptyInputProvider () {
		return [
			[ ['bar' => ' '] ],
			[ ['bar' => 'bar'] ],
			[ ['bar' => ['test']] ],
			[ ['bar' => 1] ]
		];
	}


	public function testNotSupportedValue () {
		$test = new \Gajus\Vlad\Test();
		$test->assert('foo', 'NotEmpty');

		$assessment = $test->assess(['foo' => function () {}]);
	}
}