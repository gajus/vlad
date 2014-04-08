<?php
class RangeMaxInclusiveTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "range" option is required.
     */
    public function testMissingParameter () {
        new \Gajus\Vlad\Validator\RangeMaxInclusive();
    }

    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage Minimum boundry option must be numeric.
     */
    public function testInvalidRangeParameter () {
        new \Gajus\Vlad\Validator\RangeMaxInclusive(['range' => 'test']);
    }

    public function testMoreThanMax () {
        $validator = new \Gajus\Vlad\Validator\RangeMaxInclusive(['range' => 10]);

        $assessment = $validator->assess(11);

        $this->assertFalse($assessment);
    }

    public function testEqualToMax () {
        $validator = new \Gajus\Vlad\Validator\RangeMaxInclusive(['range' => 10]);

        $assessment = $validator->assess(10);

        $this->assertTrue($assessment);
    }

    public function testLessThanMax () {
        $validator = new \Gajus\Vlad\Validator\RangeMaxInclusive(['range' => 10]);
       
        $assessment = $validator->assess(9);

        $this->assertTrue($assessment);
    }
}