<?php
class RegexTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage "pattern" property is required.
     */
    public function testInstantiatingWithoutRequiredParameterPattern () {
        $validator = new \Gajus\Vlad\Validator\Regex();
    }

    public function testMatch () {
        $validator = new \Gajus\Vlad\Validator\Regex(['pattern' => '/test/']);

        $assessment = $validator->assess('test');

        $this->assertTrue($assessment);
    }

    public function testNoMatch () {
        $validator = new \Gajus\Vlad\Validator\Regex(['pattern' => '/test/']);
        
        $assessment = $validator->assess('bar');

        $this->assertFalse($assessment);
    }

    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     */
    public function testBadPattern () {
        new \Gajus\Vlad\Validator\Regex(['pattern' => '/']);
    }
}