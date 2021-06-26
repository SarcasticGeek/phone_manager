<?php

namespace App\Tests\Service;

use App\Repository\CountryRepository;
use App\Service\CountryManager;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Mockery;
use PHPUnit\Framework\TestCase;

class CountryManagerTest extends TestCase
{
    public function testGetAll()
    {
        $repository = Mockery::mock(CountryRepository::class)
            ->makePartial()
            ->shouldReceive('findAll')
            ->once()
            ->andReturn([])
            ->getMock()
        ;

        $countryManager = Mockery::mock(CountryManager::class)
            ->makePartial()
            ->shouldReceive([
                'getRepository' => $repository
            ])
            ->once()
            ->getMock()
            ;

        $this->assertIsArray($countryManager->getAll());
    }

//    public function testGetRepository()
//    {
//        $managerRegistry = Mockery::mock(ManagerRegistry::class)
//            ->makePartial()
//            ->shouldReceive('getManagerForClass')
//            ->once()
//            ->getMock()
//        ;
//
//        $entityManager = Mockery::mock(EntityManager::class)
//            ->makePartial()
//            ->shouldReceive('getRepository')
//            ->once()
//            ->andReturn(new CountryRepository($managerRegistry))
//            ->getMock()
//        ;
//
//        $countryManager = Mockery::mock(CountryManager::class)
//            ->makePartial()
//            ->shouldReceive([
//                'getEntityManager' => $entityManager
//            ])
//            ->once()
//            ->getMock()
//        ;
//
//        $this->assertInstanceOf($countryManager->getRepository(), CountryRepository::class);
//    }
}
