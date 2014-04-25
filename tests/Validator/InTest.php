<?php
class InTest extends PHPUnit_Framework_TestCase {
    public function testDefaultInstanceOptions () {
        $validator = new \Gajus\Vlad\Validator\In([
            'haystack' => [1]
        ]);

        $options = $validator->getOptions();

        $this->assertSame(['haystack' => [1], 'strict' => true, 'c14n' => true], $options);
    }

    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "haystack" option is missing.
     */
    public function testMissingHaystackOption () {
        new \Gajus\Vlad\Validator\In();
    }

    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "haystack" option must be an array.
     */
    public function testHaystackOptionNotArray () {
        new \Gajus\Vlad\Validator\In(['haystack' => (object) []]);
    }

    /**
     * @dataProvider quasiStrictInProvider
     */
    public function testQuasiStrictIn ($needle, $haystack) {
        $validator = new \Gajus\Vlad\Validator\In(['haystack' => [$haystack]]);
        
        $assessment = $validator->assess($needle);

        $this->assertTrue($assessment);
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
        $validator = new \Gajus\Vlad\Validator\In(['haystack' => [$haystack]]);

        $assessment = $validator->assess($needle);

        $this->assertFalse($assessment);
    }

    public function quasiStrictNotInProvider () {
        return [
            [1, 123],
            ['test', 123],
            //[123, '123']
        ];
    }

    /**
     * @dataProvider strictInProvider
     */
    public function testStrictIn ($needle, $haystack) {
        $validator = new \Gajus\Vlad\Validator\In([
            'haystack' => [$haystack],
            'c14n' => false
        ]);
        
        $assessment = $validator->assess($needle);

        $this->assertTrue($assessment);
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
        $validator = new \Gajus\Vlad\Validator\In([
            'haystack' => [$haystack],
            'c14n' => false
        ]);
        
        $assessment = $validator->assess($needle);

        $this->assertFalse($assessment);
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
        $validator = new \Gajus\Vlad\Validator\In([
            'haystack' => [$haystack],
            'strict' => false
        ]);
        
        $assessment = $validator->assess($needle);

        $this->assertTrue($assessment);
    }

    public function notStrictInProvider () {
        return [
            [null, false],
            [100, true],
            ['foo', true]
        ];
    }
}