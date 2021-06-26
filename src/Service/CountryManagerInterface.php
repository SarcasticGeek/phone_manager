<?php

namespace App\Service;

use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;

interface CountryManagerInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @return CountryRepository
     */
    public function getRepository(): CountryRepository;

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface;
}
