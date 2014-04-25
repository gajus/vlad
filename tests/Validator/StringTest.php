<?php
class StringTest extends PHPUnit_Framework_TestCase {
    public function testDefaultInstanceOptions () {
        $validator = new \Gajus\Vlad\Validator\String();
        
        $options = $validator->getOptions();

        $this->assertCount(1, $options);
        $this->assertSame(['strict' => false], $options);
    }

    /**
     * @dataProvider notStrictStringProvider
     */
    public function testNotStrictString ($value) {
        $validator = new \Gajus\Vlad\Validator\String();

        $assessment = $validator->assess($value);

        $this->assertTrue($assessment);
    }

    public function notStrictStringProvider () {
        return [
            [123],
            ['123'],
            [0x539]
        ];
    }

    /**
     * @dataProvider notStrictNotStringProvider
     */
    public function testNotStrictNotString ($value) {
        $validator = new \Gajus\Vlad\Validator\String();

        $assessment = $validator->assess($value);

        $this->assertFalse($assessment);
    }

    public function notStrictNotStringProvider () {
        return [
            [[]],
            [false],
            [true],
            [null],
            [new stdClass]
        ];
    }

    /**
     * @dataProvider strictStringProvider
     */
    public function testStrictString ($value) {
        $validator = new \Gajus\Vlad\Validator\String(['strict' => true]);

        $options = $validator->getOptions();

        $this->assertSame(['strict' => true], $options);

        $assessment = $validator->assess($value);

        $this->assertTrue($assessment);
    }

    public function strictStringProvider () {
        return [
            ['123']
        ];
    }

    /**
     * @dataProvider notStrictNotStringProvider
     */
    public function testStrictNotString ($value) {
        $validator = new \Gajus\Vlad\Validator\String();

        $assessment = $validator->assess($value);

        $this->assertFalse($assessment);
    }

    public function strictNotStringProvider () {
        return [
            [[]],
            [false],
            [true],
            [null],
            [new stdClass]
        ];
    }
}