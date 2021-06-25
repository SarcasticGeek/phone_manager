<?php

namespace App\Service;

use App\Entity\Country;

interface CustomerManagerInterface
{
    public function list(array $filters, int $page, int $limit);

    public function getCounty(string $phoneNumber): ?Country;
}