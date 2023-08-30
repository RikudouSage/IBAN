<?php

namespace Rikudou\Iban\Tests;

use PHPUnit\Framework\TestCase;
use Rikudou\Iban\Iban\SlovakIbanAdapter;
use Rikudou\Iban\Validator\ValidatorInterface;

class SlovakIbanAdapterTest extends TestCase
{
    public function testAccountsWithoutPrefix()
    {
        $accounts = [
            'SK47 7500 0000 0013 2509 0010' => [
                'acc' => '1325090010',
                'bank' => '7500',
            ],
            'SK26 0720 0000 0000 0398 3815' => [
                'acc' => '3983815',
                'bank' => '0720',
            ],
            'SK71 0200 0000 0013 2509 0061' => [
                'acc' => '1325090061',
                'bank' => '0200',
            ],
            'SK27 0900 0000 0002 8111 5217' => [
                'acc' => '281115217',
                'bank' => '0900',
            ],
            'SK67 5600 0000 0005 0011 4004' => [
                'acc' => '500114004',
                'bank' => '5600',
            ],
            'SK38 1100 0000 0029 0197 2682' => [
                'acc' => '2901972682',
                'bank' => '1100',
            ],
        ];

        foreach ($accounts as $iban => $accountData) {
            $iban = str_replace(' ', '', $iban);
            $this->assertEquals($iban, $this->getIban($accountData['acc'], $accountData['bank'])->asString());
            $this->assertEquals($iban, strval($this->getIban($accountData['acc'], $accountData['bank'])));
        }
    }

    public function testAccountsWithPrefix()
    {
        $accounts = [
            'SK98 7500 0010 1100 1792 9051' => [
                'acc' => '17929051',
                'bank' => '7500',
                'prefix' => '1011',
            ],
            'SK86 0720 0210 1200 2792 4051' => [
                'acc' => '27924051',
                'bank' => '0720',
                'prefix' => '21012',
            ],
        ];

        foreach ($accounts as $iban => $accountData) {
            $iban = str_replace(' ', '', $iban);
            $this->assertEquals($iban, $this->getIban($accountData['acc'], $accountData['bank'], $accountData['prefix'])->asString());
            $this->assertEquals($iban, strval($this->getIban($accountData['acc'], $accountData['bank'], $accountData['prefix'])));
        }
    }

    public function testGetValidator()
    {
        $this->assertInstanceOf(ValidatorInterface::class, $this->getIban(1325090010, 7500)->getValidator());
    }

    /**
     * @param string|int      $account
     * @param string|int      $bankCode
     * @param string|int|null $prefix
     *
     * @return SlovakIbanAdapter
     */
    private function getIban($account, $bankCode, $prefix = null): SlovakIbanAdapter
    {
        if (!is_null($prefix)) {
            $account = "{$prefix}-{$account}";
        }
        $ibanAdapter = new SlovakIbanAdapter($account, $bankCode);

        return $ibanAdapter;
    }
}
