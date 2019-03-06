<?php

namespace Rikudou\Iban\Tests;

use PHPUnit\Framework\TestCase;
use Rikudou\Iban\Iban\IBAN;
use Rikudou\Iban\Validator\GenericIbanValidator;

class GenericIbanValidatorTest extends TestCase
{
    public function testIsValid()
    {
        foreach ($this->getIbans() as $iban) {
            $this->assertEquals($iban['valid'], (new GenericIbanValidator($iban['iban']))->isValid());
        }
    }

    private function getIbans()
    {
        return [
            [
                'iban' => new IBAN('CZ5530300000001325090010'),
                'valid' => true,
            ],
            [
                'iban' => new IBAN('CZ5530300000001325090011'),
                'valid' => false,
            ],
            [
                'iban' => new IBAN('CZ5530300000001325090012'),
                'valid' => false,
            ],
            [
                'iban' => new IBAN('CZ1327000000000500114004'),
                'valid' => true,
            ],
            [
                'iban' => new IBAN('CZ1327000000000500114005'),
                'valid' => false,
            ],
            [
                'iban' => new IBAN('CZ0307100010110017929051'),
                'valid' => true,
            ],
        ];
    }
}
