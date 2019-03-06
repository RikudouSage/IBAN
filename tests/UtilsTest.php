<?php

namespace Rikudou\Iban\Tests;

use PHPUnit\Framework\TestCase;
use Rikudou\Iban\Helper\Utils;

class UtilsTest extends TestCase
{
    public function testBcmod()
    {
        for ($i = 0; $i <= 1; $i++) {
            $forceCustomImplementation = !!$i;

            $this->assertEquals('1', Utils::bcmod(11, 2, $forceCustomImplementation));
            $this->assertEquals('3', Utils::bcmod('8728932001983192837219398127471', 7, $forceCustomImplementation));
            $this->assertEquals('663577', Utils::bcmod('87289320019831928372193981274715795247', 1145678, $forceCustomImplementation));
        }
    }

    public function testBcmodNonNumericDividend()
    {
        $this->expectException(\InvalidArgumentException::class);
        Utils::bcmod('test', 123);
    }

    public function testBcmodNonNumericDivisor()
    {
        $this->expectException(\InvalidArgumentException::class);
        Utils::bcmod(123, 't');
    }

    public function testBcmodTooBigDivisor()
    {
        $this->expectException(\InvalidArgumentException::class);
        Utils::bcmod(1, '87289320019831928372193981274715795247', true);
    }

    public function testBcmodNegativeNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        Utils::bcmod(-5, 1, true);
    }
}
