<?php

namespace App\Service;

interface PhoneValidatorInterface
{
    /**
     * @param string $phoneNumber
     * @param string $countryCodeRegex
     * @return bool
     */
    public function valid(string $phoneNumber, string $countryCodeRegex): bool;
}