<?php

namespace Rikudou\Iban\Tests;

use DivisionByZeroError;
use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\TestCase;
use Rikudou\Iban\Helper\Utils;

class UtilsTest extends TestCase
{
    public function testBcmod()
    {
        for ($i = 0; $i <= 2; $i++) {
            $this->assertEquals('1', Utils::bcmod(11, 2, 2 << $i));
            $this->assertEquals('3', Utils::bcmod('8728932001983192837219398127471', 7, 2 << $i));
            $this->assertEquals('663577', Utils::bcmod('87289320019831928372193981274715795247', 1145678, 2 << $i));
        }
    }

    public function testBcmodNonNumericDividend()
    {
        $this->expectException(InvalidArgumentException::class);
        Utils::bcmod('test', 123);
    }

    public function testBcmodNonNumericDivisor()
    {
        $this->expectException(InvalidArgumentException::class);
        Utils::bcmod(123, 't');
    }

    public function testBcmodTooBigDivisor()
    {
        $this->expectException(InvalidArgumentException::class);
        Utils::bcmod(1, '87289320019831928372193981274715795247', Utils::BCMOD_USE_CUSTOM);
    }

    public function testBcmodNegativeNumber()
    {
        $this->expectException(InvalidArgumentException::class);
        Utils::bcmod(-5, 1, true);
    }

    public function testBcmodLeadingZero()
    {
        for ($i = 0; $i < 3; $i++) {
            $this->assertEquals('1', Utils::bcmod('011', '02', 2 << $i));
        }
    }

    public function testInvalidForcedConfiguration()
    {
        $this->expectException(LogicException::class);
        Utils::bcmod('1', '1', 2 << 10);
    }

    public function testDivisionByZero()
    {
        $this->expectException(DivisionByZeroError::class);
        Utils::bcmod('1', '0');
    }

    public function testZeroDividend()
    {
        self::assertEquals('0', Utils::bcmod('0', '1', Utils::BCMOD_USE_CUSTOM));
        self::assertEquals('0', Utils::bcmod('0', '1', Utils::BCMOD_USE_BCMATH));
        self::assertEquals('0', Utils::bcmod('0', '1', Utils::BCMOD_USE_GMP));
    }
}
