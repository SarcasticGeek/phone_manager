<?php

namespace App\Service;

interface CountryManagerInterface
{
    /**
     * @return array
     */
    public function getAll(): array;
}
