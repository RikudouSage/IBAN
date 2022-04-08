<?php

namespace Rikudou\Iban\Tests;

use PHPUnit\Framework\TestCase;
use Rikudou\Iban\Iban\HungarianIbanAdapter;
use Rikudou\Iban\Iban\IBAN;
use Rikudou\Iban\Validator\HungarianIbanValidator;

class HungarianIbanValidatorTest extends TestCase
{
    public function testIsValid()
    {
        foreach ($this->getAccounts() as $account) {
            try {
                $iban = new HungarianIbanAdapter($account['account']);
                $validator = new HungarianIbanValidator($iban);
                $this->assertEquals($account['valid'], $validator->isValid());
            } catch (\InvalidArgumentException $e) {
                $this->assertFalse($account['valid'], sprintf('Account number %s should have thrown an InvalidArgumentException, but it did not.', $account['account']));
            }
        }

        foreach ($this->getIbans() as $ibanAccount) {
            $iban = new IBAN(str_replace(' ', '', $ibanAccount['iban']));
            $validator = new HungarianIbanValidator($iban);
            $this->assertEquals($ibanAccount['valid'], $validator->isValid(), sprintf(
                'IBAN %s should have been %s but is %s.',
                $ibanAccount['iban'],
                $ibanAccount['valid'] ? 'valid' : 'invalid',
                $validator->isValid() ? 'valid' : 'invalid'
            ));
        }
    }

    private function getAccounts()
    {
        return [
            // short account
            [
                'account' => '11773016-11111018',
                'valid' => true,
            ],
            [
                'account' => '12092309-80000008',
                'valid' => true,
            ],
            // long account
            [
                'account' => '11773016-11111018-00000000',
                'valid' => true,
            ],
            [
                'account' => '12092309-00582130-00400001',
                'valid' => true,
            ],
            [
                'account' => '10918001-00000117-21150000',
                'valid' => true,
            ],
            // long account, spaces instead of dashes
            [
                'account' => '11773016 11111018 00000000',
                'valid' => true,
            ],
            // random invalid account
            [
                'account' => '12345678-00000005-87654321',
                'valid' => false,
            ],
            // wrong length
            [
                'account' => '11773016-11111018-0000001',
                'valid' => false,
            ],
            [
                'account' => '11773016 11111018 0000001',
                'valid' => false,
            ],
            [
                'account' => '11773016-11111018-000000015',
                'valid' => false,
            ],
            [
                'account' => '11773016-1111101',
                'valid' => false,
            ],
            [
                'account' => '1234',
                'valid' => false,
            ],
        ];
    }

    private function getIbans()
    {
        return [
            [
                'iban' => 'HU38 1091 8001 0000 0117 2115 0000',
                'valid' => true,
            ],
            // wrong length
            [
                'iban' => 'HU38 1091 8001 0000 0117 2115 000',
                'valid' => false,
            ],
            // not a hungarian IBAN
            [
                'iban' => 'CZ03 0710 0010 1100 1792 9051',
                'valid' => false,
            ],
        ];
    }
}
