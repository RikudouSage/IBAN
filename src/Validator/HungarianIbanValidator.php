<?php

namespace Rikudou\Iban\Validator;

/**
 * @see https://www.ecbs.org/Download/Tr201v3.9.pdf
 */
class HungarianIbanValidator implements ValidatorInterface
{
    private const WEIGHTS = [
        9,
        7,
        3,
        1,
    ];

    /** @var string */
    private $accountNumber;

    public function __construct(string $accountNumber)
    {
        $this->accountNumber = (string) preg_replace('/[\s\-]+/', '', $accountNumber);
    }

    public function isValid(): bool
    {
        if (!in_array(strlen($this->accountNumber), [16, 24])) {
            return false;
        }

        $fullAccountNumber = str_pad($this->accountNumber, 24, '0');

        $bankBranchPart = substr($fullAccountNumber, 0, 8);
        $accountNumberPart = substr($fullAccountNumber, 8);

        return $this->checkGroup($bankBranchPart)
            && $this->checkGroup($accountNumberPart);
    }

    private function checkGroup(string $group): bool
    {
        $length = strlen($group) - 1;
        $expectedChecksum = (int) substr($group, $length, 1);

        $sum = 0;
        for ($i = 0; $i < $length; $i++) {
            $weight = self::WEIGHTS[$i % count(self::WEIGHTS)];
            $sum += (int) $group[$i] * $weight;
        }

        $lastDigit = $sum % 10;
        if ($lastDigit === 0) {
            $lastDigit = 10;
        }

        $actualChecksum = 10 - $lastDigit;

        return $actualChecksum === $expectedChecksum;
    }
}
