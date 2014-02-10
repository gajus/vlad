<?php
class ValidatorCreditCardPanTest extends PHPUnit_Framework_TestCase {
    public function testNotDecimal () {
        $test = new \Gajus\Vlad\Test();

        $assessment = $test
            ->assert('foo', 'CreditCard\Pan')
            ->assess(['foo' => 'abc']);

        $this->assertCount(1, $assessment);
        $this->assertSame('not_decimal', $assessment[0]->getName());
    }

    public function testInvalidChecksum () {
        $test = new \Gajus\Vlad\Test();

        $assessment = $test
            ->assert('foo', 'CreditCard\Pan')
            ->assess(['foo' => '4111111111111112']);

        $this->assertCount(1, $assessment);
        $this->assertSame('invalid_checksum', $assessment[0]->getName());
    }

    /**
     * @dataProvider validPanProvider
     */
    public function testValidPan ($pan) {
        $test = new \Gajus\Vlad\Test();

        $assessment = $test
            ->assert('foo', 'CreditCard\Pan')
            ->assess(['foo' => $pan]);

        $this->assertCount(0, $assessment);
    }

    public function validPanProvider () {
        return [
            ['4111111111111111'], // visa
            ['378282246310005'], // amex
            ['5555555555554444'], // mastercard
            ['5020626008893627'] // maestro
        ];
    }
}