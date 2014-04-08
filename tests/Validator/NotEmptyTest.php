<?php
class NotEmptyTest extends PHPUnit_Framework_TestCase {
    public function testDefaultOptions () {
        $validator = new \Gajus\Vlad\Validator\NotEmpty();

        $options = $validator->getOptions();
        
        $this->assertSame(['trim' => true], $options);
    }

    /**
     * @dataProvider testTrimEmptyInputProvider
     */
    public function testTrimEmptyInput ($input) {
        $validator = new \Gajus\Vlad\Validator\NotEmpty();
        
        $assessment = $validator->assess($input);

        $this->assertFalse($assessment);
    }

    public function testTrimEmptyInputProvider () {
        return [
            [''],
            ['   '],
            [0],
            [null]
        ];
    }

    /**
     * @dataProvider testTrimNotEmptyInputProvider
     */
    public function testTrimNotEmptyInput ($input) {
        $validator = new \Gajus\Vlad\Validator\NotEmpty();
        
        $assessment = $validator->assess($input);

        $this->assertTrue($assessment);
    }

    public function testTrimNotEmptyInputProvider () {
        return [
            ['bar'],
            [['test']],
            [1],
            ['0']
        ];
    }

    /**
     * @dataProvider testNotTrimEmptyInputProvider
     */
    public function testNotTrimEmptyInput ($input) {
        $validator = new \Gajus\Vlad\Validator\NotEmpty(['trim' => false]);
        
        $assessment = $validator->assess($input);

        $this->assertFalse($assessment);
    }

    public function testNotTrimEmptyInputProvider () {
        return [
            [null],
            [''],
            [0],
        ];
    }

    /**
     * @dataProvider testNotTrimNotEmptyInputProvider
     */
    public function testNotTrimNotEmptyInput ($input) {
        $validator = new \Gajus\Vlad\Validator\NotEmpty(['trim' => false]);
        
        $assessment = $validator->assess($input);

        $this->assertTrue($assessment);
    }

    public function testNotTrimNotEmptyInputProvider () {
        return [
            [' '],
            ['bar'],
            [['test']],
            [1]
        ];
    }
}