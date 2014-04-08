<?php
class RangeMinInclusiveTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "range" option is required.
     */
    public function testMissingParameter () {
        new \Gajus\Vlad\Validator\RangeMinInclusive();
    }

    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage Minimum boundry option must be numeric.
     */
    public function testInvalidRangeParameter () {
        new \Gajus\Vlad\Validator\RangeMinInclusive(['range' => 'test']);
    }

    public function testMoreThanMin () {
        $validator = new \Gajus\Vlad\Validator\RangeMinInclusive(['range' => 10]);

        $assessment = $validator->assess(11);

        $this->assertTrue($assessment);
    }

    public function testEqualToMin() {
        $validator = new \Gajus\Vlad\Validator\RangeMinInclusive(['range' => 10]);

        $assessment = $validator->assess(10);

        $this->assertTrue($assessment);
    }

    public function testLessThanMin () {
        $validator = new \Gajus\Vlad\Validator\RangeMinInclusive(['range' => 10]);
       
        $assessment = $validator->assess(9);

        $this->assertFalse($assessment);
    }
}