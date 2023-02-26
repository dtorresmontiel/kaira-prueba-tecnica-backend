<?php

namespace Tests\Unit\Http\Middleware\Token;

use Infrastructure\Http\Middleware\Token\BalancedBracketsTokenValidator;
use Tests\TestCase;

class BalancedBracketsTokenValidatorTest extends TestCase
{
    public function testEmptyTokenIsValid()
    {
        $token = "";
        $this->assertTrue(BalancedBracketsTokenValidator::isValidToken($token));
    }

    public function testUnexpectedCharsAreNotValid()
    {
        $token = "a";
        $this->assertFalse(BalancedBracketsTokenValidator::isValidToken($token));
    }

    /**
     * @dataProvider validTokens
     */
    public function testValidatesOkValidTokens(string $token)
    {
        $this->assertTrue(BalancedBracketsTokenValidator::isValidToken($token));
    }

    /**
     * @dataProvider invalidTokens
     */
    public function testValidationFailsOnInvalidTokens(string $token)
    {
        $this->assertFalse(BalancedBracketsTokenValidator::isValidToken($token));
    }

    /**
     * @return string[][]
     */
    public function validTokens(): array
    {
        return array_chunk(['{}', '{}[]()', '{([])}'], 1);
    }

    /**
     * @return string[][]
     */
    public function invalidTokens(): array
    {
        return array_chunk(['{)', '[{]}' , '(((((((()'], 1);
    }
}
