<?php
class TestTest extends PHPUnit_Framework_TestCase {
    public function testBuildTest () {
        return new \Gajus\Vlad\Test();
    }

    /**
     * @depends testBuildTest
     */
    public function testAssessEmptyTest (\Gajus\Vlad\Test $test) {
        $this->assertCount(0, $test->assess([]));
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
     * @depends testBuildTest
     */
    public function testAssessPassingAssertion (\Gajus\Vlad\Test $test) {
        $test
            ->assert('foo')
            ->is('String');

        $assessment = $test->assertion('foo', 'bar');

        $this->assertNull($assessment);
    }

    /**
     * @depends testBuildTest
     */
    public function testAssessFailingAssertion (\Gajus\Vlad\Test $test) {
        $test
            ->assert('foo')
            ->is('String');

        $assessment = $test->assertion('foo', []);

        $this->assertSame('Foo is not a string.', $assessment);
    }

    /**
     * @depends testBuildTest
     */
    public function testAssessPassingTest (\Gajus\Vlad\Test $test) {
        $test
            ->assert('foo')
            ->is('String');

        $assessment = $test->assess(['foo' => 'bar']);

        $this->assertCount(0, $assessment);
    }

    /**
     * @depends testBuildTest
     */
    public function testAssessFailingTest (\Gajus\Vlad\Test $test) {
        $test
            ->assert('foo')
            ->is('String');

        $assessment = $test->assess(['foo' => new \stdClass]);

        $this->assertCount(1, $assessment);
        $this->assertSame('Foo is not a string.', $assessment[0]);
    }
}