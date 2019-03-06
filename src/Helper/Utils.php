<?php

namespace Rikudou\Iban\Helper;

class Utils
{
    public static function bcmod(string $dividend, string $divisor, bool $forceOwnImplementation = false): string
    {
        if (!is_numeric($dividend)) {
            throw new \InvalidArgumentException('The dividend must be a number');
        }
        if (!is_numeric($divisor)) {
            throw new \InvalidArgumentException('The divisor must be a number');
        }
        if (!function_exists('bcmod') || $forceOwnImplementation) {
            if (strval(intval($divisor)) !== $divisor) {
                throw new \InvalidArgumentException('The custom implementation does not support large numbers in divisor');
            }

            $mod = '';

            foreach (str_split($dividend) as $char) {
                if ($char === '-') {
                    throw new \InvalidArgumentException('The custom implementation of bcmod does not support negative numbers');
                }
                $mod = ($mod . $char) % $divisor;
            }

            return (string) $mod;
        }
        /* @noinspection PhpComposerExtensionStubsInspection */
        return bcmod($dividend, $divisor);
    }
}
