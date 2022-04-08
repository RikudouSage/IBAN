<?php

namespace Rikudou\Iban\Tests;

use PHPUnit\Framework\TestCase;
use Rikudou\Iban\Iban\HungarianIbanAdapter;
use Rikudou\Iban\Validator\ValidatorInterface;

class HungarianIbanAdapterTest extends TestCase
{
    public function testAccountsWithoutPrefix()
    {
        $accounts = [
            // same account, different formats
            '11773016-11111018' => 'HU42 1177 3016 1111 1018 0000 0000',
            '11773016 11111018' => 'HU42 1177 3016 1111 1018 0000 0000',
            '1177301611111018' => 'HU42 1177 3016 1111 1018 0000 0000',
            '11773016-11111018-00000000' => 'HU42 1177 3016 1111 1018 0000 0000',
            '11773016 11111018 00000000' => 'HU42 1177 3016 1111 1018 0000 0000',
            '117730161111101800000000' => 'HU42 1177 3016 1111 1018 0000 0000',

            '12092309-80000008' => 'HU43 1209 2309 8000 0008 0000 0000',
            '12092309-80000008-00000000' => 'HU43 1209 2309 8000 0008 0000 0000',
            '12092309-00582130-00400001' => 'HU49 1209 2309 0058 2130 0040 0001',
            '10918001-00000117-21150000' => 'HU38 1091 8001 0000 0117 2115 0000',
            '00000000-11111018' => 'HU88 0000 0000 1111 1018 0000 0000',
        ];

        foreach ($accounts as $account => $iban) {
            $iban = str_replace(' ', '', $iban);

            $this->assertEquals($iban, $this->getAdapter($account)->asString());
            $this->assertEquals($iban, strval($this->getAdapter($account)));
        }
    }

    public function testGetValidator()
    {
        $this->assertInstanceOf(ValidatorInterface::class, $this->getAdapter(1325090010, 3030)->getValidator());
    }

    /**
     * @param string $account
     *
     * @return HungarianIbanAdapter
     */
    private function getAdapter(string $account): HungarianIbanAdapter
    {
        return new HungarianIbanAdapter($account);
    }
}
