<?php

namespace Rikudou\Iban\Tests;

use PHPUnit\Framework\TestCase;
use Rikudou\Iban\Iban\HungarianIbanAdapter;
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
}
