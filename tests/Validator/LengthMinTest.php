<?php
class LengthMinTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "min" option must be a whole number.
     */
    public function testInvalidMinParameter () {
        new \Gajus\Vlad\Validator\LengthMin(['min' => 'test']);
    }

    public function testTooShort () {
        $validator = new \Gajus\Vlad\Validator\LengthMin(['min' => 10]);
        
        $assessment = $validator->assess('bar');

        $this->assertFalse($assessment);
    }

    public function testNotTooShort () {
        $validator = new \Gajus\Vlad\Validator\LengthMin(['min' => 3]);
        
        $assessment = $validator->assess('bar');

        $this->assertTrue($assessment);
    }
}