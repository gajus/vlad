<?php
class RangeMinExclusiveTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "range" option is required.
     */
    public function testMissingParameter () {
        new \Gajus\Vlad\Validator\RangeMinExclusive();
    }

    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage Minimum boundary option must be numeric.
     */
    public function testInvalidRangeParameter () {
        new \Gajus\Vlad\Validator\RangeMinExclusive(['range' => 'test']);
    }

    public function testMoreThanMin () {
        $validator = new \Gajus\Vlad\Validator\RangeMinExclusive(['range' => 10]);

        $assessment = $validator->assess(11);

        $this->assertTrue($assessment);
    }

    public function testEqualToMin () {
        $validator = new \Gajus\Vlad\Validator\RangeMinExclusive(['range' => 10]);

        $assessment = $validator->assess(10);

        $this->assertFalse($assessment);
    }

    public function testLessThanMin () {
        $validator = new \Gajus\Vlad\Validator\RangeMinExclusive(['range' => 10]);
       
        $assessment = $validator->assess(10);

        $this->assertFalse($assessment);
    }
}