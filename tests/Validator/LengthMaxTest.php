<?php
class LengthMaxTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "length" option must be a whole number.
     */
    public function testInvalidLengthParameter () {
        new \Gajus\Vlad\Validator\LengthMax(['length' => 'test']);
    }

    public function testTooLong () {
        $validator = new \Gajus\Vlad\Validator\LengthMax(['length' => 2]);
        
        $assessment = $validator->assess('bar');

        $this->assertFalse($assessment);
    }

    public function testNotTooLong () {
        $validator = new \Gajus\Vlad\Validator\LengthMax(['length' => 3]);
        
        $assessment = $validator->assess('bar');

        $this->assertTrue($assessment);
    }
}