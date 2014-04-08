<?php
class TestTest extends PHPUnit_Framework_TestCase {
    public function testBuildInput () {
        $_POST = [
            'foo' => 'bar',
            'baz' => new \stdClass
        ];

        return new \Gajus\Vlad\Input($_POST);
    }

    public function testBuildTest () {
        return new \Gajus\Vlad\Test();
    }

    /**
     * @depends testBuildInput
     * @depends testBuildTest
     */
    public function testAssessEmptyAssertion (\Gajus\Vlad\Input $input, \Gajus\Vlad\Test $test) {
        $this->assertCount(0, $test->assess($input));
    }

    /**
     * @depends testBuildTest
     */
    public function testBuildAssertion (\Gajus\Vlad\Test $test) {
        $assertion = $test->assert('foo');

        $this->assertInstanceOf('Gajus\Vlad\Assertion', $assertion);

        return $assertion;
    }

    /**
     * @depends testBuildInput
     * @depends testBuildTest
     */
    public function testAssessPassingAssertion (\Gajus\Vlad\Input $input, \Gajus\Vlad\Test $test) {
        $test
            ->assert('foo')
            ->is('String');

        $this->assertCount(0, $test->assess($input));
    }

    /**
     * @depends testBuildInput
     * @depends testBuildTest
     */
    public function testAssessFailingAssertion (\Gajus\Vlad\Input $input, \Gajus\Vlad\Test $test) {
        $test
            ->assert('baz')
            ->is('String');

        $assessment = $test->assess($input);

        $this->assertCount(1, $assessment);

        die(var_dump($assessment));
    }
}