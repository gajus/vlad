<?php
class LengthMinTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "length" option must be a whole number.
     */
    public function testInvalidMinParameter () {
        new \Gajus\Vlad\Validator\LengthMin(['length' => 'test']);
    }

    public function testTooShort () {
        $validator = new \Gajus\Vlad\Validator\LengthMin(['length' => 10]);
        
        $assessment = $validator->assess('bar');

        $this->assertFalse($assessment);
    }

    public function testNotTooShort () {
        $validator = new \Gajus\Vlad\Validator\LengthMin(['length' => 3]);
        
        $assessment = $validator->assess('bar');

        $this->assertTrue($assessment);
    }
}