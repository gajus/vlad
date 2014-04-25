<?php
class LengthTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "length" option must be a whole number.
     */
    public function testInvalidLengthParameter () {
        new \Gajus\Vlad\Validator\Length(['length' => 'test']);
    }

    public function testExact () {
        $validator = new \Gajus\Vlad\Validator\Length(['length' => 3]);
        
        $assessment = $validator->assess('bar');

        $this->assertTrue($assessment);
    }

    public function testTooShort () {
        $validator = new \Gajus\Vlad\Validator\Length(['length' => 4]);
        
        $assessment = $validator->assess('bar');

        $this->assertFalse($assessment);
    }

    public function testTooLong () {
        $validator = new \Gajus\Vlad\Validator\Length(['length' => 2]);
        
        $assessment = $validator->assess('bar');

        $this->assertFalse($assessment);
    }
}