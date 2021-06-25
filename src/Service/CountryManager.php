<?php

namespace App\Service;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;

class CountryManager implements CountryManagerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(Country::class)->findAll();
    }
}