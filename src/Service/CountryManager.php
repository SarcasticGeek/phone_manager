<?php

namespace App\Service;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CountryManager implements CountryManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->getRepository()
            ->findAll()
        ;
    }

    /**
     * @return CountryRepository
     */
    public function getRepository(): CountryRepository
    {
        return $this->getEntityManager()->getRepository(Country::class);
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}
