<?php

namespace Infrastructure\Http\Middleware\Token;

use Domain\TokenValidator;

class BalancedBracketsTokenValidator implements TokenValidator
{
    const COUPLES = [
        '(' => ')',
        '{' => '}',
        '[' => ']'
    ];

    public static function isValidToken(?string $token): bool
    {
        $stack = [];
        $chars = array_filter(str_split($token));
        foreach ($chars as $char) {
            if (self::isUnexpectedChar($char) || self::isNotMatchingClosure($char, $stack)) {
                return false;
            }            
            $stack = self::pushIfOpener($char, $stack);
            $stack = self::popOpenerIfMatchingClosure($char, $stack);
        }
        return empty($stack);
    }

    private static function isUnexpectedChar(string $char): bool
    {
        return !in_array(
            $char,
            array_merge(self::getOpeners(), self::getClosures())
        );
    }

    private function pushIfOpener(string $char, array $stack): array
    {
        if (self::isOpener($char)) {
            array_push($stack, $char);
        }
        return $stack;
    }
    
    private function popOpenerIfMatchingClosure(string $char, array $stack): array
    {
        if (self::isMatchingClosure($char, $stack)) {
            array_pop($stack);
        }
        return $stack;
    }

    private static function isOpener(string $char): bool
    {
        return in_array($char, self::getOpeners());
    }

    private static function isClosure(string $char): bool
    {
        return in_array($char, self::getClosures());
    }

    private static function getOpeners(): array
    {
        return array_keys(self::COUPLES);
    }

    private static function getClosures(): array
    {
        return array_values(self::COUPLES);
    }

    private static function isMatchingClosure(string $char, array $stack): bool
    {
        $lastOpener = array_pop($stack);
        return self::isClosure($char) && $lastOpener && ($char === self::COUPLES[$lastOpener]);
    }

    private static function isNotMatchingClosure(string $char, array $stack): bool
    {
        $lastOpener = array_pop($stack);
        return self::isClosure($char) && $lastOpener && ($char !== self::COUPLES[$lastOpener]);
    }
}
