<?php
class IntegerTest extends PHPUnit_Framework_TestCase {
    public function testDefaultInstanceOptions () {
        $validator = new \Gajus\Vlad\Validator\Integer();
        
        $options = $validator->getOptions();

        $this->assertCount(1, $options);
        $this->assertSame(['strict' => false], $options);
    }

    /**
     * @dataProvider notStrictIntegerProvider
     */
    public function testNotStrictInteger ($value) {
        $validator = new \Gajus\Vlad\Validator\Integer();

        $assessment = $validator->assess($value);

        $this->assertTrue($assessment);
    }

    public function notStrictIntegerProvider () {
        return [
            [123],
            ['123'],
            [-123],
            ['-123']
        ];
    }

    /**
     * @dataProvider notStrictNotIntegerProvider
     */
    public function testNotStrictNotInteger ($value) {
        $validator = new \Gajus\Vlad\Validator\Integer();

        $assessment = $validator->assess($value);

        $this->assertFalse($assessment);
    }

    public function notStrictNotIntegerProvider () {
        return [
            [10.0],
            [-10.0],
            ['10.0'],
            ['-10.0']
        ];
    }

    /**
     * @dataProvider strictIntegerProvider
     */
    public function testStrictInteger ($value) {
        $validator = new \Gajus\Vlad\Validator\Integer(['strict' => true]);

        $options = $validator->getOptions();

        $this->assertSame(['strict' => true], $options);

        $assessment = $validator->assess($value);

        $this->assertTrue($assessment);
    }

    public function strictIntegerProvider () {
        return [
            [123]
        ];
    }

    /**
     * @dataProvider notStrictNotIntegerProvider
     */
    public function testStrictNotInteger ($value) {
        $validator = new \Gajus\Vlad\Validator\Integer();

        $assessment = $validator->assess($value);

        $this->assertFalse($assessment);
    }

    public function strictNotIntegerProvider () {
        return [
            ['100'],
            [100.0]
        ];
    }
}