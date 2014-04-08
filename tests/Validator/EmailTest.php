<?php
class EmailTest extends PHPUnit_Framework_TestCase {
    public function testValidSyntax () {
        $validator = new \Gajus\Vlad\Validator\Email();

        $assessment = $validator->assess('test@gajus.com');

        $this->assertTrue($assessment);
    }

    /**
     * Since the underlying implementation is using PHP filter_var, there
     * is no reason to extensively test different (in)valid email addressses.
     */
    public function testInvalidSyntax () {
        $validator = new \Gajus\Vlad\Validator\Email();

        $assessment = $validator->assess('test');

        $this->assertFalse($assessment);
    }

    /**
     * @expectedException Gajus\Vlad\Exception\InvalidArgumentException
     * @expectedExceptionMessage Input is not a scalar value.
     */
    public function testNotScalarInput () {
        $validator = new \Gajus\Vlad\Validator\Email();

        $assessment = $validator->assess(null);
    }
}