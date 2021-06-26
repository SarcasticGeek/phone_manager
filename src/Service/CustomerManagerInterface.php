<?php

namespace App\Service;

use App\Entity\Country;

interface CustomerManagerInterface
{
    /**
     * @param array $filters
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function list(array $filters, int $page, int $limit);

    /**
     * @param string $phoneNumber
     * @return Country|null
     */
    public function getCounty(string $phoneNumber): ?Country;
}
