<?php

namespace Domain;

interface TokenValidator
{
    public static function isValidToken(?string $token): bool;
}