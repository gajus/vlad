<?php
class ValidatorInTest extends PHPUnit_Framework_TestCase {
	public function testDefaultInstanceOptions () {
		$test = new \gajus\vlad\Test();
		$test->assert('foo', 'in', [
			'haystack' => [1]
		]);

		$this->assertCount(1, $test->getTestScript());
		$this->assertSame(['haystack' => [1], 'strict' => true, 'c14n' => true, 'recursive' => false], $test->getTestScript()['foo'][0]['options']);
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
			[123, '123']
		];
	}

	/**
	 * @dataProvider recursiveQuasiStrictInProvider
	 */
	public function testRecursiveQuasiStrictIn ($selector, $input) {
		$options = [
			'birth' => [
				'year' => range(date('Y') - 100, date('Y'))
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