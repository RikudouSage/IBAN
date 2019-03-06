<?php

namespace Rikudou\Iban\Tests;

use PHPUnit\Framework\TestCase;
use Rikudou\Iban\Helper\ToStringIbanTrait;

class ToStringIbanTraitTest extends TestCase
{
    public function testValid()
    {
        $obj = new class() {
            use ToStringIbanTrait;

            public function asString(): string
            {
                return 'testString';
            }
        };

        $this->assertEquals('testString', strval($obj));
    }

    public function testInvalidNoMethod()
    {
        $obj = new class() {
            use ToStringIbanTrait;
        };

        $this->assertEquals('', strval($obj));
    }

    public function testInvalidExceptionThrown()
    {
        $obj = new class() {
            use ToStringIbanTrait;

            public function asString(): string
            {
                throw new \Exception();
            }
        };

        $this->assertEquals('', strval($obj));
    }
}
