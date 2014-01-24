<?php
class ValidatorInTest extends PHPUnit_Framework_TestCase {
	public function testDefaultInstanceOptions () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'in', [
			'haystack' => [1]
		]);

		$this->assertCount(1, $test->getScript());
		$this->assertSame(['haystack' => [1], 'strict' => true, 'c14n' => true, 'recursive' => false, 'inverse' => false], $test->getScript()['foo'][0]['options']);
	}

	/**
	 * @dataProvider quasiStrictInProvider
	 */
	public function testQuasiStrictIn ($needle, $haystack) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'in', ['haystack' => [$haystack]]);
		
		$assessment = $test->assess(['foo' => $needle]);

		$this->assertCount(0, $assessment);
	}

	public function quasiStrictInProvider () {
		return [
			[123, 123],
			['123', 123]
		];
	}

	/**
	 * @dataProvider quasiStrictNotInProvider
	 */
	public function testQuasiStrictNotIn ($needle, $haystack) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'in', ['haystack' => [$haystack]]);
		
		$assessment = $test->assess(['foo' => $needle]);

		$this->assertCount(1, $assessment);
		$this->assertSame('not_in', $assessment[0]->getName());
	}

	public function quasiStrictNotInProvider () {
		return [
			[1, 123],
			['test', 123],
			//[123, '123']
		];
	}

	/**
	 * @dataProvider recursiveQuasiStrictInProvider
	 */
	public function testRecursiveQuasiStrictIn ($selector, $input) {
		$options = [
			'birth' => [
				'year' => range(date('Y') - 10, date('Y'))
			]
		];

		$test = new \gajus\vlad\Test();
		$test->assert($selector, 'in', ['haystack' => $options, 'recursive' => true]);

		$assessment = $test->assess($input);

		$this->assertCount(0, $assessment);
	}

	public function recursiveQuasiStrictInProvider () {
		return [
			[
				'birth[year]',
				[
					'birth' => [
						'year' => date('Y')
					]
				]
			]
		];
	}

	/**
	 * @dataProvider recursiveQuasiStrictNotInProvider
	 */
	public function testRecursiveQuasiStrictNotIn ($selector, $input) {
		$options = [
			'birth' => [
				'month' => range(1, 12)
			]
		];

		$test = new \gajus\vlad\Test();
		$test->assert($selector, 'in', ['haystack' => $options, 'recursive' => true]);

		$assessment = $test->assess($input);

		$this->assertCount(1, $assessment);
		$this->assertSame('not_in', $assessment[0]->getName());
	}

	public function recursiveQuasiStrictNotInProvider () {
		return [
			[
				'birth[month]',
				[
					'birth' => [
						'month' => 13
					]
				]
			]
		];
	}

	/**
	 * @dataProvider recursiveInverseQuasiStrictInProvider
	 */
	public function testRecursiveInverseQuasiStrictIn ($selector, $input) {
		$options = [
			'birth' => [
				'year' => array_flip(range(date('Y') - 10, date('Y')))
			]
		];

		$test = new \gajus\vlad\Test();
		$test->assert($selector, 'in', ['haystack' => $options, 'recursive' => true, 'inverse' => true]);

		$assessment = $test->assess($input);

		$this->assertCount(0, $assessment);
	}

	public function recursiveInverseQuasiStrictInProvider () {
		return [
			[
				'birth[year]',
				[
					'birth' => [
						'year' => date('Y')
					]
				]
			]
		];
	}

	/**
	 * @dataProvider recursiveInverseQuasiStrictNotInProvider
	 */
	public function testRecursiveInverseQuasiStrictNotIn ($selector, $input) {
		$options = [
			'birth' => [
				'month' => array_flip(range(1, 12))
			]
		];

		$test = new \gajus\vlad\Test();
		$test->assert($selector, 'in', ['haystack' => $options, 'recursive' => true, 'inverse' => true]);

		$assessment = $test->assess($input);

		$this->assertCount(1, $assessment);
		$this->assertSame('not_in', $assessment[0]->getName());
	}

	public function recursiveInverseQuasiStrictNotInProvider () {
		return [
			[
				'birth[month]',
				[
					'birth' => [
						'month' => [13 => 'Month that does not exist.']
					]
				]
			]
		];
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Selector path does not resolve an array within the haystack.
	 */
	public function testRecursiveQuasiStrictInNotResolved () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo[bar]', 'in', ['haystack' => [], 'recursive' => true]);

		$assessment = $test->assess(['foo' => ['bar' => 1]]);
	}

	/**
	 * @dataProvider strictInProvider
	 */
	public function testStrictIn ($needle, $haystack) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'in', [
			'haystack' => [$haystack],
			'c14n' => false
		]);

		$assessment = $test->assess(['foo' => $needle]);

		$this->assertCount(0, $assessment);
	}

	public function strictInProvider () {
		return [
			[1, 1],
			['test', 'test']
		];
	}

	/**
	 * @dataProvider testStrictNotInProvider
	 */
	public function testStrictNotIn ($needle, $haystack) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'in', [
			'haystack' => [$haystack],
			'c14n' => false
		]);

		$assessment = $test->assess(['foo' => $needle]);

		$this->assertSame('not_in', $assessment[0]->getName());
	}

	public function testStrictNotInProvider () {
		return [
			['123', 123],
			[123, '123'],
			[new stdClass, new stdClass]
		];
	}

	/**
	 * @dataProvider notStrictInProvider
	 */
	public function testNotStrictIn ($needle, $haystack) {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'in', [
			'haystack' => [$haystack],
			'strict' => false
		]);

		$assessment = $test->assess(['foo' => $needle]);

		$this->assertCount(0, $assessment);
	}

	public function notStrictInProvider () {
		return [
			[null, false],
			[100, true],
			['foo', true]
		];
	}
}