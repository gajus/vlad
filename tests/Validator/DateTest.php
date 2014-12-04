<?php
class DateTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "format" property is required.
     */
    public function testInstantiatingWithoutRequiredParameterFormat () {
        $validator = new \Gajus\Vlad\Validator\Date();
    }

    public function testMatch () {
        $validator = new \Gajus\Vlad\Validator\Date(['format' => 'Y-m-d']);

        $assessment = $validator->assess('2015-01-01');

        $this->assertTrue($assessment);
    }

    public function testNoMatch () {
        $validator = new \Gajus\Vlad\Validator\Date(['format' => 'H:i']);
        
        $assessment = $validator->assess('2015-01-01');

        $this->assertFalse($assessment);
    }
}