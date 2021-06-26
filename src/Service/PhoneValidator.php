<?php

namespace App\Service;

class PhoneValidator implements PhoneValidatorInterface
{
    /**
     * @param string $phoneNumber
     * @param string $countryCodeRegex
     * @return bool
     */
    public function valid(string $phoneNumber, string $countryCodeRegex): bool
    {
        return (bool) preg_match(sprintf('/%s/',$countryCodeRegex), $phoneNumber);
    }
}